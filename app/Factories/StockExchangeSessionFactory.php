<?php

namespace App\Factories;
use App\Models\StockExchangeSession;

class StockExchangeSessionFactory
{
    /**
     * Creates a StockExchangeSession Model
     * 
     * @param int $userID
     * @return void
     */
    public function make(int $userID)
    {
        StockExchangeSession::create([
            'user_id' => $userID
        ]);
    }
}