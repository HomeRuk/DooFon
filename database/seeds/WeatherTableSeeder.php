<?php

use Illuminate\Database\Seeder;

class WeatherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wt1 = new App\Weather();
        $wt1->temp = 31.5;
        $wt1->humidity = 55.1;
        $wt1->dewpoint = 21.5;
        $wt1->pressure = 1001.5;
        $wt1->light = 200;
        $wt1->rain = 0;
        $wt1->SerialNumber = "0123456789";
        $wt1->save();
        
        $wt2 = new App\Weather();
        $wt2->temp = 31.5;
        $wt2->humidity = 55.1;
        $wt2->dewpoint = 21.5;
        $wt2->pressure = 1001.5;
        $wt2->light = 200;
        $wt2->rain = 0;
        $wt2->SerialNumber = "A123456789";
        $wt2->save();
    }
}
