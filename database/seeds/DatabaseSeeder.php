<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(DefaultVatSeeder::class);
        $this->call(NumberFormatSeeder::class);
        $this->call(CompanyInfoSeeder::class);
        $this->call(TimezoneSeeder::class);
        $this->call(LanguageSeeder::class);
    }
}
