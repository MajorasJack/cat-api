<?php

namespace App\Http\Controllers;

use App\Modules\EanLookup\Interfaces\EanLookupInterface;
use Illuminate\Http\Request;

class EanLookupController extends Controller
{
    /**
     * @param EanLookupInterface $eanLookup
     */
    public function __construct(EanLookupInterface $eanLookup)
    {
        $this->eanLookup = $eanLookup;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function show(int $ean, Request $request)
    {
        $product = $this->eanLookup->find($ean);

        return response()->json($product);
    }
}
