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
            'gender' => 'Female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $arthur->id,
        ]);

        $arthur->update(['spouse_id' => $margret->id]);
        
        //bill & flora

        //$bill = Person::addPerson($margret->name,'Bill','Male',$arthur);
        $bill = Person::factory()->create([
            'name' => 'Bill', 
            'gender' => 'Male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $flora = Person::factory()->create([
            'name' => 'Flora', 
            'gender' => 'Female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $bill->id
        ]);
        $bill->update(['spouse_id' => $flora->id]);

            //Victoire & Ted
            $victoire = Person::factory()->create([
                'name' => 'Victoire', 
                'gender' => 'Female',
                'father_id' => $bill->id, 
                'mother_id' => $flora->id
            ]);

            $ted = Person::factory()->create([
                'name' => 'Ted', 
                'gender' => 'Male',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $victoire->id
            ]);
            $victoire->update(['spouse_id' => $ted->id]);

                //Remus
                Person::addPerson($victoire->name,'Remus','Male',$ted);

            //Dominique
            Person::addPerson($flora->name,'Dominique','Female',$bill);

            //Louis
            Person::addPerson($flora->name,'Louis','Male',$bill);

        //Charlie
        Person::addPerson($margret->name,'Charlie','Male',$arthur);

        //Percy & Audrey
        $percy = Person::factory()->create([
            'name' => 'Percy', 
            'gender' => 'Male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $audrey = Person::factory()->create([
            'name' => 'Audrey', 
            'gender' => 'Female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $percy->id
        ]);
        $percy->update(['spouse_id' => $audrey->id]);
            
            //Molly
            Person::addPerson($audrey->name,'Molly','Female',$percy);
            //Lucy
            Person::addPerson($audrey->name,'Lucy','Female',$percy);

        //Ronald & Helen
        $ronald = Person::factory()->create([
            'name' => 'Ronald', 
            'gender' => 'Male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $helen = Person::factory()->create([
            'name' => 'Helen', 
            'gender' => 'Female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $ronald->id
        ]);
        $ronald->update(['spouse_id' => $helen->id]);

            //Rose & Malfoy
            $rose = Person::factory()->create([
                'name' => 'Rose', 
                'gender' => 'Female',
                'father_id' => $ronald->id, 
                'mother_id' => $helen->id,
                'spouse_id' => null,
            ]);

            $malfoy = Person::factory()->create([
                'name' => 'Malfoy', 
                'gender' => 'Male',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $rose->id
            ]);
            $rose->update(['spouse_id' => $malfoy->id]);
                
                //Draco
                Person::addPerson($rose->name,'Draco','Male',$malfoy);
                //Aster
                Person::addPerson($rose->name,'Aster','Female',$malfoy);
            //Hugo
            Person::addPerson($helen->name,'Hugo','Male',$ronald);

        //Ginerva & Harry
        $ginerva = Person::factory()->create([
            'name' => 'Ginerva', 
            'gender' => 'Female',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $harry = Person::factory()->create([
            'name' => 'Harry', 
            'gender' => 'Male',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $ginerva->id
        ]);
        $ginerva->update(['spouse_id' => $harry->id]);

            //James & Darcy
            $james = Person::factory()->create([
                'name' => 'James', 
                'gender' => 'Male',
                'father_id' => $harry->id, 
                'mother_id' => $ginerva->id,
                'spouse_id' => null
            ]);

            $darcy = Person::factory()->create([
                'name' => 'Darcy', 
                'gender' => 'Female',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $james->id
            ]);
            $james->update(['spouse_id' => $darcy->id]);

                //William
                Person::addPerson($darcy->name,'William','Male',$james);

        //Albus & Alice
        
        $albus = Person::factory()->create([
            'name' => 'Albus', 
            'gender' => 'Male',
            'father_id' => $harry->id, 
            'mother_id' => $ginerva->id,
            'spouse_id' => null
        ]);

        $alice = Person::factory()->create([
            'name' => 'Alice', 
            'gender' => 'Female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $albus->id
        ]);
        $albus->update(['spouse_id' => $alice->id]);
            
            //Ron
            Person::addPerson($alice->name,'Ron','Male',$albus);
            
            //Ginny
            Person::addPerson($alice->name,'Ginny','Female',$albus);
        
        //Lily
        Person::addPerson($ginerva->name,'Lily','Female',$harry);
        
    }
}
