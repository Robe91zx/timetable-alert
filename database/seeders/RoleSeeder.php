<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrator']);
        $role2 = Role::create(['name' => 'Secretary']);
        $role3 = Role::create(['name' => 'Profesor']);
        $role4 = Role::create(['name' => 'Student']);
        $role5 = Role::create(['name' => 'Guest']);
        $permission = Permission::create(['name' => 'All', 
                                         'description' => 'Todos los Permisos Disponibles'])->assignRole($role1);
        $permission = Permission::create(['name' => 'Nothing', 
                                         'description' => 'Ningun Permiso'])->assignRole($role5);
        $permission = Permission::create(['name' => 'dashboard', 
                                         'description' => 'Permiso para ingresar al Dashboard'])->syncRoles([$role2,$role3,$role4]);
        $permission = Permission::create(['name' => 'users.home', 
                                         'description' => 'Permiso para ingresar al Sistema de Usuarios'])->syncRoles([$role2,$role3]);
        $permission = Permission::create(['name' => 'users.create', 
                                         'description' => 'Permiso para Crear Usuarios'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'users.delete', 
                                         'description' => 'Permiso para Borrar Usuarios']);
        $permission = Permission::create(['name' => 'users.update', 
                                         'description' => 'Permiso para Actualizar Usuarios'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'roles.home', 
                                         'description' => 'Permiso para ingresar al Sistema de Roles '])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'roles.create', 
                                         'description' => 'Permiso para Crear Roles'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'roles.update', 
                                         'description' => 'Permiso para Actualizar Roles'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'roles.delete', 
                                         'description' => 'Permiso para Eliminar Roles']);
        $permission = Permission::create(['name' => 'permissions.home', 
                                         'description' => 'Permiso para ingresar al Sistema de Permisos'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'permissions.create', 
                                         'description' => 'Permiso para Crear Permisos'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'permissions.update', 
                                         'description' => 'Permiso para Actualizar Permisos'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'permissions.delete', 
                                         'description' => 'Permiso para Eliminar Permisos']);
        $permission = Permission::create(['name' => 'faculty.home', 
                                         'description' => 'Permiso para ingresasr al Sistema de Recursos:Facultades'])->syncRoles([$role2,$role3]);
        $permission = Permission::create(['name' => 'faculty.create', 
                                         'description' => 'Permiso para Crear Facultades'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'faculty.update', 
                                         'description' => 'Permiso para Actualizar Facultades'])->syncRoles([$role2]);
        $permission = Permission::create(['name' => 'faculty.delete', 
                                         'description' => 'Permiso para Eliminar Facultades']);

    }
}
