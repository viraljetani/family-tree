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
        Person::addPerson($margret->name,'Charlie','male',$arthur);

        //Percy & Audrey
        $percy = Person::factory()->create([
            'name' => 'Percy', 
            'gender' => 'male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $audrey = Person::factory()->create([
            'name' => 'Audrey', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $percy->id
        ]);
        $percy->update(['spouse_id' => $audrey->id]);
            
            //Molly
            Person::addPerson($audrey->name,'Molly','female',$percy);
            //Lucy
            Person::addPerson($audrey->name,'Lucy','female',$percy);

        //Ronald & Helen
        $ronald = Person::factory()->create([
            'name' => 'Ronald', 
            'gender' => 'male',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $helen = Person::factory()->create([
            'name' => 'Helen', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $ronald->id
        ]);
        $ronald->update(['spouse_id' => $helen->id]);

            //Rose & Malfoy
            $rose = Person::factory()->create([
                'name' => 'Rose', 
                'gender' => 'female',
                'father_id' => $ronald->id, 
                'mother_id' => $helen->id,
                'spouse_id' => null,
            ]);

            $malfoy = Person::factory()->create([
                'name' => 'Malfoy', 
                'gender' => 'male',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $rose->id
            ]);
            $rose->update(['spouse_id' => $malfoy->id]);
                
                //Draco
                Person::addPerson($rose->name,'Draco','male',$malfoy);
                //Aster
                Person::addPerson($rose->name,'Aster','female',$malfoy);
            //Hugo
            Person::addPerson($helen->name,'Hugo','male',$ronald);

        //Ginerva & Harry
        $ginerva = Person::factory()->create([
            'name' => 'Ginerva', 
            'gender' => 'female',
            'father_id' => $arthur->id, 
            'mother_id' => $margret->id
        ]);

        $harry = Person::factory()->create([
            'name' => 'Harry', 
            'gender' => 'male',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $ginerva->id
        ]);
        $ginerva->update(['spouse_id' => $harry->id]);

            //James & Darcy
            $james = Person::factory()->create([
                'name' => 'James', 
                'gender' => 'male',
                'father_id' => $harry->id, 
                'mother_id' => $ginerva->id,
                'spouse_id' => null
            ]);

            $darcy = Person::factory()->create([
                'name' => 'Darcy', 
                'gender' => 'female',
                'father_id' => null, 
                'mother_id' => null,
                'spouse_id' => $james->id
            ]);
            $james->update(['spouse_id' => $darcy->id]);

                //William
                Person::addPerson($darcy->name,'William','male',$james);

        //Albus & Alice
        
        $albus = Person::factory()->create([
            'name' => 'Albus', 
            'gender' => 'male',
            'father_id' => $harry->id, 
            'mother_id' => $ginerva->id,
            'spouse_id' => null
        ]);

        $alice = Person::factory()->create([
            'name' => 'Alice', 
            'gender' => 'female',
            'father_id' => null, 
            'mother_id' => null,
            'spouse_id' => $albus->id
        ]);
        $albus->update(['spouse_id' => $alice->id]);
            
            //Ron
            Person::addPerson($alice->name,'Ron','male',$albus);
            
            //Ginny
            Person::addPerson($alice->name,'Ginny','female',$albus);
        
        //Lily
        Person::addPerson($ginerva->name,'Lily','female',$harry);
        
    }
}
