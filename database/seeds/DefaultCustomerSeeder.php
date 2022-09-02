<?php

use Illuminate\Database\Seeder;

class DefaultCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/customers.sql');
        DB::unprepared($sql);
    }
}
