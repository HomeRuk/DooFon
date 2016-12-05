<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('weather', function (Blueprint $table) {
            $table->increments('id');
            $table->float('temp', 5, 2);
            $table->float('humidity', 5, 2);
            $table->float('dewpoint', 5, 2);
            $table->float('pressure', 6, 2);
            $table->unsignedInteger('light');
            $table->enum('rain', ['0', '1'])
                    ->default('0');
            $table->float('PredictPercent', 5, 2)
                    ->nullable();
            $table->enum('TrainStatus', ['0', '1'])
                    ->default('0');
            $table->enum('PredictMode', ['1', '2'])
                    ->nullable();
            $table->String('SerialNumber', 10)
                    ->notnull();
            $table->foreign('SerialNumber')
                    ->references('SerialNumber')
                    ->on('device')
                    ->onDelete('cascade')
                    ->collate('utf8_bin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('weather');
    }

}
