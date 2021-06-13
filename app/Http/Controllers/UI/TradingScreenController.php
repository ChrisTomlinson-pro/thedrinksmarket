<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TradingScreenController extends Controller
{
    /**
     * Returns the custom trading screen for a user
     * 
     * @param string $guid
     * @param mixed $mobileview
     * @return Response
     */
    public function index(string $guid, string $mobileview = null)
    {
        $user = User::whereGuid($guid)->first();
        if(!$user)
        {
            throw new \Exception('User not found');
        }

        $products = $user->getActiveItems();
        $blankSpaces = 15 - count($products);
        $config = $user->adminConfig;

        if(!$mobileview)
        {
            return view('tradingscreens.' . $guid, compact('products', 'blankSpaces', 'config', 'user'));
        } else
        {
            return view('tradingscreens.mobileviews.' . $guid, compact('products', 'blankSpaces', 'config', 'user'));
        }
    }
}
