<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('weather', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('temp',5,2);
            $table->decimal('humidity',5,2);
            $table->decimal('dewpoint',5,2);
            $table->decimal('pressure',6,2);
            $table->integer('light')->unsigned();
            $table->enum('rain', ['0', '1']);
            $table->String('SerialNumber',10);
            $table->foreign('SerialNumber')->references('SerialNumber')->on('device');
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
        Schema::drop('weather');
    }
}
