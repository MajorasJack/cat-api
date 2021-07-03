<?php


namespace Tests\Feature\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    public function testItReturnsUserAsExpected()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $this->get(route('me.index'))
            ->assertOk()
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => Carbon::parse($user->email_verified_at)->toISOString(),
                'updated_at' => Carbon::parse($user->updated_at)->toISOString(),
                'created_at' => Carbon::parse($user->created_at)->toISOString(),
                'id' => $user->id,
            ]);
    }
}
