<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->String('SerialNumber',10)->primary()->collate('utf8_bin');;
            $table->String('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->double('threshold',5,2)->nullable();
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
       Schema::drop('device');
    }
}
