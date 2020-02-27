# Leadbook Task
 
## Running the project for the first time

To run the project you need to execute the following commands:

    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan passport:install
    npm install
    npm run dev

Before run migration please provide correct database credentials in .env file. You can use the following credentials to login:

    Email: user@test.com
    Password: 123456

## Using API

Use [postman](https://www.getpostman.com/) or similar tools to send API requests. Use the API tokens as Bearer authentication tokens.

## Testing APIs
  
To execute the test cases run the following command:

    ./vendor/bin/phpunit 
 