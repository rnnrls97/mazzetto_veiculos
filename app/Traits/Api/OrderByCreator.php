<?php

namespace App\Traits\Api;

trait OrderByCreator
{
    public function createOrderBy($model, $sort_by, $sort_type = "asc")
    {
        if ($sort_by) {
            $model->orderBy($sort_by, $sort_type);
        }

        return $model;
    }
}
