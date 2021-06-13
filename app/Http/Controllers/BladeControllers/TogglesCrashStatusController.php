<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SendsResponses;

class TogglesCrashStatusController extends Controller
{
    use SendsResponses;

    public function toggle()
    {
        $config = auth()->user()->adminConfig;
        if($config->running)
        {
            $config->update(['crash' => !$config->crash]);
            if($config->crash)
            {
                auth()->user()->setCrashPrices();
            } else
            {
                auth()->user()->unsetCrashPrices();
            }
            return $this->respond('OK', 'Crash status updated', 201);
        } else
        {
            return $this->respond('Failed', 'Crash can only be enabled when stock exchange is running', 200);
        }
    }
}
