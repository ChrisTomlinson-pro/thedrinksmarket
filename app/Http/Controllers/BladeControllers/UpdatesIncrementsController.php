<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class UpdatesIncrementsController extends Controller
{
    use SendsResponses;

    /**
     * Update increments for an item
     * 
     * @param Request $request
     * @param Item $item
     * @route '/updateincrements/{item}'
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        $value = (float) $request->value;
        if($request->protocol === 'up')
        {
            $item->update(['increments_up' => $value * 100]);
        } else
        {
            $item->update(['increments_down' => $value * 100]);
        }
        return $this->respond('OK', 'Increments successfully updated', 201);
    }
}
