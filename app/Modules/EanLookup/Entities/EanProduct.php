<?php

namespace App\Modules\EanLookup\Entities;

use JsonSerializable;

class EanProduct
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $ean;

    /**
     * @param string $name
     * @param int $ean
     */
    public function __construct(string $name, int $ean)
    {
        $this->name = $name;
        $this->ean = $ean;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEan()
    {
        return $this->ean;
    }
}
