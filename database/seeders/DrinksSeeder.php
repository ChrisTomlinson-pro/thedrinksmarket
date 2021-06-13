<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drink;
use Illuminate\Support\Str;

class DrinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;
        while($count < 15)
        {
            Drink::create([
                'sku' => Str::uuid()->toString(),
                'name' => "drinkname$count",
                'max_price' => rand(400,1000),
                'min_price' => rand(200,300),
                'increments' => rand(1,10),
                'active' => rand(0,1)
            ]);

            $count++;
        }
    }
}
