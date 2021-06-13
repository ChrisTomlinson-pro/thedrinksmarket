<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Factories\StockExchangeSessionFactory;
use App\Clients\SquareSyncProductBySku;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'access_token',
        'location',
        'guid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'access_token',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get active products for this user
     * 
     * @return Collection
     */
    public function getActiveItems()
    {
        return $this->items()->where('active', true)->with('prices')->get();
    }

    /**
     * Sets items to crash prices
     * 
     * @return void
     */
    public function setCrashPrices()
    {
        $this->items->where('active', true)->each->setCrashPrice();
    }

    /**
     * Unsets items from crash prices
     * 
     * @return void
     */
    public function unsetCrashPrices()
    {
        $this->items->where('active', true)->each->unsetCrashPrice();
    }

    /**
     * Instantiates a new session
     * 
     * @return void
     */
    public function startSession()
    {
        (new StockExchangeSessionFactory)->make($this->id);
    }

    /**
     * Updates last session with the end time
     * 
     * @return void
     */
    public function endSession()
    {
        $this->stockExchangeSessions->sortByDesc('created_at')->first()->update(['end' => now()]);
    }

    /**
     * Synchronises all items with the price and version in the database
     * 
     * @return void
     */
    public function syncItems()
    {
        $this->items->where('active', true)->each->syncSingle();
    }

    /**
     * Resets prices on the till to their original base prices
     * 
     * @return void
     */
    public function resetPrices()
    {
        $this->items->where('active', true)->each->upsertSingle();
    }

    /**
     * Syncs a product by sku with the catalog
     * 
     * @param string $sku
     * @return array
     */
    public function syncBySku(string $sku):array
    {
        if($this->items()->where('square_item_id', $sku)->orWhere('sku', $sku)->first())
        {
            return ['error', 'Product already has been added', 200];
        }

        $result = (new SquareSyncProductBySku)->sync($sku);
        if($result)
        {
            return ['OK', 'Product synced', 201];
        } else
        {
            return ['error', 'Product not found for this sku', 200];
        }
    }

    /**
     * Gets orders made in the last ten minutes
     * 
     * @return array
     */
    public function getOrders()
    {
        return $this->orders->where('created_at', '>', now()->subMinutes(10))->pluck('square_id')->all();
    }

    public function adminConfig()
    {
        return $this->hasOne(AdminConfig::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function drinks()
    {
        return $this->hasMany(Drink::class);
    }

    public function stockExchangeSessions()
    {
        return $this->hasMany(StockExchangeSession::class);
    }

    public function originalPriceConfigs()
    {
        return $this->hasMany(OriginalPriceConfig::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function modifiers()
    {
        return $this->hasMany(Modifier::class);
    }

    public function schedulerRan()
    {
        return $this->hasOne(SchedulerRan::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }
}
