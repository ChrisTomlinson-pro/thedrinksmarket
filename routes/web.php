<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

//custom trading screen views
Route::get('/tradingscreen/{guid}/{mobileview?}', ['App\Http\Controllers\UI\TradingScreenController', 'index'])->name('show.trading.screen');

Route::middleware(['auth'])->get('/contactsupport', function(){ return view('contact-support'); })->name('contact-support');

Route::middleware(['auth', 'check.tokens'])->group(function() {
    Route::get('/dashboard', ['App\Http\Controllers\UI\DashboardController', 'index'])->name('dashboard');
    Route::get('/products', ['App\Http\Controllers\Products\DisplaysProductsViewController', 'index'])->name('products');

    //blade requests
    Route::get('/adddrink/{item}/{modifier}', ['App\Http\Controllers\BladeControllers\AddsDrinksController', 'add'])->name('add-drink');
    Route::post('/updatemin/{item}', ['App\Http\Controllers\BladeControllers\UpdatesMinPricesController', 'update']);
    Route::post('/updatemax/{item}', ['App\Http\Controllers\BladeControllers\UpdatesMaxPricesController', 'update']);
    Route::post('/updateincrements/{item}', ['App\Http\Controllers\BladeControllers\UpdatesIncrementsController', 'update']);
    Route::post('/updatecrashprice/{item}', ['App\Http\Controllers\BladeControllers\UpdatesCrashPricesController', 'update']);
    Route::post('/updatename/{item}', ['App\Http\Controllers\BladeControllers\UpdatesNamesController', 'update']);
    Route::get('/square/sync', ['App\Http\Controllers\SquareRequests\SyncProductsController', 'sync'])->name('square-sync-items');
    Route::get('/syncbysku/{sku}', ['App\Http\Controllers\BladeControllers\SyncBySkusController', 'sync'])->name('sync-by-sku');
    Route::get('/toggleactive/{item}', ['App\Http\Controllers\BladeControllers\TogglesDrinkActiveController', 'toggle'])->name('toggle-drink-active');
    Route::get('/togglerunning', ['App\Http\Controllers\BladeControllers\TogglesRunningStatusController', 'toggle'])->name('toggle-running');
    Route::get('/togglecrash', ['App\Http\Controllers\BladeControllers\TogglesCrashStatusController', 'toggle'])->name('toggle-crash');
    Route::get('/checkcrash/{config}', ['App\Http\Controllers\BladeControllers\CheckCrashStatusController', 'check'])->name('check-crash');
    Route::get('/getdistance/{user}', ['App\Http\Controllers\BladeControllers\GetDistanceController', 'get'])->name('get-distance');
});

Route::get('/getdrinkprice/{item}/{tradingview?}', ['App\Http\Controllers\BladeControllers\GetsDrinkPricesController', 'get']);
Route::get('/test', ['App\Http\Controllers\TestController', 'run'])->name('test');
Route::get('/items', ['App\Http\Controllers\SquareRequests\GetItemsController', 'get'])->name('get-items');


require __DIR__.'/auth.php';