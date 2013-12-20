SclCurrency
===========

[![Build Status](https://travis-ci.org/SCLInternet/SclCurrency.png?branch=master)](https://travis-ci.org/SCLInternet/SclCurrency)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/quality-score.png?s=f4363743635da83f8501f2c9513fb29ef057672e)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)
[![Code Coverage](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/coverage.png?s=9dc68e44337ee0d7e1aba07e020d5b9224d8450d)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)

Installation
------------

Currency
--------

Money
-----

TaxedPrice
----------

Comparison
----------

Calculations
------------

Factories
---------

### CurrencyFactory

```php
use SCL\Currency\CurrencyFactory;

$factory = CurrencyFactory::createDefaultInstance();

$sterling = $factory->create('GBP');
```

### MoneyFactory

```php
use SCL\Currency\CurrencyFactory;
use SCL\Currency\MoneyFactory;

$factory = MoneyFactory::createDefaultInstance();

$factory->setDefaultCurrency(CurrencyFactory::createDefaultInstance()->create('GBP'));

$money = $factory->createFromValue(1.00);
```
