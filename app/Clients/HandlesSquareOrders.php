<?php

namespace App\Clients;
use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use App\Factories\OrderFactory;

class HandlesSquareOrders
{
    /**
     * Identifies unprocessed square orders and submits them for processing
     * 
     * @param array $orders
     * @param User $user
     * @return void
     */
    public function handle(array $orders, User $user)
    {
        if($orders)
        {
            $completedOrders = $user->getOrders();
            //$activeSkuPairs = $this->getActiveSkuPairs($user);
            $activeSkus = Item::where('user_id', $user->id)->whereActive(true)->get()->pluck('sku')->all();

            foreach($orders as $order)
            {
                if(!in_array($order->getId(), $completedOrders))
                {
                    $this->processOrder($order, $activeSkus, $user);
                }
            }
        }
    }

    /**
    private function getActiveSkuPairs($user)
    {
        $pairs = array();
        foreach(Drink::where('user_id', $user->id)->whereActive(true)->with(['item', 'modifier'])->get() as $drink)
        {
            $modifier = $drink->modifier;
            array_push($pairs, [$drink->item->sku, $modifier ? $modifier->sku : null]);
        }
    
        return $pairs;
    }
*/

    /**
     * Sorts active skus from inactive skus and modifies active items' prices accordingly
     * 
     * @param object $order
     * @param array $activeSkus
     * @param User $user
     * @return void
     */
    private function processOrder(object $order, array $activeSkus, User $user)
    {
        $orderId = $order->getId();
        $foundSkus = [];

        $lineItems = $order->getLineItems();
        if($lineItems)
        {
            foreach($lineItems as $lineItem)
            {
                $itemSku = $lineItem->getCatalogObjectId();
                if(in_array($itemSku, $activeSkus))
                {
                    array_push($foundSkus, $itemSku);
                    $item = Item::where('sku', $itemSku)->where('user_id', $user->id)->first();
                    $quantity = $lineItem->getQuantity();

                    $price = $item->prices->sortByDesc('created_at')->first()->value + ($item->increments_up * $quantity);
                    if($price < $item->max_price)
                    {
                        $item->addPrice($price);
                        $item->upsertSingle($price);
                    }

                    $minusItems = Item::where('user_id', $user->id)->whereActive(true)->where('id', '!=', $item->id)->get();
                    foreach($minusItems as $minusItem)
                    {
                        $price = $minusItem->prices->sortByDesc('created_at')->first()->value - ($minusItem->increments_down * $quantity);
                        if($price > $minusItem->min_price)
                        {
                            $minusItem->addPrice($price);
                            $minusItem->upsertSingle($price);
                        }
                    }
                }
            }
        }

            //keeping just in case i need to use modifiers in the future
            /**
            $modifierSku = null;
            $modifiers = $item->getModifiers();
            if($modifiers)
            {
                if(count($modifiers) === 1)
                {
                    $modifierSku = $modifiers[0]->getCatalogObjectId();
                }
            }

            $orderAr = [$itemSku, $modifierSku];
            if(in_array($orderAr, $activeSkuPairs))
            {
                array_push($active_pairs, $orderAr);

                $drink = Drink::where('user_id', $user->id)->whereActive(true)->whereHas('item', function($q) use ($itemSku)
                {
                        $q->where('sku', $itemSku);

                })->when($modifierSku, function ($q) use ($modifierSku)
                {
                    $q->whereHas('modifier', function ($subQuery) use ($modifierSku) 
                    {
                        $subQuery->where('sku', $modifierSku);

                    });
                })->when(!$modifierSku, function ($q) 
                {
                        $q->where('modifier_id', null);
                })->first();

                $price = $drink->prices->sortByDesc('created_at')->first()->value + $drink->increments_up;
                if($price < $drink->max_price)
                {
                    $drink->addPrice($price);
                }

                foreach(Drink::where('user_id', $user->id)->whereActive(true)->where('id', '!=', $drink->id)->get() as $minusDrink)
                {
                    $price = $minusDrink->prices->sortByDesc('created_at')->first()->value - $minusDrink->increments_down;
                    if($price > $minusDrink->min_price)
                    {
                        $minusDrink->addPrice($price);
                    }
                }
            }
        }
*/
        (new OrderFactory)->make($foundSkus, $user, $orderId);
    }
}