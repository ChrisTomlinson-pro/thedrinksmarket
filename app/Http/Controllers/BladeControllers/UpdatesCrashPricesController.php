<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class UpdatesCrashPricesController extends Controller
{
    use SendsResponses;

    /**
     * Updates item crash price
     * 
     * @param Request $request
     * @param Item $item
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        $item->update(['crash_price' => $request->value * 100]);
        return $this->respond('OK', 'Crash price updated', 201);
    }
}
