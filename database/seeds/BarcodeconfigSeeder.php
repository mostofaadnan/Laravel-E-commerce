<?php

use Illuminate\Database\Seeder;

class BarcodeconfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/barcode_configarations.sql');
        DB::unprepared($sql);
    }
}
