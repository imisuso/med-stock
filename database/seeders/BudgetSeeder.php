<?php

namespace Database\Seeders;

use App\Models\budget;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budgets = array(
            ['stock_id' => '1', 'year' => '2021','budget_add'=> '1100000.00','status'=>'off','user_id'=>'4'],
            ['stock_id' => '1', 'year' => '2022','budget_add'=> '1000000.00','status'=>'on','user_id'=>'4'],
            ['stock_id' => '2', 'year' => '2022','budget_add'=> '2000000.00','status'=>'on','user_id'=>'4'],
            ['stock_id' => '3', 'year' => '2022','budget_add'=> '3000000.00','status'=>'on','user_id'=>'4'],
            ['stock_id' => '4', 'year' => '2022','budget_add'=> '4000000.00','status'=>'on','user_id'=>'4'],
        );

        foreach ($budgets as $budget) {
            budget::create($budget);
        }
    }
}
