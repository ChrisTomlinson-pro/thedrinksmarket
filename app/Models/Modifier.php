<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function drinks()
    {
        return $this->hasMany(Drink::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
