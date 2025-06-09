<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        DB::statement('TRUNCATE role_has_permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $permissions = [
            [
                'name' => 'group_a_1',
                'group' => 'Group A',
                'description' => 'test A.1',
            ],
            [
                'name' => 'group_a_2',
                'group' => 'Group A',
                'description' => 'test A.2',
            ],
            [
                'name' => 'group_a_3',
                'group' => 'Group A',
                'description' => 'test A.3',
            ],
            [
                'name' => 'group_b_1',
                'group' => 'Group B',
                'description' => 'test B.1',
            ],
            [
                'name' => 'group_b_2',
                'group' => 'Group B',
                'description' => 'test B.2',
            ],
            [
                'name' => 'group_c_1',
                'group' => 'Group C',
                'description' => 'test C.1',
            ],
            [
                'name' => 'group_c_2',
                'group' => 'Group C',
                'description' => 'test C.2',
            ],
            [
                'name' => 'group_c_3',
                'group' => 'Group C',
                'description' => 'test C.3',
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
        $permissions = Permission::pluck('id')->toArray();
        $role1->permissions()->sync($permissions);

        $role2 = Role::create(['name' => 'merchant']);
        $permissions = Permission::where('name', 'group_c_1')->pluck('id')->toArray();
        $role2->permissions()->sync($permissions);
    }
}
