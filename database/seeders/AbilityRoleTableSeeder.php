<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AbilityRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            'create_order',
            'view_order',
            'send_order',
            'approve_order',
            'delete_order',
            'view_item',
            'view_report_item',
            'checkin_item',
            'checkout_item',
            'manage_master_data',
            'view_master_data',
            'set_role_user',
        ];

        foreach ($abilities as $ability) {
            Ability::create(['name' => $ability]);
        }

        
        $roles = [
            'officer',
            'super_officer',
            'admin_division_stock',
            'admin_med_stock',
            'admin_it',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

// *officer
//     -view_item
//     -checkout_item
//     -view_report_item
// *admin-division-stock
//     -view_item
//     -checkout_item
//     -create_order
//     -view_order
//     -send_order
//     -receive_order
//     -delete_order
// *admin-med-stock
//     -view_item
//     -view_order
//     -approve_order
//     -manage_master_data
//     -view_master_data
//     -set_role_user
// *admin-it
//     -view_item
//     -view_order
//     -view_master_data
//     -view_report_item
// *super_officer
//     -view_item
//     -view_order
//     -view_master_data
//     -view_report_item

        $officer = Role::whereName('officer')->first();
        $officer->allowTo('view_item');
        $officer->allowTo('checkout_item');
        $officer->allowTo('view_report_item');

        $super_officer = Role::whereName('super_officer')->first();
        $super_officer->allowTo('view_item');
        $super_officer->allowTo('view_order');
        $super_officer->allowTo('view_master_data');
        $super_officer->allowTo('view_report_item');
       
        $admin_division_stock = Role::whereName('admin_division_stock')->first();
        $admin_division_stock->allowTo('view_item');
        $admin_division_stock->allowTo('checkout_item');
        $admin_division_stock->allowTo('create_order');
        $admin_division_stock->allowTo('view_order');
        $admin_division_stock->allowTo('send_order');
        $admin_division_stock->allowTo('delete_order');
        $admin_division_stock->allowTo('receive_order');

        $admin_med_stock = Role::whereName('admin_med_stock')->first();
        $admin_med_stock->allowTo('view_item');
        $admin_med_stock->allowTo('view_order');
        $admin_med_stock->allowTo('approve_order');
        $admin_med_stock->allowTo('manage_master_data');
        $admin_med_stock->allowTo('view_master_data');
        $admin_med_stock->allowTo('set_role_user');

        $admin_it = Role::whereName('admin_it')->first();
        $admin_it->allowTo('view_item');
        $admin_it->allowTo('view_order');
        $admin_it->allowTo('view_master_data');
        $admin_it->allowTo('view_report_item');

    }
}
