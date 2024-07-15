<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"user","guard_name":"web","permissions":[]},{"name":"super_admin","guard_name":"web","permissions":["view_activity","view_any_activity","create_activity","update_activity","restore_activity","restore_any_activity","replicate_activity","reorder_activity","delete_activity","delete_any_activity","force_delete_activity","force_delete_any_activity","view_approval::status","view_any_approval::status","create_approval::status","update_approval::status","restore_approval::status","restore_any_approval::status","replicate_approval::status","reorder_approval::status","delete_approval::status","delete_any_approval::status","force_delete_approval::status","force_delete_any_approval::status","view_attende","view_any_attende","create_attende","update_attende","restore_attende","restore_any_attende","replicate_attende","reorder_attende","delete_attende","delete_any_attende","force_delete_attende","force_delete_any_attende","view_attende::code","view_any_attende::code","create_attende::code","update_attende::code","restore_attende::code","restore_any_attende::code","replicate_attende::code","reorder_attende::code","delete_attende::code","delete_any_attende::code","force_delete_attende::code","force_delete_any_attende::code","view_attende::status","view_any_attende::status","create_attende::status","update_attende::status","restore_attende::status","restore_any_attende::status","replicate_attende::status","reorder_attende::status","delete_attende::status","delete_any_attende::status","force_delete_attende::status","force_delete_any_attende::status","view_attende::type","view_any_attende::type","create_attende::type","update_attende::type","restore_attende::type","restore_any_attende::type","replicate_attende::type","reorder_attende::type","delete_attende::type","delete_any_attende::type","force_delete_attende::type","force_delete_any_attende::type","view_department","view_any_department","create_department","update_department","restore_department","restore_any_department","replicate_department","reorder_department","delete_department","delete_any_department","force_delete_department","force_delete_any_department","view_email","view_any_email","create_email","update_email","restore_email","restore_any_email","replicate_email","reorder_email","delete_email","delete_any_email","force_delete_email","force_delete_any_email","view_exception","view_any_exception","create_exception","update_exception","restore_exception","restore_any_exception","replicate_exception","reorder_exception","delete_exception","delete_any_exception","force_delete_exception","force_delete_any_exception","view_position","view_any_position","create_position","update_position","restore_position","restore_any_position","replicate_position","reorder_position","delete_position","delete_any_position","force_delete_position","force_delete_any_position","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_skill::set","view_any_skill::set","create_skill::set","update_skill::set","restore_skill::set","restore_any_skill::set","replicate_skill::set","reorder_skill::set","delete_skill::set","delete_any_skill::set","force_delete_skill::set","force_delete_any_skill::set","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_Themes","page_MyProfilePage","widget_AttendeCodeOverview","widget_AttendesChart","widget_LatestAttendeCode","view_position::type","view_any_position::type","create_position::type","update_position::type","restore_position::type","restore_any_position::type","replicate_position::type","reorder_position::type","delete_position::type","delete_any_position::type","force_delete_position::type","force_delete_any_position::type"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
