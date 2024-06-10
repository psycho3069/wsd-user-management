## Setup The Project

0. Prerequisites: apache, php, mysql, composer, node etc are already installed and running
1. git clone https://github.com/psycho3069/wsd-user-management.git
2. cd wsd-user-management
3. composer install
4. configure .env file and properly set database values
5. php artisan migrate:fresh --seed
6. npm install
7. npm run build
8. php artisan serve (to run the project)
9. php artisan test (to run the feature tests; running this will clear the database existing values)


## Introduction

This project is built with the TDD approach with some generic and useful test cases for the user-management admin portal. The best and most popular php framework Laravel (not required for the coding challenge and at he same time not forbidden) was used for this and best practices are followed properly. The models of laravel MVC pattern by default uses the PDO object under the hood (in laravel core files) which prevents SQL Injections and XSS attacks. So, it was NOT used explicitly and intentinally. Lastly, bootstrap was used for the frontend styling instead of plain css.
