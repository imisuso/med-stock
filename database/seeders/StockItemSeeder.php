<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockItem;

class StockItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       StockItem::loadData('data_stock_item2');
       StockItem::loadData('data_stock_item_office');
        
    }
}
