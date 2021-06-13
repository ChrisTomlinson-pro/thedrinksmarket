<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Factories\PriceFactory;
use App\Clients\SyncsSingleItems;
use App\Clients\UpsertsPrice;

class Item extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Gets latest price movement
     * 
     * @return int
     */
    public function getMovement()
    {
        $prices = $this->prices()->orderByDesc('created_at')->take(2)->get()->toArray();
        
        if($prices[0]['value'] === $prices[1]['value'])
        {
            return 'constant';
        } elseif ($prices[0]['value'] < $prices[1]['value'])
        {
            return 'down';
        } else
        {
            return 'up';
        }
    }

    /**
     * Make new price
     * 
     * @param float $price
     * @return void
     */
    public function addPrice(float $price)
    {
        (new PriceFactory)->make($price, $this->id);
    }

    /**
     * Synchronises version and base price with the corresponding item in the database
     * 
     * @return void 
     */
    public function syncSingle()
    {
        (new SyncsSingleItems)->sync($this);
    }

    /**
     * Checks if the latest price is up to date
     * 
     * @return void
     */
    public function checkLatestPrice()
    {
        if($this->base_price !== $this->prices->sortByDesc('created_at')->first()->value)
        {
            $this->addPrice($this->base_price);
        }
    }

    /**
     * Upserts a price to the Square database
     * 
     * @param int $price
     * @return void
     */
    public function upsertSingle($price=null)
    {
        if(!$price) $price = $this->base_price;
        //(new UpsertsPrice)->execute($this, $price);
    }

    /**
     * Instantiates a crash price
     * 
     * @return void
     */
    public function setCrashPrice()
    {
        $this->addPrice($this->crash_price);
        $this->upsertSingle($this->crash_price);
    }

    /**
     * Instantiates a price previous to the crash price
     * 
     * @return void
     */
    public function unsetCrashPrice()
    {
        $previousPrice = $this->prices->sortByDesc('created_at')->get(1)->value;
        $this->addPrice($previousPrice);
        $this->upsertSingle($previousPrice);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
