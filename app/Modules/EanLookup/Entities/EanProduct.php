<?php

namespace App\Modules\EanLookup\Entities;

use JsonSerializable;

class EanProduct implements JsonSerializable
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

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'ean' => $this->ean,
        ];
    }
}
