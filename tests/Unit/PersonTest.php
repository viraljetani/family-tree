<?php

namespace Tests\Unit;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_seed_database()
    {
        $this->assertDatabaseCount('people',9);
    }

    public function test_database_table_has_queen_margret()
    {
        $this->assertDatabaseHas('people',[
            'name' => 'Queen Margret',
        ]);
    }

    public function test_can_add_a_person()
    {
        $this->withoutExceptionHandling();
        $mother = 'Queen Margret';
        $person = 'Bill';
        $gender = 'male';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $this->assertEquals('CHILD_ADDED',$result);
        
        $this->assertDatabaseHas('people',[
            'name' => 'Bill',
        ]);


    }

    public function test_cannot_add_a_person_if_gender_incorrect()
    {
        $this->withoutExceptionHandling();
        $mother = 'Queen Margret';
        $person = 'Suzy';
        $gender = '';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $this->assertEquals('PERSON_NOT_FOUND',$result);
        
        $this->assertDatabaseMissing('people',[
            'name' => 'Suzy',
        ]);


    }

    public function test_can_add_spouse_and_partner()
    {
        $this->withoutExceptionHandling();
        $mother = 'Queen Margret';
        $person = 'Billy';
        $gender = 'male';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $partner = 'Billy';
        $spouse = 'Suzy';
        $gender = 'female';

        $addSpouse = new Person();
        $result = $addSpouse->addSpouse($partner,$spouse,$gender);

        $this->assertEquals('SPOUSE_ADDED',$result);

        $this->assertDatabaseHas('people',[
            'name' => 'Suzy',
        ]);


    }
}
