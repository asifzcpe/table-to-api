# table-to-api generator
table-to-api is a laravel package that creates rest api for a certain table. It generates scaffolding for rest api.
  - It generates controller,model,request and route for a certain table to work like rest api
  
# Installing table-to-api
The recommended way to install table-to-api is through
[Composer](https://getcomposer.org/).

```bash
composer require asifzcpe/table-to-api
```
# Setting up the package in laravel project
1. Run following artisan command shipped with this package
```bash
php artisan table2api:generate YOUR_TABLE_NAME
```
if table exists in database it generates following scaffolding:

![Image of table-to-api](https://raw.githubusercontent.com/asifzcpe/table-to-api/master/docs/Screenshot%20from%202020-03-13%2000-26-21.png)

2. Inserting api namespace in composer.json file like the following:
```json
 "psr-4": {
     "App\\": "app/",
     "Api\\V1\\":"api/1/"
  },
```
3. Run following command to autoload
```bash
composer dumpautoload
```
```bash
php artisan clear:cache
php artisan clear-compiled
```
4. Run following command to see generated api routes
```bash
  php artisan route:list
```
and it will show like this (users table in my case)
![Image of route lists](https://raw.githubusercontent.com/asifzcpe/table-to-api/master/docs/Screenshot%20from%202020-03-13%2000-49-09.png)

### It is done. Now, you can hit the urls to get json data as rest api
