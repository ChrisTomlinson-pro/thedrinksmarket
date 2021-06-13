<?php

namespace App\Clients;
use App\Models\Item;
use App\Clients\SquareClientFactory;


class SyncsSingleItems
{
    /**
     * synchronises version and baseprice with the till system counterpart
     * 
     * @param Item
     * @return void
     */
    public function sync(Item $item)
    {
        $client = (new SquareClientFactory)->make($item->user);
        $api_response = $client->getCatalogApi()->retrieveCatalogObject($item->sku);

    if ($api_response->isSuccess()) {
        $object = $api_response->getResult()->getObject();
        $item->update([
            'version' => $object->getVersion(), 
            'base_price' => $object->getItemVariationData()->getPriceMoney()->getAmount()
        ]);
        $item->checkLatestPrice();
    } else {
        $errors = $api_response->getErrors();
        throw new \Exception($errors);
    }
    }
}