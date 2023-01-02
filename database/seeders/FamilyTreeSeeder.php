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
        $arthur = Person::factory()->create([
            'name' => 'King Arthur', 
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => null,
        ]);

        $margret = Person::factory()->create([
            'name' => 'Queen Margret', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $arthur->id,
        ]);

        $arthur->update(['spouse_id' => $margret->id]);
        
        //bill & flora

        //$bill = Person::addPerson($margret->name,'Bill','male',$arthur);
        $bill = Person::factory()->create([
            'name' => 'Bill', 
            'gender' => 'male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $flora = Person::factory()->create([
            'name' => 'Flora', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $bill->id
        ]);
        $bill->update(['spouse_id' => $flora->id]);

            //Victoire & Ted
            $victoire = Person::factory()->create([
                'name' => 'Victoire', 
                'gender' => 'female',
                'father_id' => $bill->id, 
                'mother_id' => $flora->id
            ]);

            $ted = Person::factory()->create([
                'name' => 'Ted', 
                'gender' => 'male',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $victoire->id
            ]);
            $victoire->update(['spouse_id' => $ted->id]);

                //Remus
                Person::addPerson($victoire->name,'Remus','male',$ted);

            //Dominique
            Person::addPerson($flora->name,'Dominique','female',$bill);

            //Louis
            Person::addPerson($flora->name,'Louis','male',$bill);

        //Charlie

        //Percy & Audrey
            
            //Molly
            //Lucy

        //Ronald & Helen

            //Rose & Malfoy
                //Draco & Aster
            //Hugo

        //Ginerva & Harry

            //James & Darcy
                //William

        //Albus & Alice
            //Ron & Ginny
        
        //Lily

        
    }
}
