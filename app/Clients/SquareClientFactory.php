<?php

namespace App\Clients;

use Square\SquareClient;
use Square\Environment;
use App\Models\User;

class SquareClientFactory
{
    /**
     * Instantiates Square Client
     * 
     * @param User $user
     * @return SquareClient
     */
    public function make(User $user)
    {
        $access_token =  $user->access_token;

        $square_client = new SquareClient([
            'accessToken' => $access_token,  
            'environment' => Environment::PRODUCTION
        ]);
        
        return $square_client;
    }
}
