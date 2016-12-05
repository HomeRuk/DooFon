<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('device', function (Blueprint $table) {
            $table->String('SerialNumber', 10)
                    ->primary()
                    ->collate('utf8_bin');
            $table->String('FCMtoken')
                    ->unique()
                    ->nullable();
            $table->double('latitude')
                    ->default('0');
            $table->double('longitude')
                    ->default('0');
            $table->unsignedInteger('threshold')
                    ->default('70');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('device');
    }

}
