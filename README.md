# Prestavel
## Laravel package to consume prestashop webservice easily (eloquent friendly)

Prestavel is a package that helps you make your prestashop webservices call in an easy way


## Features

- Simple interface to interact with your prestashop shop easily
- Facade pattern design respected
- Service provider (laravel's best practices)
- You can use it like your eloquent models

## Last version
For this version you can get (read mode) your data from prestashop

## Example
````php
use Islemdev\Prestavel\Facades\PrestavelConnector;

PrestavelConnector::select("id", 'id_customer') //select what fields you want
        ->from("addresses") // what resource you want to query
        ->where("id_customer", 1) // where clause
        ->where("id_customer", 2)  // another where clause
        ->get() // collection
````

### Select
you can select multiple fields from resource's schema
````php
use Islemdev\Prestavel\Facades\PrestavelConnector;
 
PrestavelConnector::select("id", 'id_customer');//add whatever field you want
````

you can select all fields by passing * to params
````php
use Islemdev\Prestavel\Facades\PrestavelConnector;
 
PrestavelConnector::select("*");//add whatever field you want
````
## Installing
In your command line (in your project directory) run
````
composer require islemdev/prestavel
````

then, to publish assets and config file, run
````
php artisan vendor:publish --provider="Islemdev\Prestavel\PrestavelServiceProvider" --tag="config"
````

