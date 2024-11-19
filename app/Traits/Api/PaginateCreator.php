<?php

namespace App\Traits\Api;

trait PaginateCreator
{
    public function createPaginate($model, $paginate = null, $user = null)
    {
        if ($paginate == 'Todas') {
            return $model->paginate($model->count());
        }

        if (($paginate && ($paginate > 0 && $paginate <= 100)) || ($paginate && (bool)$user->isAdmin())) {
            return $model->paginate($paginate);
        }
        return $model->paginate(20);
    }
}
