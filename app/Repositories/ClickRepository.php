<?php

namespace App\Repositories;

use App\Models\Click;

class ClickRepository extends AbstractRepository
{
    public function __construct(Click $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function search($column, $direction, $searchColumn, $searchInput)
    {
        $query = $this->model->orderBy($column, $direction);

        if(!empty($searchColumn) && !empty($searchInput)) {
            if($searchColumn == 'error' || $searchColumn == 'bad_domains') {
                $query = $query->where($searchColumn, $searchInput);
            }
            $query = $query->where($searchColumn, 'LIKE', '%' . $searchInput . '%');
        }

        return $query->get();
    }
}