<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adding the King and Queen as root nodes of the Family
        $arthur = Person::factory(1)->create([
            'name' => 'King Arthur', 
            'father_id' => null, 
            'mother_id' => null]);
            
        $margret = Person::factory(1)->create([
            'name' => 'Queen Margret', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null]);

        
    }
}
