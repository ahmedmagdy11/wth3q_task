# Wtheq Task
This is a backend task provided from wtheq.com 

## Installation process

- install php 7.4
- install mysql
- git clone `git@github.com:ahmedmagdy11/wth3q_task.git`
- cd into the project directory
- go into mysql and `CREATE DATABASE wtheq`
- copy content of env.example in .env file
- in the terminal `composer install`
- migrate database tables : `php artisan migrate`
- seed the database: `php artisan db:seed --class=ProductSeeder`
- running the project: `php artisan serve`


### Notes
- Used Repository design pattern as mentioned in the task file

- Authorization and Authentication system could be done better in the User and Products module because of couse a normal user wouldn't have access to do CRUD operations on Users or Products modules other that viewing products maybe 

- The way I handled the view of the price in product could be done in multible ways

- I was focusing on writing clean code some how beside that the logic can be changed



#### Contact info

- Mail: ahmed.magdy.9611@gmail.com