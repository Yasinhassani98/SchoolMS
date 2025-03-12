<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions = [
            'view-roles',

            'view-permissions',

            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            'view-teachers',
            'create-teachers',
            'edit-teachers',
            'delete-teachers',
            
            'view-students',
            'create-students',
            'edit-students',
            'delete-students',
            
            'view-parents',
            'create-parents',
            'edit-parents',
            'delete-parents',
            
            'view-classrooms',
            'create-classrooms',
            'edit-classrooms',
            'delete-classrooms',
            
            'view-subjects',
            'create-subjects',
            'edit-subjects',
            'delete-subjects',
            
            'view-levels',
            'create-levels',
            'edit-levels',
            'delete-levels',
            
            'view-academic-years',
            'create-academic-years',
            'edit-academic-years',
            'delete-academic-years',
            
            'view-attendances',
            'create-attendances',
            'edit-attendances',
            'delete-attendances',
            
            'view-marks',
            'create-marks',
            'edit-marks',
            'delete-marks',
        ];
        
        // Teacher permissions
        $teacherPermissions = [
            'view-own-profile',
            'edit-own-profile',
            
            'view-assigned-classrooms',
            'view-assigned-subjects',
            
            'view-attendances',
            'create-attendances',
            'edit-attendances',
            
            'view-marks',
            'create-marks',
            'edit-marks',
            
            'view-students',
        ];
        
        // Student permissions
        $studentPermissions = [
            'view-own-profile',
            'edit-own-profile',
            
            'view-own-classroom',
            'view-own-subjects',
            'view-own-marks',
            'view-own-attendances',
        ];
        
        // Parent permissions
        $parentPermissions = [
            'view-own-profile',
            'edit-own-profile',
            
            'view-children',
            'view-children-marks',
            'view-children-attendances',
            'view-children-classrooms',
        ];
        
        // Create all permissions
        $allPermissions = array_unique(array_merge(
            $adminPermissions,
            $teacherPermissions,
            $studentPermissions,
            $parentPermissions,
            ['view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions']
        ));
        
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($adminPermissions);
        
        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherRole->givePermissionTo($teacherPermissions);
        
        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo($studentPermissions);
        
        $parentRole = Role::create(['name' => 'parent']);
        $parentRole->givePermissionTo($parentPermissions);

        $superAdminRole = Role::create(['name' => 'superadmin']);
        $superAdminRole->givePermissionTo($allPermissions);
    }
}
