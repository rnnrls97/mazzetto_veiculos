<?php

namespace App\Services;

use App\Traits\Api\PaginateCreator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditTableService
{

    use PaginateCreator;


    /**
     * @param array $structureToTranform
     * @param array $data
     * @return array
     */
    public static function prepareAuditData(array $structureToTranform, array $data, Model $model, String $nameModel): array
    {
        try {

            Arr::set($data, 'tags',  $nameModel);

            foreach ($structureToTranform as $structure) {
                $sourceModel = $structure['model'] ?? $structure;

                if (!class_exists($sourceModel)) {
                    return $data;
                }

                $key = $structure['key'] ?? strtolower(class_basename($sourceModel));
                $attribute = self::getAttribute($key);

                $columnName = $structure['columnName'] ?? 'description' ?? 'name';

                if (Arr::has($data, 'new_values.' . $attribute)) {
                    $new_values = $sourceModel::find($model->getAttribute($attribute))[$columnName];
                    $old_values = $sourceModel::find($model->getOriginal($attribute))[$columnName] ?? false;

                    $data['new_values'][$key . '_name'] = $new_values;

                    if ($old_values) {
                        $data['old_values'][$key . '_name'] = $old_values;
                    }
                }
            }


            return $data;
        } catch (\Exception $e) {
            Log::alert($e->getFile() . " => " . $e->getLine() . " => " . $e->getMessage());

            return $data;
        }
    }

    private static function getAttribute($model)
    {
        return self::camelCaseToUnderscore($model) . '_id';
    }

    private static function camelCaseToUnderscore($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }


    public function filterAudit(Builder $query, Request $request)
    {

        $filters = $request->filters ?? [];

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where(function ($query) use ($key, $value) {
                    if ($key === 'json_description') {
                        return;
                    }

                    if ($key === 'id') {
                        $query->where('audits.id', $value);
                    } else if ($key === 'users') {
                        $query->where('users.full_name', 'like', '%' . $value . '%');
                    } else {
                        $query->where($key, $value)->orWhere($key, 'like', '%' . $value . '%');
                    }
                });
            }
        }




        return $query
            // ->when(!empty($request->date), function ($query) use ($request) {
            //     if (count($request->date) === 2) {
            //         // Defina a hora para "00:00:00" para o início e o fim do período
            //         $startDate = date('Y-m-d 00:00:00', strtotime($request->date[0]));
            //         $endDate = date('Y-m-d 23:59:59', strtotime($request->date[1]));

            //         return $query->whereBetween('audits.created_at', [$startDate, $endDate]);
            //     } else {
            //         // Defina a hora para "00:00:00" para a data única
            //         $startDate = date('Y-m-d 00:00:00', strtotime($request->date[0]));

            //         return $query->whereDate('audits.created_at', $startDate);
            //     }
            // })
            ->when(!empty($request->search), function ($query) use ($request) {

                // $search = iconv('UTF-8', 'ASCII//TRANSLIT', $request->search);

                $query->where(function ($query) use ($request) {

                    $event = $this->getEvent($request->search);

                    $query->where('audits.tags', 'like', '%' . $request->search . '%');
                    $query->orWhere('users.full_name', 'like', '%' . $request->search . '%');
                    $query->orWhere('audits.ip_address', 'like', '%' . $request->search . '%');

                    if (is_numeric($request->search)) {
                        $query->orWhere('audits.id', $request->search);
                    }

                    if ($event) {
                        $query->orWhere('audits.event', $event);
                    }
                });
            })
            ->selectRaw("audits.*, users.full_name")
            ->orderBy('created_at', 'desc');
    }

    public function filterAuditJson(Builder $query, Request $request)
    {

        $searchTerm = iconv('UTF-8', 'ASCII//TRANSLIT', $request->search);

        // Convert the collection to an array
        $jsonSearchResultsArray = $query->get()->filter(function ($audit) use ($searchTerm) {
            $jsonOld = json_decode(json_encode($audit->old_values), true);
            $jsonNew = json_decode(json_encode($audit->new_values), true);
            return isset($jsonOld[$searchTerm]) || (isset($jsonNew[$searchTerm]) ?? false);
        })->toArray();

        if (count($jsonSearchResultsArray) == 0) {

            $query->when(!empty($request->search), function ($query) use ($request) {

                $searchTerm = iconv('UTF-8', 'ASCII//TRANSLIT', $request->search);

                return $query->where(function ($subquery) use ($searchTerm) {
                    $subquery->whereRaw('UNACCENT(users.full_name) like ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('UNACCENT(audits.tags) like ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('UNACCENT(units.description) like ?', ['%' . $searchTerm . '%']);


                    if (is_numeric($searchTerm)) {
                        $subquery->orWhere('audits.id', $searchTerm);
                    }
                });
            });

            $audittable = $this->createPaginate($query, $request->paginate);

            return $audittable;
        }

        $jsonSearchResultsPaginated = new Paginator(array_values($jsonSearchResultsArray), 10);

        return $jsonSearchResultsPaginated;
    }


    public function applyUnaccent($query, $column, $search)
    {
        $dbDriver = DB::connection()->getDriverName();

        if ($dbDriver === 'pgsql') {
            return $query->orWhereRaw('UNACCENT(' . $column . ') LIKE ?', ['%' . $search . '%']);
        } elseif ($dbDriver === 'mysql') {
            return $query->orWhereRaw($column . ' COLLATE utf8_general_ci LIKE ?', ['%' . $search . '%']);
        }
    }

    public function getEvent($search)
    {
        $event = [
            'Criação' => 'created',
            'Edição' => 'updated',
            'Remoção' => 'deleted',
        ];

        return $event[$search] ?? false;
    }
}
