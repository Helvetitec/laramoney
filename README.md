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
