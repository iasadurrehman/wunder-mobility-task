# Wunder Mobility Task

Hello, this is the task submitted for Wunder Mobility. It's built on Laravel with Laravel Mix on VueJS. 

## Features
- Basic required validation used for input fields and checked in VueJS
- Cookies set using debounce library on input change, so the form status can be saved every 0.5 second after input change, with this, we can achieve saving the form status whenever user leaves registration
- Upon submission, the cookie is removed
- Using JS was the requirement so I used VueJS to kepe the task minimal and easy.
- Instead of serving everything on serverside, I used Clientside and serverside both.
- I've created migration as well as included SQL dump database table

## Possible performance Optimization

- Instead of retrieval of payment_history object again after API call to update the payment Id in transaction, we can use collection which is already there in code after insertion of object at first before API call.
- We can also insert customer object only in database, perform the call to API and upon retrieval of the customerPaymentId, we can insert the all data together in customer_payment table.

## Things could be done better than what I did
- Serverside validation as well after clientside validations
- Avoiding replication of customers with some unique identifier(i.e. Email etc) [depends on business requirement]
- Indexing on table for fast retrieval
- Input validation using $watch method in Vue instead of validation on last page
- Make seeder for dummy data
- Exception and error handling
- Can do everything in PHP as well, but to improve user experience I used VueJs, otherwise page navigation can also be handled with query params and cookies will be saved, this was the other way around. But again it depends on the requirements and the task is done using minimal easier possible technique. 

## Installation
Clone repository
Configure .env file with
```
APP_NAME="Wunder Mobility Task"
APP_ENV=local
APP_KEY=base64:2zkErNC2RLO54bl2vYpILRmEESoADfziDfpVmqPRCBo=
APP_DEBUG=true
APP_URL=http://localhost
API_URL=https://37f32cl571.execute-api.eu-central-1.amazonaws.com
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wunder_test
DB_USERNAME=admin
DB_PASSWORD=password

```
Generate app key

Install the dependencies before starting the server.
Run:
```sh
composer install
npm install && npm run dev
```
after that run the following command to migrate DB tables or import sql dumb provided in repo task_dump.sql

```
php artisan migrate
```

Make virtual host or run

```
php artisan serve
```

In short time and some issues, this is done and requirements are being sufficed, there could be more things which could be done. I'm hoping to see a detailed and positive response :)
