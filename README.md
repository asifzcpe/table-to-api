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
![Image of Yaktocat](https://raw.githubusercontent.com/asifzcpe/table-to-api/master/docs/Screenshot%20from%202020-03-13%2000-26-21.png)
2. Inserting api namespace in composer.json file like the following:
```json
 "psr-4": {
     "App\\": "app/",
     "Api\\V1\\":"api/1/"
  },
```
