<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'people';
    
    /**
     * guarded
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * relations
     *
     * @var array
     */
    protected $relations = [
        'Son',
        'Daughter',
        'Siblings',
        'Sister-In-Law',
        'Brother-In-Law',
        'Maternal-Aunt',
        'Paternal-Aunt',
        'Maternal-Uncle',
        'Paternal-Uncle'
    ];
    
    /**
     * father
     *
     * @return void
     */
    public function father()
    {
        return $this->belongsTo(Father::class,'father_id','id');
    }
    
    /**
     * mother
     *
     * @return void
     */
    public function mother()
    {
        return $this->belongsTo(Mother::class,'mother_id','id');
    }
    
    /**
     * spouse
     *
     * @return void
     */
    public function spouse()
    {
        return $this->belongsTo(Spouse::class,'spouse_id','id');
    }

    public static function addPerson($mother, $person, $gender, Person $father = null)
    {
        $mother = Person::where('name',$mother)->first() ?? null;
        if($mother && ($gender == 'male' || $gender == 'female'))
        {
            $child = Person::create([
                'name' => $person,
                'gender' => $gender,
                'mother_id' => $mother->id, 
                'father_id' => $father->id ?? null
            ]);
            return 'CHILD_ADDED';
        }
        else
        {
            return 'PERSON_NOT_FOUND';
        }
    }

    public function addSpouse($partner, $person, $gender)
    {
        $partner = Person::where('name',$partner)->first() ?? null;

        if($partner && ($gender == 'male' || $gender == 'female'))
        {
            $spouse = Person::create(['name' => $person,'gender' => $gender, 'spouse_id' => $partner->id]);

            $partner->update(['spouse_id' => $spouse->id]);
            return 'SPOUSE_ADDED';
        }
        else
        {
            return 'PERSON_NOT_FOUND';
        }

    }

    public function getSiblings(Person $person)
    {
        // Find a parent of the person (mother)
        // Check the total number of Children of that parent
        // if more than 1 then has siblings 
        // get all children of that parent except the Person 
    }

    public function getRelationship($personName, $relation)
    {
        $person = Person::where('name',$personName)->first() ?? null;

        if($person && in_array($relation,$this->relations))
        {
            $result = $this->getRelatedNames($person, $relation);
            return $result;
        }
        else
        {
            return 'PERSON_NOT_FOUND';
        }

    }



    
    /**
     * getRelationship
     *
     * @param  Person $person
     * @param  string $relationship
     * @return string
     */
    protected function getRelatedNames(Person $person, $relationship)
    {
        switch ($relationship) {
            case $this->relations[0]: //son
                
                $query = Person::query();
                return $query->when($person->gender == 'male', function ($q) use ($person,$relationship) {
                    return $q->where('father_id',$person->id)->where('gender','male');
                })
                ->when($person->gender == 'female', function ($q) use ($person,$relationship) {
                    return $q->where('mother_id',$person->id)->where('gender','male');
                })
                ->pluck('name')
                ->toArray();

                break;
            
            case $this->relations[1]: //Daughter

                $query = Person::query();
                return $query->when($person->gender == 'male', function ($q) use ($person,$relationship) {
                    return $q->where('father_id',$person->id)->where('gender','female');
                })
                ->when($person->gender == 'female', function ($q) use ($person,$relationship) {
                    return $q->where('mother_id',$person->id)->where('gender','female');
                })
                ->pluck('name')
                ->toArray();

                break;
            
            case $this->relations[2]: //Siblings
                
                $query = Person::query();
                //Find Father/Mother of that person 
                //Find Son/Daughter
                return $query->when(isset($person->mother_id), function ($q) use ($person,$relationship) {
                    return $q->where('mother_id',$person->mother_id)->where('id','!=',$person->id);
                })
                ->pluck('name')
                ->toArray();

                break;
            
            case $this->relations[3]: //Sister-In-Law
                # code...
                break;
            
            case $this->relations[4]: //Brother-In-Law
                # code...
                break;
            
            case $this->relations[5]: //Maternal-Aunt
                # code...
                break;
            
            case $this->relations[6]: //Paternal-Aunt
                # code...
                break;
            
            case $this->relations[7]: //Maternal-Uncle
                # code...
                break;
            
            case $this->relations[8]: //Paternal-Uncle
                # code...
                break;
            
            default: //None
                $relation = 'NONE';
                break;

            return $relation;
        
        }
    }
}
