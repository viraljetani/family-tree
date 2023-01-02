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

    public function addPerson($mother, $person, $gender)
    {
        $mother = Person::where('name',$mother)->first() ?? null;
        if($mother && ($gender == 'male' || $gender == 'female'))
        {
            $child = Person::create(['name' => $person,'gender' => $gender, 'mother_id' => $mother->id]);
            return 'CHILD_ADDED';
        }
        else{
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



    
    /**
     * getRelationship
     *
     * @param  Person $person
     * @param  string $relationship
     * @return string
     */
    public function getRelationship(Person $person, $relationship)
    {
        $relation = "";

        switch ($relationship) {
            case $this->relations[0]: //son
                # code...
                break;
            
            case $this->relations[1]: //Daughter
                # code...
                break;
            
            case $this->relations[2]: //Siblings
                # code...
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
