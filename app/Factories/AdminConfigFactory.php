<?php

namespace App\Factories;
use App\Models\AdminConfig;

class AdminConfigFactory
{
    /**
     * Creates an AdminConfig Model
     * 
     * @param int $userID
     * @return void
     */
    public function make(int $userID)
    {
        AdminConfig::create([
            'user_id' => $userID
        ]);
    }
}