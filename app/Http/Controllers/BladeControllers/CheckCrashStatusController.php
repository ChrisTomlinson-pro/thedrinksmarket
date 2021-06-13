<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AdminConfig;
use App\Traits\SendsResponses;

class CheckCrashStatusController extends Controller
{
    use SendsResponses;

    /**
     * Check if crash status is active or not
     * 
     * @param AdminConfig $config
     * @return JsonResponse
     */
    public function check(AdminConfig $config): JsonResponse
    {
        return $this->respond('OK', $config->crash, 200);
    }
}
