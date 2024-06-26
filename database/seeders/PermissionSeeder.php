<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Create roles and seeds
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create auctions']);
        Permission::create(['name' => 'edit auctions']);
        Permission::create(['name' => 'post bid']);
        Permission::create(['name' => 'post comment']);
        Permission::create(['name' => 'delete comment']);

        // Create roles and assign created permissions
        $role1 = Role::create(['name' => 'userCCT']);
        $role1->givePermissionTo('create auctions');
        $role1->givePermissionTo('post bid');
        $role1->givePermissionTo('post comment');

        $role2 = Role::create(['name' => 'userCCF']);
        $role2->givePermissionTo('post comment');

        $role3 = Role::create(['name' => 'admin']);
        $role3->givePermissionTo('edit auctions');
        $role3->givePermissionTo('delete comment');

        // create demo users
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'isAdmin' => true,
        ]);
        $user->assignRole('admin');

        $user = User::create([
                'name' => 'TestCT',
                'email' => 'testct@test.com',
                'password' => bcrypt('testtest'),
                'credit_card_number' => '1234567890132456',
                'credit_card_verified' => true,
        ]);
        $user->assignRole('userCCT');

        $user = User::create([
            'name' => 'TestCF',
            'email' => 'testcf@test.com',
            'password' => bcrypt('testtest'),
        ]);
        $user->assignRole('userCCF');
    }
}
