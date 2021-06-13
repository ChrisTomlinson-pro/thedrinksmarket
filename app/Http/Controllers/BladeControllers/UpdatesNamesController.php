<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class UpdatesNamesController extends Controller
{
    use SendsResponses;

    /**
     * Updates name of an Item
     * 
     * @param Request $request
     * @param Item $item
     * @route '/updatename/{item}'
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        $item->update(['name' => $request->name]);
        $this->respond('OK', 'Name successfully updated', 201);
    }
}
