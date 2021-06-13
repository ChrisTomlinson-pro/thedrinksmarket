<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SendsResponses;
use App\Models\Item;

class TogglesRunningStatusController extends Controller
{
    use SendsResponses;

    /**
     * Toggles the running status of an adminconfig
     * 
     * @return Response
     */
    public function toggle()
    {
        $user = auth()->user();
        $config = $user->adminConfig;

        if($user->items->where('active', true)->isEmpty() && !$config->running)
        {
            return $this->respond('failed', 'No active products', 200);
        }

        $config->update(['running' => !$config->running]);

        if($config->running)
        {
            $user->startSession();
            $user->syncItems(); 
        } else
        {
            $user->endSession();
            $user->resetPrices();
        }

        return $this->respond('OK', 'Running status updated', 201);
    }
}
