<?php

namespace App\Traits;

trait SendsResponses
{
    /**
     * Sends a json response
     * 
     * @param string $status
     * @param string $message
     * @param int $code
     * @return Response
     */
    protected function respond($status, $message, $code)
    {
        return response()->json(['status' => $status, 'message' => $message], $code);
    }
}