<?php

namespace App\Factories;
use App\Models\Price;

class PriceFactory
{
    /**
     * Creates a new Price Model
     * 
     * @param int $price
     * @param int $deviceID
     * @return void
     */
    public function make($price, $itemID)
    {
        Price::create([
            'value' => $price,
            'item_id' => $itemID
        ]);
    }
}