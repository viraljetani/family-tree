<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'spouse'
    ];
    /* Person
    id, name, gender, parent_id, spouse
    */

    private $relations = [
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
        
        }
    }
}
