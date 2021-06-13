<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;

    

    $client = (new SquareClientFactory)->make();
    $body = new \Square\Models\SearchCatalogItemsRequest();
    $body->setSortOrder('ASC');

    $api_response = $client->getCatalogApi()->searchCatalogItems($body);

    if ($api_response->isSuccess()) {
        $result = $api_response->getResult();
        dd($result->getItems()[0]);
        foreach($result->getItems() as $object)
        {
            if($object->getType() !== 'ITEM')
            {
                dd('found an anomaly');
            }
        }
//            dd($result->getObject()->getItemVariationData()->getPriceMoney()->getAmount());
        //dd($result->getObjects()[0]);
    } else {
        $errors = $api_response->getErrors();
        dd($errors);
    }
?>