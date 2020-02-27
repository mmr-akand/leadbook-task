# Leadbook Task
 
## Running the project for the first time

To run the project you need to execute the following commands:

    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    php artisan passport:install
    npm install
    npm run dev

## Using API

Use [postman](https://www.getpostman.com/) or similar tools to send API requests. Use the API tokens as Bearer authentication tokens.

## Testing APIs
  
To execute the test cases run the following command:

    ./vendor/bin/phpunit 
 