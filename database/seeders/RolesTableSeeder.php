<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('TRUNCATE model_has_permissions');
        DB::statement('TRUNCATE permissions');
        DB::statement('TRUNCATE role_has_permissions');
        DB::statement('TRUNCATE model_has_roles');
        DB::statement('TRUNCATE roles');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            [
                'name' => 'dashboard',
                'group' => 'dashboard',
                'description' => 'Show',
            ],
            [
                'name' => 'user_browse',
                'group' => 'user',
                'description' => 'Browse',
            ],
            [
                'name' => 'user_read',
                'group' => 'user',
                'description' => 'Read',
            ],
            [
                'name' => 'user_edit',
                'group' => 'user',
                'description' => 'Edit',
            ],
            [
                'name' => 'user_add',
                'group' => 'user',
                'description' => 'Add',
            ],
            [
                'name' => 'student_browse',
                'group' => 'student',
                'description' => 'Browse',
            ],
            [
                'name' => 'student_read',
                'group' => 'student',
                'description' => 'Read',
            ],
            [
                'name' => 'student_edit',
                'group' => 'student',
                'description' => 'Edit',
            ],
            [
                'name' => 'student_add',
                'group' => 'student',
                'description' => 'Add',
            ],
            [
                'name' => 'meal_browse',
                'group' => 'meal',
                'description' => 'Browse',
            ],
            [
                'name' => 'meal_read',
                'group' => 'meal',
                'description' => 'Read',
            ],
            [
                'name' => 'meal_edit',
                'group' => 'meal',
                'description' => 'Edit',
            ],
            [
                'name' => 'meal_add',
                'group' => 'meal',
                'description' => 'Add',
            ],
            [
                'name' => 'meal_price_browse',
                'group' => 'meal_price',
                'description' => 'Browse',
            ],
            [
                'name' => 'meal_price_read',
                'group' => 'meal_price',
                'description' => 'Read',
            ],
            [
                'name' => 'meal_price_edit',
                'group' => 'meal_price',
                'description' => 'Edit',
            ],
            [
                'name' => 'meal_price_add',
                'group' => 'meal_price',
                'description' => 'Add',
            ],
            [
                'name' => 'nationality_browse',
                'group' => 'nationality',
                'description' => 'Browse',
            ],
            [
                'name' => 'nationality_read',
                'group' => 'nationality',
                'description' => 'Read',
            ],
            [
                'name' => 'nationality_edit',
                'group' => 'nationality',
                'description' => 'Edit',
            ],
            [
                'name' => 'nationality_add',
                'group' => 'nationality',
                'description' => 'Add',
            ],
            [
                'name' => 'question_browse',
                'group' => 'question',
                'description' => 'Browse',
            ],
            [
                'name' => 'question_read',
                'group' => 'question',
                'description' => 'Read',
            ],
            [
                'name' => 'question_edit',
                'group' => 'question',
                'description' => 'Edit',
            ],
            [
                'name' => 'question_add',
                'group' => 'question',
                'description' => 'Add',
            ],
            [
                'name' => 'manual_meal_entry_browse',
                'group' => 'manual_meal_entry',
                'description' => 'Browse',
            ],
            [
                'name' => 'manual_meal_entry_add',
                'group' => 'manual_meal_entry',
                'description' => 'Add',
            ],
            [
                'name' => 'qr_code_scanner_browse',
                'group' => 'qr_code_scanner',
                'description' => 'Browse',
            ],
            [
                'name' => 'qr_code_scanner_add',
                'group' => 'qr_code_scanner',
                'description' => 'Add',
            ],
            [
                'name' => 'role_browse',
                'group' => 'role',
                'description' => 'Browse',
            ],
            [
                'name' => 'role_read',
                'group' => 'role',
                'description' => 'Read',
            ],
            [
                'name' => 'role_edit',
                'group' => 'role',
                'description' => 'Edit',
            ],
            [
                'name' => 'role_add',
                'group' => 'role',
                'description' => 'Add',
            ],
            [
                'name' => 'role_delete',
                'group' => 'role',
                'description' => 'Delete',
            ],
            [
                'name' => 'report_transaction',
                'group' => 'report',
                'description' => 'Transaction',
            ],
            [
                'name' => 'report_survey',
                'group' => 'report',
                'description' => 'Survey',
            ],
            [
                'name' => 'report_meal',
                'group' => 'report',
                'description' => 'Meal',
            ],
        ];

        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value['name'],
                'group_name' => $value['group'],
                'description' => $value['description'],
            ]);
        }

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'merchant']);
        $role1->givePermissionTo(Permission::where('group_name', '!=', 'qr_code_scanner')->get());
        $role2->givePermissionTo(Permission::where('group_name', 'qr_code_scanner')->get());
    }
}
