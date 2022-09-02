<?php

use Illuminate\Database\Seeder;

/* use DB; */
class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //  Model::unguard();
        $sql = file_get_contents(database_path() . '/seeds/states.sql');
        DB::unprepared($sql);
      
    }
}
