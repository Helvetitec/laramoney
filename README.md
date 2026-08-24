# laramoney
 MoneyPHP implementation for Laravel

## Installation
Install from composer:
```ps
composer require helvetitec/laramoney
```

## Usage
1) Use LaraMoneyCast to cast values to a json field like ['amount' => 100, 'currency' => 'brl']
2) Use LaraMoneySimpleCast to cast values directly to an integer field with an optional 'currency' field inside the model.
3) Use Money facade for anything else

### LaraMoneyCast
It's easy to store and receive data from the database with the LaraMoneyCast.
The value can either be NULL, an array of ['amount', 'currency'], a numeric value or a \Money\Money object.
**The database field needs to be a JSON (compatible) field.**

Add to the Models cast:
```php
protected $casts = [
    'price' => LaraMoneyCast::class
];
```

### LaraMoneySimpleCast
The simple cast will store the value as a string, not as a JSON object for easier sorting etc.
The value can either be NULL, an array of ['amount', 'currency'], a numeric value or a \Money\Money object.
**The database field for price and currency needs to be a string.**

Add to the Models cast:
```php

protected $fillable = [
    'price',
    'currency' //This is the default field, but can be changed inside the config field 'model_currency_field'.
];

protected $casts = [
    'price' => LaraMoneySimpleCast::class, //Will automatically set the 'currency' field as well
];
```