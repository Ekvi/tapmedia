<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('ua', 100);
            $table->string('ip', 50);
            $table->string('ref', 255);
            $table->string('param1', 255);
            $table->string('param2', 255);
            $table->integer('error')->unsigned()->default(0);
            $table->integer('bad_domain')->unsigned()->default(0);

            $table->index(['ua', 'ip', 'ref', 'param1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
