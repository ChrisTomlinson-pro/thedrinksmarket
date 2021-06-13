<?php

namespace App\Http\Controllers\SquareRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clients\SquareClientFactory;
use App\Factories\ItemFactory;
use App\Factories\ModifierFactory;
use App\Models\Item;
use App\Models\Modifier;
use App\Traits\SendsResponses;

class SyncProductsController extends Controller
{
    use SendsResponses;

    /**
     * Synchronises items and price with catalog
     * 
     * @return Response
     */
    public function sync()
    {
        //temporarily kept in case i need to get modifier data
        $params = ['ITEM'];
        $client = (new SquareClientFactory)->make(auth()->user());

        foreach($params as $param)
        {
            if($param === 'ITEM')
            {
                $body = new \Square\Models\SearchCatalogItemsRequest();
                $body->setSortOrder('ASC');

                $response = $client->getCatalogApi()->searchCatalogItems($body);
            } else
            {
                $response = $client->getCatalogApi()->listCatalog(null, $param);
            }

            if($response->isSuccess())
            {
                if($param === 'ITEM')
                {
                    $this->parseItemData($response->getResult()->getItems());
                } else
                {
                    $this->parseModifierData($response->getResult()->getObjects());
                }
            } else
            {
                $errors = $response->getErrors();
                throw new \Exception($errors);
            }
        }
        return $this->respond('OK', 'Items and modifiers successfully synced', 201);
    }

    /**
     * Parses items from response into models
     * 
     * @param array $objects
     * @return void
     */
    private function parseItemData(array $objects)
    {
        foreach($objects as $obj)
        {
            $itemData = $obj->getItemData();
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

                $item = $this->checkExists($varId, 'ITEM');
                if(!$item && $priceMoney)
                {
                    //$item = (new ItemFactory)->make($itemName . ' - ' . $varName, $varId, $price, auth()->user()->id, $version, $pricingType, $itemID);
                    //$item->addPrice($price);
                } elseif($item)
                {
                    //check base price is correct
                    if($item->base_price !== $price)
                    {
                        $item->update(['base_price' => $price]);
                    }
                }
            }
        }
    }

    /**
     * Parses modifiers from response into models
     * 
     * @param array $objects
     * @return void
     */
    private function parseModifierData(array $objects)
    {
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
            if($priceMoney)
            {
                $price = $priceMoney->getAmount();
            }
        
            $modifier = $this->checkExists($modId, 'MODIFIER');
            if(!$modifier && $priceMoney)
            {
                (new ModifierFactory)->make($itemName, $modId, $price, auth()->user()->id);
            }
        }
    }
    
    /**
     * Check if item/modifier already exists in the catalog
     * 
     * @param string $sku
     * @param string $protocol
     * @return mixed
     */
    private function checkExists(string $sku, string $protocol)
    {
        switch($protocol)
        {
            case 'ITEM':
                return Item::where('sku', $sku)->where('user_id', auth()->user()->id)->first();
                break;

            case 'MODIFIER':
                return Modifier::where('sku', $sku)->where('user_id', auth()->user()->id)->first();
                break;

            default:
                throw new \Exception('Protocol not recognised in checkExists function');
        }
    }
}
