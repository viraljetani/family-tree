<?php

namespace App\Console\Commands;

use App\Models\Person;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FamilyTree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FamilyTree:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read the text file and output the operations performed on the King Arthur Family Tree';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contents = Storage::get('inputfile.txt');
        $operations = preg_split("/[\r\n]+/", $contents);

        foreach($operations as $key => $operation)
        {
            $parameters = explode(" ",$operation);
            
            switch ($parameters[0]) {
                case 'ADD_CHILD':
                    if(count($parameters) == 4){ //do we have all 4 parameters to add a child
                         $this->info(Person::addPerson($parameters[1],$parameters[2],$parameters[3]));
                    }
                    break;

                case 'GET_RELATIONSHIP':
                    if(count($parameters) == 3){ //do we have all 3 parameters to add a child
                        $person = new Person();
                        $this->info($person->getrelationship($parameters[1],$parameters[2]));
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return Command::SUCCESS;
    }
}
