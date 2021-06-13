<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class UpdatesMinPricesController extends Controller
{
    use SendsResponses;

    /**
     * Update min price for an item
     * 
     * @param Request $request
     * @param Item $item
     * @route '/updatemin/{item}'
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        $value = (float) $request->value;
        $item->update(['min_price' => $value * 100]);
        return $this->respond('OK', 'Min price successfully updated', 201);
    }
}
