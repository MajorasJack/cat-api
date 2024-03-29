<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListType;

class ListTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        ListType::create([
            'title' => 'Favourites',
            'created_by' => 1,
        ]);

        ListType::create([
            'title' => 'Priority',
            'created_by' => 1,
        ]);
    }
}
