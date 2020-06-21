<?php

use Illuminate\Database\Seeder;
use \App\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'William Galas',
            'email'=>'admin@admin.com',
            'password'=>Hash::make('admin1234')
        ]);
    }
}
