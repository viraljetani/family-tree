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
    
    /**
     * addPerson
     *
     * @param  mixed $mother
     * @param  mixed $person
     * @param  mixed $gender
     * @param  mixed $father
     * @return void
     */
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
    
    /**
     * addSpouse
     *
     * @param  mixed $partner
     * @param  mixed $person
     * @param  mixed $gender
     * @return void
     */
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
    
    /**
     * getSiblings
     *
     * @param  mixed $person
     * @return void
     */
    public function getSiblings(Person $person)
    {
        // Find a parent of the person (mother)
        // Check the total number of Children of that parent
        // if more than 1 then has siblings 
        // get all children of that parent except the Person 
    }
    
    /**
     * getRelationship
     *
     * @param  mixed $personName
     * @param  mixed $relation
     * @return void
     */
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
                $son = [];
                $query = Person::query();
                $son = $query->when($person->gender == 'male', function ($q) use ($person,$relationship) {
                    return $q->where('father_id',$person->id)->where('gender','male');
                })
                ->when($person->gender == 'female', function ($q) use ($person,$relationship) {
                    return $q->where('mother_id',$person->id)->where('gender','male');
                })
                ->pluck('name')
                ->toArray();

                return empty($son) ? 'PERSON_NOT_FOUND' : implode(" ",$son);
                break;
            
            case $this->relations[1]: //Daughter
                $daughter = [];
                $query = Person::query();
                $daughter = $query->when($person->gender == 'male', function ($q) use ($person,$relationship) {
                    return $q->where('father_id',$person->id)->where('gender','female');
                })
                ->when($person->gender == 'female', function ($q) use ($person,$relationship) {
                    return $q->where('mother_id',$person->id)->where('gender','female');
                })
                ->pluck('name')
                ->toArray();

                return empty($daughter) ? 'PERSON_NOT_FOUND' : implode(" ",$daughter);

                break;
            
            case $this->relations[2]: //Siblings
                $siblings = [];
                $query = Person::query();
                //Find Father/Mother of that person 
                //Find Son/Daughter
                $siblings = $query->when(isset($person->mother_id), function ($q) use ($person) {
                    return $q->where('mother_id',$person->mother_id)->where('id','!=',$person->id);
                })
                ->pluck('name')
                ->toArray();

                return empty($siblings) ? 'PERSON_NOT_FOUND' : implode(" ",$siblings);

                break;
            
            case $this->relations[3]: //Sister-In-Law
                $sisterInLaws = [];
                //Spouse's sisters
                if(isset($person->spouse_id))
                {
                    $spouse = Person::where('id',$person->spouse_id)->first();
                    $spouseMother = Person::where('id',$spouse->mother_id)->first();
                    $sisterInLaws = Person::where('mother_id',$spouseMother->id)
                                    ->where('gender','female')
                                    ->where('id',"!=",$person->spouse_id)
                                    ->pluck('name')->toArray();
                }

                $siblingWives = [];
                //Wives of siblings
                if($person->mother_id)
                {
                    $siblingWives = Person::where('mother_id',$person->mother_id)->where('id',"!=",$person->id)->where('gender','male')->pluck('spouse_id')->toArray();
                    if(!empty($siblingWives)){
                        $siblingWives = Person::whereIn('id',$siblingWives)->pluck('name')->toArray();
                    }
                }
                $final = array_merge($sisterInLaws,$siblingWives);

                return empty($final) ? 'PERSON_NOT_FOUND' : $final;

                break;
            
            case $this->relations[4]: //Brother-In-Law
                $brotherInLaws = [];
                //Spouse's brothers
                if(isset($person->spouse_id))
                {
                    $spouse = Person::where('id',$person->spouse_id)->first();
                    $spouseMother = Person::where('id',$spouse->mother_id)->first();
                    
                    $brotherInLaws = Person::where('mother_id',$spouseMother->id)
                                    ->where('gender','male')
                                    ->where('id',"!=",$person->spouse_id)
                                    ->pluck('name')->toArray();
                    return $brotherInLaws;
                }
                $siblingHusbands = [];
                //Husbands of siblings
                if($person->mother_id){
                    $siblingHusbands = Person::where('mother_id',$person->mother_id)->where('id',"!=",$person->id)->where('gender','female')->pluck('spouse_id')->toArray();
                    if(!empty($siblingHusbands)){
                        $siblingHusbands = Person::whereIn('id',$siblingHusbands)->pluck('name')->toArray();
                    }
                }
                $final = array_merge($brotherInLaws,$siblingHusbands);
                
                return empty($final) ? 'PERSON_NOT_FOUND' : $final;

                break;
            
            case $this->relations[5]: //Maternal-Aunt
                //Mother's sisters
                $maternalAunt = [];
                if(isset($person->mother_id))
                {
                    $personMother = Person::where('id',$person->mother_id)->first();
                    $herMother = Person::where('id',$personMother->mother_id)->where('gender','female')->first();

                    $maternalAunt = Person::where('mother_id',$herMother->id)->where('id','!=',$personMother->id)->where('gender','female')->pluck('name')->toArray();

                }
                return empty($maternalAunt) ? 'PERSON_NOT_FOUND' : implode(" ",$maternalAunt);

                break;
            
            case $this->relations[6]: //Paternal-Aunt
                //Father's sisters
                $paternalAunt = [];
                if(isset($person->father_id))
                {
                    $personFather = Person::where('id',$person->father_id)->first();
                    $herMother = Person::where('id',$personFather->mother_id)->where('gender','female')->first();

                    $paternalAunt = Person::where('mother_id',$herMother->id)->where('id','!=',$personFather->id)->where('gender','female')->pluck('name')->toArray();

                }

                return empty($paternalAunt) ? 'PERSON_NOT_FOUND' : implode(" ",$paternalAunt);

                break;
            
            case $this->relations[7]: //Maternal-Uncle
                $maternalUncle = [];
                if(isset($person->mother_id))
                {
                    $personMother = Person::where('id',$person->mother_id)->first();
                    $herMother = Person::where('id',$personMother->mother_id)->where('gender','female')->first();

                    $maternalUncle = Person::where('mother_id',$herMother->id)->where('id','!=',$personMother->id)->where('gender','male')->pluck('name')->toArray();

                }

                return empty($maternalUncle) ? 'PERSON_NOT_FOUND' : implode(" ",$maternalUncle);

                break;
            
            case $this->relations[8]: //Paternal-Uncle
                $paternalUncle = [];
                if(isset($person->father_id))
                {
                    $personFather = Person::where('id',$person->father_id)->first();
                    $herMother = Person::where('id',$personFather->mother_id)->where('gender','female')->first();

                    $paternalUncle = Person::where('mother_id',$herMother->id)->where('id','!=',$personFather->id)->where('gender','male')->pluck('name')->toArray();

                }

                return empty($paternalUncle) ? 'PERSON_NOT_FOUND' : implode(" ",$paternalUncle);
                break;
            
            default: //None
                $relation = 'NONE';
                break;

            return $relation;
        
        }
    }
}
