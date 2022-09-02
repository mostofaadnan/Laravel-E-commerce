<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $sql = file_get_contents(database_path() . '/seeds/permissions.sql');
        DB::unprepared($sql);
    }
}
