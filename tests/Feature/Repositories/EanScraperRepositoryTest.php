<?php

namespace Tests\Feature\Controllers;

use App\Modules\EanLookup\Repositories\EanScraperRepository;
use App\Modules\EanLookup\Entities\EanProduct;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EanScraperRepositoryTest extends TestCase
{
    /**
     * @dataProvider eanProvider
     */
    public function testItCanLookupEan(int $ean, string $name)
    {
        $repository = app(EanScraperRepository::class);

        $expected = new EanProduct($name, $ean);

        $this->assertEquals($expected, $repository->find($ean));
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
