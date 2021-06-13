<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;
    use Illuminate\Support\Str;

    

    $client = (new SquareClientFactory)->make();

    $price_money = new \Square\Models\Money();
    $price_money->setAmount(8000);
    $price_money->setCurrency('GBP');
    
    $item_variation_data = new \Square\Models\CatalogItemVariation();
    $item_variation_data->setItemId('JSYCQIQDODM2DGICXDKB6QZA');
    $item_variation_data->setPricingType('FIXED_PRICING');
    $item_variation_data->setPriceMoney($price_money);
    
    $catalog_object = new \Square\Models\CatalogObject('ITEM_VARIATION', 'DRBYUAQTSVGL25YVW4YBR7G5');
    $catalog_object->setVersion(1622585138567);
    $catalog_object->setItemVariationData($item_variation_data);
    
    $objects = [$catalog_object];
    $catalog_object_batch = new \Square\Models\CatalogObjectBatch($objects);
    
    $batches = [$catalog_object_batch];
    $body = new \Square\Models\BatchUpsertCatalogObjectsRequest(Str::uuid()->toString(), $batches);
    
    $api_response = $client->getCatalogApi()->batchUpsertCatalogObjects($body);
    
    if ($api_response->isSuccess()) {
        $result = $api_response->getResult()->getObjects()[0]->getVersion();
        dd($result);
    } else {
        $errors = $api_response->getErrors();
        dd($errors);
    }
?>