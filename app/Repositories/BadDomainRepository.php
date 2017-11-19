<?php

namespace App\Repositories;

use App\Models\BadDomain;

class BadDomainRepository extends AbstractRepository
{
    public function __construct(BadDomain $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }
}