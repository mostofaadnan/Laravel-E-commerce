<?php

use Illuminate\Database\Seeder;
use App\Admin;
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
        $user = Admin::create([
        	'name' => 'admin', 
        	'email' => 'vsoft1989@gmail.com',
            'password' => bcrypt('123456'),
            'status'=>'1',
            'image'=>'1603042204png'
        ]);
        $role = Role::create(['name' => 'admin','guard_name'=>'admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
