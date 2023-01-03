
## Installation

I have used Laravel Sail (Docker) while working on this code. Coding has been done with TDD of the methods implemented for adding person or spouse. 

###Setup (for Mac or Windows):

- Clone the repo in your local.
- Paste the .env file from the email into the project's root directory.
- On the Terminal inside the project directory run the following: 
> sail up -d  [Make sure docker is installed and running]

###Seeding

Family tree data of King Arthur & Queen Margret has been added to a seed file (FamilyTreeSeeder) which will be used to initialize the basic family tree to work with.

> sail artisan migrate --seed


This will install and boot up all necessary packages to run the application along with the PHPUnit Test Suit.

## Testing

Unit tests have been implement to test the critical functions of the Person class. To run the test suit simply execute the below command:

> sail test

Database for Tests is called 'testing' where all the test operations are executed and its separate from the apps main database which is named as family_tree. (All automatically setup when running the *sail up -d* command)

# Coverage
> sail test --coverage  (xDebug is already enabled in .env for this feature to work)

Current code coverage for the test suit is *40.5%* (ideally ~75-80%)