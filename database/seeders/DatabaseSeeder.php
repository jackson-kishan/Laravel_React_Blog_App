<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\RolesEnum;
use App\Models\Feature;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enum\PermissionsEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $commenterRole = Role::create(['name' => RolesEnum::Commenter->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

        $manageFeaturesPermission = Permission::create([
           'name' => PermissionsEnum::ManageFeatures->value,
        ]);
        $manageCommentsPermission = Permission::create([
           'name' => PermissionsEnum::ManageComments->value,
        ]);
        $manageUsersPermission = Permission::create([
           'name' => PermissionsEnum::ManageUsers->value,
        ]);
        $upvoteDownvotePermission = Permission::create([
           'name' => PermissionsEnum::UpvoteDownvotes->value,
        ]);

        $userRole->syncPermissions([$upvoteDownvotePermission]);
        $commenterRole->syncPermissions([$upvoteDownvotePermission, $manageCommentsPermission]);
        $adminRole->syncPermissions([
            $upvoteDownvotePermission,
            $manageCommentsPermission,
            $manageFeaturesPermission,
            $manageUsersPermission
        ]);



        User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
            'password' => 'user1234',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
            'password' => 'commenter1234'
        ])->assignRole(RolesEnum::Commenter);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'admin1234',
        ])->assignRole(RolesEnum::Admin);

        Feature::factory(100)->create();

    }
}
