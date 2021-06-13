<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;
use App\Traits\SendsResponses;

class SyncBySkusController extends Controller
{
    use SendsResponses;

    /**
     * Syncs a catalog item by its sku
     * 
     * @param string $sku
     * @return Response
     */
    public function sync(string $sku):Response
    {
        $result = auth()->user()->syncBySku($sku);
        return $this->respond($result[0], $result[1], $result[2]);
    }
}
