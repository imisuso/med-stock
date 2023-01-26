<?php

namespace Database\Seeders;

use App\Models\Budget;
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
            ['stock_id' => '1', 'year' => '2023','budget_add'=> '0.00','status'=>'on','user_id'=>'4'],
        );

        foreach ($budgets as $budget) {
            budget::create($budget);
        }
    }
}
