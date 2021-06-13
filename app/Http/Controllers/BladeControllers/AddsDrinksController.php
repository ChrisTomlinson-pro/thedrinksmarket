<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Models\Item;
use App\Models\Modifier;
use App\Factories\DrinkFactory;
use App\Traits\SendsResponses;

class AddsDrinksController extends Controller
{
    use SendsResponses;

    /**
     * Instantiates a Drink mode
     * 
     * @param Item $item
     * @param string $modifier
     * @return Response
     */
    public function add(Item $item, $modifier)
    {
        if($modifier === 'none')
        {
            $modifier = null;
        } else
        {
            $modifier = Modifier::find($modifier);
        }

        if($this->drinkAlreadyExists($item, $modifier))
        {
            return $this->respond('OK', 'Drink already Exists!', 200);
        }

        (new DrinkFactory)->make(auth()->user()->id, $item, $modifier);

        return $this->respond('OK', 'Drink added!', 201);
    }

    /**
     * Checks if the configuration for this drink already exists
     * 
     * @param Item $item
     * @param var $modifier
     * @return Response
     */
    private function drinkAlreadyExists(Item $item, $modifier)
    {
        if($modifier)
        {
            $modifierID = $modifier->id;
        } else
        {
            $modifierID = null;
        }

        return Drink::where('item_id', $item->id)->where('modifier_id', $modifierID)->first();
    }
}
