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
        $this->assertDatabaseCount('people',31);
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

    public function test_it_can_search_relation_for_son()
    {
        $person = new Person();

        $relations = $person->getRelationship('Queen Margret','Son');
        $this->assertEquals("Bill Charlie Percy Ronald",$relations);

        $relations = $person->getRelationship('Harry','Son');
        $this->assertEquals("James Albus",$relations);

    }

    public function test_it_can_search_relation_for_daughter()
    {
        $person = new Person();

        $relations = $person->getRelationship('Queen Margret','Daughter');
        $this->assertEquals("Ginerva",$relations);

        $relations = $person->getRelationship('Harry','Daughter');
        $this->assertEquals("Lily",$relations);

    }

    public function test_it_can_search_relation_for_siblings()
    {
        $person = new Person();

        $relations = $person->getRelationship('Charlie','Siblings');
        $this->assertEquals("Bill Percy Ronald Ginerva",$relations);

        $relations = $person->getRelationship('Victoire','Siblings');
        $this->assertEquals("Dominique Louis",$relations);

    }

    public function test_it_can_search_relation_for_maternal_aunt()
    {
        $mother = 'Helen';
        $person = 'Belrose';
        $gender = 'female';

        $child = new Person();
        $result = $child->addPerson($mother,$person,$gender);

        $person = new Person();

        $relations = $person->getRelationship('Aster','Maternal-Aunt');
        $this->assertEquals('Belrose',$relations);

    }

    public function test_it_can_search_relation_for_paternal_aunt()
    {

        $person = new Person();

        $relations = $person->getRelationship('Louis','Paternal-Aunt');
        $this->assertEquals('Ginerva',$relations);

    }

    public function test_it_can_search_relation_for_maternal_uncle()
    {

        $person = new Person();

        $relations = $person->getRelationship('Remus','Maternal-Uncle');
        $this->assertEquals('Louis',$relations);

    }

    public function test_it_can_search_relation_for_paternal_uncle()
    {

        $person = new Person();

        $relations = $person->getRelationship('Louis','Paternal-Uncle');
        $this->assertEquals('Charlie Percy Ronald',$relations);

    }

    public function test_it_can_search_relation_for_sister_in_law()
    {
        $person = new Person();

        $relations = $person->getRelationship('Lily','Sister-In-Law');
        $this->assertEquals(['Darcy','Alice'],$relations);

        $relations = $person->getRelationship('Charlie','Sister-In-Law');
        $this->assertEquals(['Flora','Audrey','Helen'],$relations);

        $relations = $person->getRelationship('Helen','Sister-In-Law');
        $this->assertEquals(['Ginerva'],$relations);



    }

    public function test_it_can_search_relation_for_brother_in_law()
    {
        $person = new Person();

        $relations = $person->getRelationship('Charlie','Brother-In-Law');
        $this->assertEquals(['Harry'],$relations);

        $relations = $person->getRelationship('Malfoy','Brother-In-Law');
        $this->assertEquals(['Hugo'],$relations);

    }
}
