<?php

use App\Models\User;
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
        User::create([
            'name' => 'Jack',
            'email' => 'jack@gengar.me',
            'password' => Hash::make('secret'),
        ]);

        User::create([
            'name' => 'Hannah',
            'email' => 'hannah.tinkler@gmail.com',
            'password' => Hash::make('secret'),
        ]);
    }
}
