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
        $dv1->SerialNumber = "0123456789";
        $dv1->save();
        
        $dv2 = new App\Device();
        $dv2->SerialNumber = "A123456789";
        $dv2->save();
    }
}
