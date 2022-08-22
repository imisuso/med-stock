<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;


class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $items = array(
            ['order_no' => 1 ,'unit_id' => '1','stock_item_id' => 1,'price' => 1500 ,'catalog_number' => 'ACTH101','lot_number'=>'396A','user_id'=>1,'year'=>2021,'month'=>10,'date_order'=>'2021-10-05','unit'=>5,'status'=>'ordered'],
            ['order_no' => 1 ,'unit_id' => '1','stock_item_id' => 2,'price' => 500.50 ,'catalog_number' => 'ACTH101','lot_number'=>'396A','user_id'=>1,'year'=>2021,'month'=>10,'date_order'=>'2021-10-05','unit'=>10,'status'=>'ordered'],
            ['order_no' => 1 ,'unit_id' => '1','stock_item_id' => 3,'price' => 300 ,'catalog_number' => 'ACTH101','lot_number'=>'396A','user_id'=>1,'year'=>2021,'month'=>10,'date_order'=>'2021-10-05','unit'=>22,'status'=>'ordered' ],
            ['order_no' => 1 ,'unit_id' => '1','stock_item_id' => 4,'price' => 3500 ,'catalog_number' => 'ACTH101','lot_number'=>'396A','user_id'=>1,'year'=>2021,'month'=>10,'date_order'=>'2021-10-05','unit'=>50,'status'=>'ordered'],
            ['order_no' => 1 ,'unit_id' => '1','stock_item_id' => 5,'price' => 850 ,'catalog_number' => 'ACTH101','lot_number'=>'396A','user_id'=>1,'year'=>2021,'month'=>10,'date_order'=>'2021-10-05','unit'=>30,'status'=>'ordered' ],
        );

        foreach ($items as $item) {
            OrderItem::create($item);
        }
    }
}
