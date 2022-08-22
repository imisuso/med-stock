<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Business;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::loadData('business_load_utf8');
    }
}
