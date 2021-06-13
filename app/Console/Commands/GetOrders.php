<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Clients\SquareClientFactory;
use App\Clients\HandlesSquareOrders;
use App\Models\User;

class GetOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets orders from the api and parses them into models';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::with('adminConfig')->get();

        foreach($users as $user)
        {
            $config = $user->adminConfig;
            if($config->running === true && $config->crash === false)
            {
                $client = (new SquareClientFactory)->make($user);
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
                    (new HandlesSquareOrders)->handle($result->getOrders(), $user);

                } else {
                    $errors = $api_response->getErrors();
                    throw new \Exception($errors);
                }
            }

            $user->schedulerRan->first()->update(['last_ran' => now()]);
        }

        return 0;
    }
}
