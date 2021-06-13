<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Factories\PriceFactory;

class Drink extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=['active' => 'boolean'];

    /**
     * Instantiate price factory
     * 
     * @param float $price
     * @return void
     */
    public function addPrice(float $price)
    {
        (new PriceFactory)->make($price, $this->id);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
