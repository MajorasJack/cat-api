<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EanLookupControllerTest extends TestCase
{
    /**
     * @dataProvider eanProvider
     */
    public function testItCanLookupEan(int $ean, string $name)
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->get('ean-lookup/' . $ean)
            ->assertOk()
            ->assertJson([
                'name' => $name,
                'ean' => $ean,
            ]);
    }

    public function eanProvider()
    {
        return [
            [
                5027035022734,
                '[Rec]',
            ],
            [
                5039036042871,
                'Wrong Turn 3 - Left for Dead',
            ],
            [
                760137200093,
                'Feature Film - Killer Campout',
            ],
            [
                7321900987127,
                'Ginger Snaps Back - The Beginning',
            ],
        ];
    }
}
