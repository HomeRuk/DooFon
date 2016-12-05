<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelPredictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelpredict', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file')->unique()->collate('utf8_bin');
            $table->String('modelname');
            $table->enum('mode', ['1', '2'])
                    ->default('1');
            $table->float('exetime', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('modelpredict');
    }
}
