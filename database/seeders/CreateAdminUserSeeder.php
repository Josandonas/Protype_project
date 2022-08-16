<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder{

    public function run()
    {
        $user = User::create([
            'email' => 'sandonas@gmail.com',
            'numberCard' =>'00777',
            'dateBorn' =>'15/04/1998',
            'password' => bcrypt('12345')
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
        // print_r($user);
        $user->assignRole([$role->id]);
    }
}
