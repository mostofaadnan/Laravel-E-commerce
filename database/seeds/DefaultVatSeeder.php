<?php

use Illuminate\Database\Seeder;

class DefaultVatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/vat_settings.sql');
        DB::unprepared($sql);
    }
}
