<?php

use Illuminate\Database\Seeder;

class BarcodeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/barcode_types.sql');
        DB::unprepared($sql);
    }
}
