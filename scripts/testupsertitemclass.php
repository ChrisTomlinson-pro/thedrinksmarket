<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\UpsertsPrice;
    use App\Models\Item;

    $item = Item::whereSku('DRBYUAQTSVGL25YVW4YBR7G5')->first();

    (new UpsertsPrice)->execute($item, 8000);
?>