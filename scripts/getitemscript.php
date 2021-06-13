<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;

    

    $client = (new SquareClientFactory)->make();
    $api_response = $client->getCatalogApi()->retrieveCatalogObject('RRCKBJ5BM4OFFXVBOBUQRNSG');

    if ($api_response->isSuccess()) {
        $result = $api_response->getResult()->getObject();
        dd($result);
//            dd($result->getObject()->getItemVariationData()->getPriceMoney()->getAmount());
        //dd($result->getObjects()[0]);
    } else {
        $errors = $api_response->getErrors();
        dd($errors);
    }
?>