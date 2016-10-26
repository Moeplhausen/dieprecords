<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $password='test';
        if (!App::isLocal()){
            $password=str_random(40);
        }

        DB::table('users')->insert(
            ['name'=>"admin",
            'email'=>"test@example.com",
            'password'=>Hash::make($password),
            'enabled'=>App::isLocal(),
            ]);
    }
}
