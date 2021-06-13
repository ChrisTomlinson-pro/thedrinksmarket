<?php

namespace App\Clients;
use App\Clients\SquareClientFactory;
use App\Factories\ItemFactory;

class SquareSyncProductBySku
{
    /**
     * Adds item from catalog to add to the database
     * 
     * @param string $sku
     * @return bool
     */
    public function sync(string $sku): bool
    {
        $client = (new SquareClientFactory)->make(auth()->user());
        $api_response = $client->getCatalogApi()->retrieveCatalogObject($sku);


        if ($api_response->isSuccess()) 
        {
            $item = $api_response->getResult()->getObject();
            if($item->getType() === 'ITEM')
            {
                $this->extractItemData($item);
                return 1;
            } else if($item->getType() === 'ITEM_VARIATION')
            {
                return $this->sync($item->getItemVariationData()->getItemId());
            } else
            {
                return 0;
            }
        }else
        {
            return 0;
        }
    }

    /**
     * Extracts data from the response object
     * 
     * @param object $item
     * @return void
     */
    private function extractItemData(object $item):void
    {
        $itemData = $item->getItemData();
        $itemName = $itemData->getName();

        foreach($itemData->getVariations() as $variation)
        {
            //get $id
            $varId = $variation->getId();

            //get version
            $version = $variation->getVersion();
            
            //get variation item data
            $varData = $variation->getItemVariationData();

            //get var name
            $varName = $varData->getName();
        
            //get pricing type
            $pricingType = $varData->getPricingType();

            //get Item ID
            $itemID = $varData->getItemId();

            //get priceMoney class
            $priceMoney = $varData->getPriceMoney();
        
            //get price
            if($priceMoney)
            {
                $price = $priceMoney->getAmount();
            }

            $item = (new ItemFactory)->make($itemName . ' - ' . $varName, $varId, $price, auth()->user()->id, $version, $pricingType, $itemID);
            $item->addPrice($price);
        }
    }
}