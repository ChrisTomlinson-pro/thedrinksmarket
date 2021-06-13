<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class GetsDrinkPricesController extends Controller
{
    use SendsResponses;

    /**
     * Gets Latest price for drink
     * 
     * @param Item $item
     * @param string $tradingview
     * @return Response
     */
    public function get(Item $item, string $tradingview=null)
    {
        $price = $item->prices->sortByDesc('created_at')->first();
        $price = $price->value / 100;
        if(!$tradingview)
        {
            return $this->respond('OK', $price, 200);
        } else
        {
            return $this->respond('OK', [$price, $item->getMovement()], 200);
        }
    }
}
