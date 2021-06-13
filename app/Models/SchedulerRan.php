<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchedulerRan extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get number of seconds between now and last run
     * 
     * @return int
     */
    public function getSeconds():int
    {
        return Carbon::parse($this->last_ran)->diffInSeconds(now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
