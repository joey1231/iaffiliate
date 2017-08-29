<?php

use Illuminate\Database\Seeder;
use App\User;
class CreateUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
            'name' => 'Yang Wei',
            'email' => 'yetiwz@gmail.com',
            'password' => bcrypt('password1234'),
        ]);
        User::create([
            'name' => 'Joey dingcong',
            'email' => 'joeydngcng1233@gmail.com',
            'password' => bcrypt('joey1231'),
        ]);
    }
}
