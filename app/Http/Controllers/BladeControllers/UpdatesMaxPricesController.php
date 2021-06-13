<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class UpdatesMaxPricesController extends Controller
{
    use SendsResponses;

    /**
     * Update max price for an item
     * 
     * @param Request $request
     * @param Item $item
     * @route '/updatemax/{item}'
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        $value = (float) $request->value;
        $item->update(['max_price' => $value * 100]);
        return $this->respond('OK', 'Max price successfully updated', 201);
    }
}
