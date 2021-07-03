<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Distributor::create([
            'title' => 'Arrow Video',
        ]);

        Distributor::create([
            'title' => 'Tartan Cinema/Films',
        ]);

        Distributor::create([
            'title' => 'Tartan Asia Extreme',
        ]);

        Distributor::create([
            'title' => 'Grindhouse',
        ]);

        Distributor::create([
            'title' => 'Universal Studios',
        ]);

        Distributor::create([
            'title' => 'Lionsgate',
        ]);

        Distributor::create([
            'title' => '88 Films',
        ]);

        Distributor::create([
            'title' => 'Sony Pictures',
        ]);

        Distributor::create([
            'title' => 'Signature',
        ]);

        Distributor::create([
            'title' => 'Studio Canal',
        ]);

        Distributor::create([
            'title' => 'XT Video',
        ]);
    }

}
