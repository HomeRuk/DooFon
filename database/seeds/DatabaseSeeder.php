<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DeviceTableSeeder::class);
        $this->call(WeatherTableSeeder::class);
        $this->call(Model_PredictTableSeeder::class);
    }
}
