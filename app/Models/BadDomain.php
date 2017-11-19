<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadDomain extends Model 
{
    public $timestamps = false;

    public static function create($name): self
    {
        $domain = new self();
        $domain->name = $name;

        return $domain;
    }

    public function changeName($name)
    {
        $this->name = $name;
    }
}