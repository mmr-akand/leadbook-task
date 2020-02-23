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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->truncate();
        DB::table('companies')->truncate();

        $this->call([
            UsersTableSeeder::class,
            CompaniesTableSeeder::class
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
