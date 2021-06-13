<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;
    use App\Factories\ModifierFactory;

    
    $response = (new SquareClientFactory)->make()->getCatalogApi()->listCatalog(null, 'MODIFIER');

    if($response->isSuccess())
    {
        $result = $response->getResult();
        
        //extract objects from the ListCatalogResponse Model
        $objects = $result->getObjects();
        
        foreach($objects as $obj)
        {
            //get the id of the modifier
            $modId = $obj->getId();

            //get modifer data
            $itemData = $obj->getModifierData();

            //get name
            $itemName = $itemData->getName();

            
            //get priceMoney class
            $priceMoney = $itemData->getPriceMoney();
            
            //get price
            $price = $priceMoney->getAmount();
        
            (new ModifierFactory)->make($itemName, $modId, $price, 1);
        }
        //loop through array of object and extract the CatalogItemObjects
        // foreach($catalogObjects as $obj)
        // {
        //     //get the id of the modifier
        //     $modId = $obj->getId();

        //     //get modifer data
        //     $itemData = $obj->getModifierData();

        //     //get name
        //     $itemName = $itemData->getName();

               
        //     //get priceMoney class
        //     $priceMoney = $itemData->getPriceMoney();
            
        //     //get price
        //     $price = $priceMoney->getAmount();
        // }
    } else
    {
        $errors = $response->getErrors();
    }


?>