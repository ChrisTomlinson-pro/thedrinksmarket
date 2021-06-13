<?php

namespace App\Factories;
use App\Models\Order;
use App\Models\User;

class OrderFactory
{
    /**
     * Instantiates an Order
     * 
     * @param array $activeProducts
     * @param User $user
     * @param string $orderID
     * @return void
     */
    public function make(array $activeProducts, User $user, string $orderID)
    {
        Order::create([
            'active_drinks' => $activeProducts,
            'user_id' => $user->id,
            'square_id' => $orderID
        ]);
    }
}