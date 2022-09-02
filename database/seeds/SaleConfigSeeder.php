<?php

use Illuminate\Database\Seeder;

class SaleConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sale_configs.sql');
        DB::unprepared($sql);
    }
}
