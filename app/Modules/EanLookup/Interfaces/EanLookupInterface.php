<?php

namespace App\Modules\EanLookup\Interfaces;

use App\Modules\EanLookup\Entities\EanProduct;

interface EanLookupInterface
{
    public function find(int $ean): EanProduct;
}
