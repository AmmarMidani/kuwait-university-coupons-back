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
                'description' => 'dashboard',
            ],
            [
                'name' => 'user_browse',
                'group' => 'user',
                'description' => 'user_browse',
            ],
            [
                'name' => 'user_read',
                'group' => 'user',
                'description' => 'user_read',
            ],
            [
                'name' => 'user_edit',
                'group' => 'user',
                'description' => 'user_edit',
            ],
            [
                'name' => 'user_add',
                'group' => 'user',
                'description' => 'user_add',
            ],
            [
                'name' => 'student_browse',
                'group' => 'student',
                'description' => 'student_browse',
            ],
            [
                'name' => 'student_read',
                'group' => 'student',
                'description' => 'student_read',
            ],
            [
                'name' => 'student_edit',
                'group' => 'student',
                'description' => 'student_edit',
            ],
            [
                'name' => 'student_add',
                'group' => 'student',
                'description' => 'student_add',
            ],
            [
                'name' => 'meal_browse',
                'group' => 'meal',
                'description' => 'meal_browse',
            ],
            [
                'name' => 'meal_read',
                'group' => 'meal',
                'description' => 'meal_read',
            ],
            [
                'name' => 'meal_edit',
                'group' => 'meal',
                'description' => 'meal_edit',
            ],
            [
                'name' => 'meal_add',
                'group' => 'meal',
                'description' => 'meal_add',
            ],
            [
                'name' => 'meal_price_browse',
                'group' => 'meal_price',
                'description' => 'meal_price_browse',
            ],
            [
                'name' => 'meal_price_read',
                'group' => 'meal_price',
                'description' => 'meal_price_read',
            ],
            [
                'name' => 'meal_price_edit',
                'group' => 'meal_price',
                'description' => 'meal_price_edit',
            ],
            [
                'name' => 'meal_price_add',
                'group' => 'meal_price',
                'description' => 'meal_price_add',
            ],
            [
                'name' => 'nationality_browse',
                'group' => 'nationality',
                'description' => 'nationality_browse',
            ],
            [
                'name' => 'nationality_read',
                'group' => 'nationality',
                'description' => 'nationality_read',
            ],
            [
                'name' => 'nationality_edit',
                'group' => 'nationality',
                'description' => 'nationality_edit',
            ],
            [
                'name' => 'nationality_add',
                'group' => 'nationality',
                'description' => 'nationality_add',
            ],
            [
                'name' => 'question_browse',
                'group' => 'question',
                'description' => 'question_browse',
            ],
            [
                'name' => 'question_read',
                'group' => 'question',
                'description' => 'question_read',
            ],
            [
                'name' => 'question_edit',
                'group' => 'question',
                'description' => 'question_edit',
            ],
            [
                'name' => 'question_add',
                'group' => 'question',
                'description' => 'question_add',
            ],
            [
                'name' => 'manual_meal_entry_browse',
                'group' => 'manual_meal_entry',
                'description' => 'manual_meal_entry_browse',
            ],
            [
                'name' => 'manual_meal_entry_add',
                'group' => 'manual_meal_entry',
                'description' => 'manual_meal_entry_add',
            ],
            [
                'name' => 'qr_code_scanner_browse',
                'group' => 'qr_code_scanner',
                'description' => 'qr_code_scanner_browse',
            ],
            [
                'name' => 'qr_code_scanner_add',
                'group' => 'qr_code_scanner',
                'description' => 'qr_code_scanner_add',
            ],
            [
                'name' => 'role_browse',
                'group' => 'role',
                'description' => 'role_browse',
            ],
            [
                'name' => 'role_read',
                'group' => 'role',
                'description' => 'role_read',
            ],
            [
                'name' => 'role_edit',
                'group' => 'role',
                'description' => 'role_edit',
            ],
            [
                'name' => 'role_add',
                'group' => 'role',
                'description' => 'role_add',
            ],
            [
                'name' => 'role_delete',
                'group' => 'role',
                'description' => 'role_delete',
            ],
            [
                'name' => 'report_transaction',
                'group' => 'report',
                'description' => 'report_transaction',
            ],
            [
                'name' => 'report_survey',
                'group' => 'report',
                'description' => 'report_survey',
            ],
            [
                'name' => 'report_meal',
                'group' => 'report',
                'description' => 'report_meal',
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
