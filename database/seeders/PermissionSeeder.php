<?php

namespace Database\Seeders;

use Hamcrest\Arrays\IsArray;
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
            Role::updateOrCreate($role);
        }

        $modules = [
                'data' => [
                    'incomes',
                    'expenses',
                    'my wallets',
                    'budget' => [
                        'read',
                        'update'
                    ]
                ],
                'master data' => [
                    'income categories',
                    'expense categories',
                    'wallets'
                ],
                'auth' => [
                    'users',
                    'roles' => [
                        'permissions',
                        'create',
                        'read',
                        'update',
                        'delete',
                    ],
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
            foreach ($subModules as $subModule => $value) {
                if (!is_array($value)){
                    foreach ($permissions as $permission) {
                        $permissionName = $module . '-' . $value . '-' . $permission;

                        $permission = \Spatie\Permission\Models\Permission::updateOrCreate([
                            'name' => $permissionName,
                            'guard_name' => 'api'
                        ]);

                        $role = Role::where('name', 'super-admin')->first();
                        $role->givePermissionTo($permission);
                        }
                } else {
                    foreach ($value as $subSubModule) {
                        $permissionName = $module . '-' . $subModule . '-' . $subSubModule;

                        $permission = \Spatie\Permission\Models\Permission::updateOrCreate([
                            'name' => $permissionName,
                            'guard_name' => 'api'
                        ]);

                        $role = Role::where('name', 'super-admin')->first();
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
        DB::commit();
    }
}
