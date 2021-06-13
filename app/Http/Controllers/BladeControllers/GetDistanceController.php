<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Traits\SendsResponses;

class GetDistanceController extends Controller
{
    use SendsResponses;

    /**
     * Gets the distance until the next scheduled run
     * 
     * @param User $user
     * @return JsonResponse
     */
    public function get(User $user): JsonResponse
    {
        $distance  = 180 - $user->schedulerRan->getSeconds();
        return $this->respond('OK', $distance, 200);
    }
}
