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
        $this->assertDatabaseCount('people',2);
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
        $person = 'Bill';
        $gender = '';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $this->assertEquals('PERSON_NOT_FOUND',$result);
        
        $this->assertDatabaseMissing('people',[
            'name' => 'Bill',
        ]);


    }

    public function test_can_add_spouse_and_partner()
    {
        $this->withoutExceptionHandling();
        $mother = 'Queen Margret';
        $person = 'Bill';
        $gender = 'male';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $partner = 'Bill';
        $spouse = 'Flora';
        $gender = 'female';

        $spouse = new Person();
        $result = $spouse->addSpouse($partner,$spouse,$gender);

        $this->assertEquals('SPOUSE_ADDED',$result);

        $this->assertDatabaseMissing('people',[
            'name' => 'Flora',
        ]);


    }
}
