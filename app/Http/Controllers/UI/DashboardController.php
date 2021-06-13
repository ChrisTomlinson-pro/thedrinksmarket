<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Returns view of dashboard with relevant variables
     * 
     * @return Response
     */
    public function index()
    {
        $config = auth()->user()->adminConfig;
        $qrCodes = auth()->user()->qrCodes;
        return view('dashboard', compact('config', 'qrCodes'));
    }
}
