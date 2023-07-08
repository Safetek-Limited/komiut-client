<?php

namespace Database\Seeders;

use App\Models\ModelHasPermission;
use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class SupperUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        $role = Role::firstOrCreate(['name' => 'Supper User']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $user->givePermissionTo($permissions);

    }

}
