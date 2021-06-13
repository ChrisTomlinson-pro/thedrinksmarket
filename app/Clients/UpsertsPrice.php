<?php

namespace App\Clients;
use App\Models\Item;
use App\Clients\SquareClientFactory;
use Illuminate\Support\Str;

class UpsertsPrice
{
    /**
     * Upserts price to the square till system
     * 
     * @param Item $item
     * @param int $price
     * @return void
     */
    public function execute(Item $item, int $price)
    {
        $client = (new SquareClientFactory)->make($item->user);

        $price_money = new \Square\Models\Money();
        $price_money->setAmount($price);
        $price_money->setCurrency('GBP');
        
        $item_variation_data = new \Square\Models\CatalogItemVariation();
        $item_variation_data->setItemId($item->square_item_id);
        $item_variation_data->setPricingType($item->pricing_type);
        $item_variation_data->setPriceMoney($price_money);
        
        $catalog_object = new \Square\Models\CatalogObject('ITEM_VARIATION', $item->sku);
        $catalog_object->setVersion($item->version);
        $catalog_object->setItemVariationData($item_variation_data);
        
        $objects = [$catalog_object];
        $catalog_object_batch = new \Square\Models\CatalogObjectBatch($objects);
        
        $batches = [$catalog_object_batch];
        $body = new \Square\Models\BatchUpsertCatalogObjectsRequest(Str::uuid()->toString(), $batches);
        
        $api_response = $client->getCatalogApi()->batchUpsertCatalogObjects($body);
        
        if ($api_response->isSuccess()) {
            $newVersion = $api_response->getResult()->getObjects()[0]->getVersion();
            $item->update(['version' => $newVersion]);
        } else {
            $errors = $api_response->getErrors();
            throw new \Exception($errors);
        }
    }
}
