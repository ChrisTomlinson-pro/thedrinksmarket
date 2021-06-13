<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class DisplaysProductsViewController extends Controller
{
    /**
     * Displays the Product admin panel
     * 
     * @route 'products'
     * @return Response
     */
    public function index()
    {
        $config = auth()->user()->adminConfig;
        $drinks = Item::all();
        return view('products', compact('drinks', 'config'));
    }
}
