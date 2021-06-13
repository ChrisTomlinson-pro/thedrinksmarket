<?php

namespace App\Factories;

use App\Models\Item;

class ItemFactory
{
    /**
     * Instantiates an Item
     * 
     * @param String $name
     * @param String $sku
     * @param int $price
     * @param int $userID
     * @param int $version
     * @param string $pricingType
     * @param string $itemID 
     * @return Item
     */
    public function make(string $name, string $sku, int $price, int $userID, int $version, string $pricingType, string $itemID)
    {
        return Item::create([
            'name' => $name,
            'sku' => $sku,
            'base_price' => $price,
            'user_id' => $userID,
            'version' => $version,
            'pricing_type' => $pricingType,
            'square_item_id' => $itemID,
            'active' => false,
            'increments_up' => 5,
            'increments_down' => 5,
            'crash_price' => ceil($price / 2),
            'max_price' => ceil($price * 1.25),
            'min_price' => ceil($price * 0.75)
        ]);
    }
}