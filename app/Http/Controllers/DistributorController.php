<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public $distributor;

    public function __construct(Distributor $distributor)
    {
        $this->distributor = $distributor;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->distributor->orderBy('title')->get()
        );
    }
}
