<?php

namespace App\Http\Controllers\BladeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\SendsResponses;

class TogglesDrinkActiveController extends Controller
{
    use SendsResponses;

    /**
     * Toggles the active boolean of a drink
     * 
     * @param Item $item
     * @return Response
     */
    public function toggle(Item $item)
    {
        $item->update(['active' => !$item->active]);
        if($item->active)
        {
            $item->syncSingle();
        } else
        {
            $item->upsertSingle();
        }
        return $this->respond('OK', 'Status updated', 201);
    }
}
