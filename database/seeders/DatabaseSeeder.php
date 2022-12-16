<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = "fariz";
        $user->name = "Fariz";
        $user->email = "nizaralfariziakbar10@gmail.com";
        $user->password = Hash::make('password');
        $user->save();

        // \App\Models\User::factory(10)->create();
    }
}
