<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EanLookupControllerTest extends TestCase
{
    public function testItCanLookupEan()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->get('ean-lookup/5027035022734')
            ->assertOk()
            ->assertJson([
                'name' => '[REC]',
                'ean' => '5027035022734',
            ]);
    }
}
