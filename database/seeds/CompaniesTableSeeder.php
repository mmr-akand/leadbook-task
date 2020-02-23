<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        factory(Company::class)->create([
            'id' => 1
        ]);
        
        factory(Company::class)->create([
            'id' => 2
        ]);
        
        factory(Company::class)->create([
            'id' => 3
        ]);
        
        factory(Company::class)->create([
            'id' => 4
        ]);
        
        factory(Company::class)->create([
            'id' => 5
        ]);
    }
}
