<?php

use Illuminate\Database\Seeder;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dv1 = new App\Device();
        $dv1->SerialNumber = "ATd4YVmd8B";
        $dv1->save();
        
        $dv2 = new App\Device();
        $dv2->SerialNumber = "ZgkL2LfL0Q";
        $dv2->save();
    }
}
