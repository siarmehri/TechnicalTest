# Installed 
composer create-project --prefer-dist laravel/laravel TechnicalTest
# Created Controller Factory Model for peoples
php artisan make:model -cfm People
# people table
I have decided to have one table as I know that the job_role could go to a separate table.
For this certain test which have the maximum of 10 records with a condition to not allow more than 4 records to have same job_role, 
the relationship will complicate the task and we will need to add more logic to enforce our condition.
Even though it could be done by adding counter to job_role table to show how many persons do we have in this certain role, but updating the counter would be a bit annoying. 
With this solution we can easily count our condition with a simple query.
# Seed peoples table
php artisan db:seed

# How to run the project:
1. clone it from github.
2. create a database called TechnicalTest [it is in .env.example file].
3. configure your database connection [.env file]
4. run following commands in project folder:
    - composer install
    - php artisan migrate
    - php artisan db:seed [seeding with markup form provided for this test, you should run it only once]
    - php artisan config:cache
    - php artisan route:cache [just in case it is not working fine]
5. visit [url/people] and play with it...

# Created bundle called file.bundle 
It is pushed to the root folder of the project...