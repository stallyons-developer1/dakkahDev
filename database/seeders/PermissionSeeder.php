<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Permission::insert([
        [
            'name' => 'User Index',
            'description' => 'Users Index',
            'code' => '99'
        ],
        [
            'name' => 'Add User',
            'description' => 'Add User',
            'code' => '100'
        ],[
            'name' => 'Edit User',
            'description' => 'Edit User',
            'code' => '101'
        ],[
            'name' => 'Delete User',
            'description' => 'Delete User',
            'code' => '102'
        ],
        [
            'name' => 'Index Courses',
            'description' => 'Index Courses',
            'code' => '103'
        ],
        [
            'name' => 'Add Course',
            'description' => 'Add Course',
            'code' => '104'
        ],
        [
            'name' => 'Edit Course',
            'description' => 'Edit Course',
            'code' => '105'
        ],
        [
            'name' => 'Delete Course',
            'description' => 'Delete Course',
            'code' => '106'
        ],
        [
            'name' => 'Subscription List',
            'description' => 'Subscription List',
            'code' => '107'
        ],
        [
            'name' => 'Add Subscription',
            'description' => 'Add Subscription',
            'code' => '108'
        ],
        [
            'name' => 'Cancel Subscription',
            'description' => 'Cancel Subscription',
            'code' => '109'
        ],
        [
            'name' => 'Index Contact',
            'description' => 'Index Contact',
            'code' => '110'
        ],
        [
            'name' => 'Index Permission',
            'description' => 'Index Permission',
            'code' => '111'
        ],
        [
            'name' => 'Add Permission',
            'description' => 'Add Permission',
            'code' => '112'
        ],
        [
            'name' => 'Edit Permission',
            'description' => 'Edit Permission',
            'code' => '113'
        ],
        [
            'name' => 'Delete Permission',
            'description' => 'Delete Permission',
            'code' => '114'
        ],
        [
            'name' => 'Index Role',
            'description' => 'Index Role',
            'code' => '115'
        ],
        [
            'name' => 'Add Role',
            'description' => 'Add Role',
            'code' => '116'
        ],
        [
            'name' => 'Edit Role',
            'description' => 'Edit Role',
            'code' => '117'
        ],
        [
            'name' => 'Delete Role',
            'description' => 'Delete Role',
            'code' => '118'
        ],
        [
            'name' => 'Dashboard',
            'description' => 'Dashboard',
            'code' => '119'
        ],
        ]);
    }
}
