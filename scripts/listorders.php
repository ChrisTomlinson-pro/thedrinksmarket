<?php
    require '../vendor/autoload.php';
    
    $app = require_once '../bootstrap/app.php';

    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Clients\SquareClientFactory;

    $client = (new SquareClientFactory)->make();
    $time = now()->subMinutes(5)->toRfc3339String();

    $location_ids = [config('app.location_id')];
    $created_at = new \Square\Models\TimeRange();
    $created_at->setStartAt($time);
    
    $date_time_filter = new \Square\Models\SearchOrdersDateTimeFilter();
    $date_time_filter->setCreatedAt($created_at);
    
    $filter = new \Square\Models\SearchOrdersFilter();
    $filter->setDateTimeFilter($date_time_filter);
    
    $sort = new \Square\Models\SearchOrdersSort('CREATED_AT');
    $sort->setSortOrder('DESC');
    
    $query = new \Square\Models\SearchOrdersQuery();
    $query->setFilter($filter);
    $query->setSort($sort);
    
    $body = new \Square\Models\SearchOrdersRequest();
    $body->setLocationIds($location_ids);
    $body->setQuery($query);
    
    $api_response = $client->getOrdersApi()->searchOrders($body);
    
    if ($api_response->isSuccess()) {
        $result = $api_response->getResult();
        $orders = $result->getOrders();
        foreach($orders as $order)
        {
            $lineItems = $order->getLineItems();
            print_r($lineItems);
            if($lineItems)
            {
                foreach($lineItems as $lineItem)
                {
                    echo $lineItem->getQuantity() . "\n";
                }
            }
        }

        //get order id

    } else {
        $errors = $api_response->getErrors();
        print_r($errors);
    }

?>