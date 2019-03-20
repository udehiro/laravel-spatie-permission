<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '1',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        DB::table('roles')->insert([
            'id' => '1',
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            [
                'id' => '1',
                'name' => 'dashboard',
                'guard_name' => 'web'
            ], [
                'id' => '2',
                'name' => 'data.read',
                'guard_name' => 'web'
            ], [
                'id' => '3',
                'name' => 'data.create',
                'guard_name' => 'web'
            ], [
                'id' => '4',
                'name' => 'data.delete',
                'guard_name' => 'web'
            ], [
                'id' => '5',
                'name' => 'data.update',
                'guard_name' => 'web'
            ]
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\User',
            'model_id' => '1'
        ]);

        DB::table('role_has_permissions')->insert([
            [
                'permission_id' => '1',
                'role_id' => '1'
            ], [
                'permission_id' => '2',
                'role_id' => '1'
            ], [
                'permission_id' => '3',
                'role_id' => '1'
            ], [
                'permission_id' => '4',
                'role_id' => '1'
            ], [
                'permission_id' => '5',
                'role_id' => '1'
            ]
        ]);
    }
}
