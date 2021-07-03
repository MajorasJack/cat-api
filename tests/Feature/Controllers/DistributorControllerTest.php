<?php

namespace Tests\Feature\Controllers;

use App\Models\Distributor;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DistributorControllerTest extends TestCase
{
    public function testItCanSuccessfullyReturnDistributors()
    {
        Distributor::factory()->count(5)->create();

        Passport::actingAs(User::factory()->create());

        $this->get(route('distributors.index'))
            ->assertOk()
            ->assertJsonStructure([
                [
                    'title'
                ]
            ]);
    }
}
