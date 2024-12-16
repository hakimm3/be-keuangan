<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        $roles = [
            [
                'name' => 'super-admin',
                'guard_name' => 'api'
            ],
            [
                'name' => 'admin',
                'guard_name' => 'api'
            ],
            [
                'name' => 'user',
                'guard_name' => 'api'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $modules = [
                'data' => [
                    'incomes',
                    'expenses',
                    'my wallets'
                ],
                'master data' => [
                    'income categories',
                    'expense categories',
                    'wallets'
                ],
                'auth' => [
                    'users',
                    'roles',
                    'permissions'
                ]
            ];

        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        foreach ($modules as $module => $subModules) {
            foreach ($subModules as $subModule) {
                foreach ($permissions as $permission) {
                    $permissionName = $module . '-' . $subModule . '-' . $permission;

                    $permission = \Spatie\Permission\Models\Permission::create([
                        'name' => $permissionName,
                        'guard_name' => 'api'
                    ]);

                    $role = Role::where('name', 'super-admin')->first();
                    $role->givePermissionTo($permission);
                }
            }
        }
        DB::commit();
    }
}
