<?php

namespace App\Models;

use App\Utils\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public static $columns = ['id', 'ip', 'ua', 'ref', 'param1', 'param2', 'error', 'bad_domain'];

    public static function create($ip, $userAgent, $ref, $param1, $param2): self
    {
        $click = new self();
        $click->id = UuidGenerator::generate();
        $click->ip = $ip;
        $click->ua = $userAgent;
        $click->ref = !empty($ref) ? $ref : '';
        $click->param1 = $param1;
        $click->param2 = $param2;

        return $click;
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}