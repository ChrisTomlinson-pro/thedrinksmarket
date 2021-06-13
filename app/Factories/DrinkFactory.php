<?php

namespace App\Factories;

use App\Models\Drink;
use App\Models\Item;
use App\Models\Modifier;

class DrinkFactory
{
    /**
     * Instantiates a Drink
     * 
     * @param int $userID
     * @param Item $item
     * @param Modifier $modifier
     * @return void
     */
    public function make(int $userID, Item $item, Modifier $modifier=null)
    {
        if($modifier)
        {
            $price = $modifier->base_price + $item->base_price;
            $modifierID = $modifier->id;
            $name = $item->name . ' and ' . $modifier->name;
        } else
        {
            $price = $item->base_price;
            $modifierID = null;
            $name = $item->name;
        }

        $drink = Drink::create([
            'active' => false,
            'increments_up' => 5,
            'increments_down' => 5,
            'name' => $name,
            'max_price' => ceil($price * 1.25),
            'min_price' => ceil($price * 0.75),
            'item_id' => $item->id,
            'modifier_id' => $modifierID,
            'user_id' => $userID
        ]);

        $drink->addPrice($price);
    }
}