<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->name = "Ruk";
        $user1->email = "5605104046@live4.utcc.ac.th";
        $user1->password = bcrypt('123456');
        $user1->save();   
    }
}
