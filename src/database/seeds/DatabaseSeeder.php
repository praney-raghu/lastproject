<?php

namespace Ssntpl\Neev\Database\Seeds;

use Ssntpl\Neev\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Ssntpl\Neev\Models\Organisation;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create user permissions
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_permissions']);
        Permission::create(['name' => 'impersonate']);

        // Create organisation permissions
        Permission::create(['name' => 'allow_client', 'guard_name' => 'organisation']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo('manage_users');
        $role->givePermissionTo('manage_permissions');
        $role->givePermissionTo('impersonate');
        $role->save();

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('manage_users');
        $role->givePermissionTo('manage_permissions');
        $role->givePermissionTo('impersonate');
        $role->save();

        // Insert dummy data

        // Create organisation
        $organisation = Organisation::create([
            'name' => 'SSNTPL',
            'code' => 'SST'
            ]);

        $organisation2 = Organisation::create([
            'name' => 'Drosera',
            'code' => 'DRS'
            ]);

        $suborganisation = Organisation::create([
            'name' => 'Suborganisation1',
            'code' => 'ST1'
            ]);

        $suborganisation->owner()->associate($organisation);
        $suborganisation->save();

        $suborganisation2 = Organisation::create([
            'name' => 'Suborganisation2',
            'code' => 'ST2'
            ]);

        $suborganisation2->owner()->associate($organisation);
        $suborganisation2->save();

        // Create users
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'owner_id' => $organisation->getKey(),
        ]);
        //$user->assignRole('admin');

        $user2 = User::create([
            'name' => 'User',
            'email' => 'user@demo.com',
            'password' => bcrypt('password'),
            'owner_id' => $organisation->getKey(),
        ]);
        //$user2->assignRole(Role::findByName('user', 'web'));
        // $user->owner()->associate($organisation);


        $user->organisations()->save($organisation2, [
            'is_active' => true,
            'is_default' => false
            ]);

        $user2->organisations()->save($organisation2, [
            'is_active' => true,
            'is_default' => false
            ]);

        $organisation->members()->save($user, [
            'is_active' => true,
            'is_default' => true
            ]);

        $organisation->members()->save($user2, [
            'is_active' => true,
            'is_default' => true
            ]);

        // Create users
        $subUser1 = User::create([
            'name' => 'sub Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'owner_id' => $suborganisation->getKey(),
        ]);
        // $subUser1->assignRole('administrator');
        // $subUser1->owner()->associate($suborganisation);

        $subUser2 = User::create([
            'name' => 'sub User',
            'email' => 'user@demo.com',
            'password' => bcrypt('password'),
            'owner_id' => $suborganisation->getKey(),
        ]);
        // $subUser2->assignRole('user');
        // $subUser2->owner()->associate($suborganisation);

        $suborganisation->members()->save($subUser1);
        $suborganisation->members()->save($subUser2);
        $suborganisation2->members()->save($subUser1);
        $suborganisation2->members()->save($subUser2);
    }
}
