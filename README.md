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
#1 Inserting api namespace in composer.json file like the following:
```json
 "psr-4": {
     "App\\": "app/",
     "Api\\V1\\":"api/1/"
  },
```
