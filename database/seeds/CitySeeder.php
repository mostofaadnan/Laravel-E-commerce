<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sql = file_get_contents(database_path() . '/seeds/cities.sql');
        DB::unprepared($sql);
    }
}
