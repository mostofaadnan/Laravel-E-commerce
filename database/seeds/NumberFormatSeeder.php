<?php

use Illuminate\Database\Seeder;

class NumberFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/number_formats.sql');
        DB::unprepared($sql);
    }
}
