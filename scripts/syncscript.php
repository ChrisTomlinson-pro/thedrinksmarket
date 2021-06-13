<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;

    
    $response = (new SquareClientFactory)->make()->getCatalogApi()->listCatalog(null, 'ITEM');

    if($response->isSuccess())
    {
        $result = $response->getResult();
        
        //extract objects from the ListCatalogResponse Model
        $catalogObjects = $result->getObjects();

        //loop through array of object and extract the CatalogItemObjects
        foreach($catalogObjects as $obj)
        {
            $itemData = $obj->getItemData();
            //get name
            $itemName = $itemData->getName();

            //get variations
            $variations = $itemData->getVariations();

            //loop through variation array
            foreach($variations as $variation)
            {
                //get $id
                $varId = $variation->getId();
                
                //get variation item data
                $varData = $variation->getItemVariationData();

                //get var name
                $varName = $varData->getName();
               
                //get priceMoney class
                $priceMoney = $varData->getPriceMoney();
               
                //get price
                $price = $priceMoney->getAmount();
            }
        }
    } else
    {
        $errors = $response->getErrors();
    }


?>