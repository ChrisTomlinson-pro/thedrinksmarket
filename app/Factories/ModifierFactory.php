<?php

namespace App\Factories;

use App\Models\Modifier;

class ModifierFactory
{
    /**
     * Instantiates a Modifier
     * 
     * @param String $name
     * @param String $sku
     * @param int $price
     * @param int $userID
     * @return void
     */
    public function make(string $name, string $sku, int $price, int $userID)
    {
        Modifier::create([
            'name' => $name,
            'sku' => $sku,
            'base_price' => $price,
            'user_id' => $userID
        ]);
    }
}