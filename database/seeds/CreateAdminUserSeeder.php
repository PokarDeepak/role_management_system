<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin user and assign Admin permission

        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'Admin'],['name' => 'user']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole($role->id);

        // Create User Role and assign User permission

        $normaluser = User::create([
            'name' => 'user', 
            'email' => 'user@user.com',
            'password' => bcrypt('123456')
        ]);

        $userrole = Role::create(['name' => 'user']);        
        $userpermissions = Permission::whereIn('id', array(5, 6, 7, 8))->get();
        $userrole->syncPermissions($userpermissions);
        $normaluser->assignRole($userrole->id);
    }
}
