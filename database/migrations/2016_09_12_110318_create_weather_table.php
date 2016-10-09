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
            $table->float('temp',5,2);
            $table->float('humidity',5,2);
            $table->float('dewpoint',5,2);
            $table->float('pressure',6,2);
            $table->integer('light')->unsigned();
            $table->enum('rain', ['0', '1']);
			$table->float('PredictPercent',5,2)->nullable();
            $table->enum('PredictStatus', ['0', '1'])->default('0');
            $table->String('SerialNumber',10);
            $table->foreign('SerialNumber')->references('SerialNumber')->on('device')->collate('utf8_bin');
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
