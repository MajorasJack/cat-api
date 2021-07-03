<?php

namespace App\Modules\EanLookup\Repositories;

use App\Modules\EanLookup\Interfaces\EanLookupInterface;
use App\Modules\EanLookup\Entities\EanProduct;

class EanScraperRepository implements EanLookupInterface
{
    public function find(int $ean): EanProduct
    {
        return new EanProduct(
            '[REC]',
            5027035022734
        );
    }
}
