<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'merchant']);

        User::factory()->count(3)->create();

        User::find(1)->update([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('TestPass123!'),
        ]);
        User::find(1)->assignRole('admin');

        User::find(2)->update([
            'name' => 'KFC',
            'email' => 'kfc@test.com',
            'password' => Hash::make('KFCPass123!'),
        ]);
        User::find(2)->assignRole('merchant');

        User::find(3)->update([
            'name' => 'Tazaj',
            'email' => 'tazaj@test.com',
            'password' => Hash::make('TazajPass123!'),
        ]);
        User::find(3)->assignRole('merchant');
    }
}
