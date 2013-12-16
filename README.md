SclCurrency
===========

[![Build Status](https://travis-ci.org/SCLInternet/SclCurrency.png?branch=master)](https://travis-ci.org/SCLInternet/SclCurrency)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/quality-score.png?s=f4363743635da83f8501f2c9513fb29ef057672e)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)
[![Code Coverage](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/coverage.png?s=9dc68e44337ee0d7e1aba07e020d5b9224d8450d)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)

Basic usage
-----------

```php
use SCL\Currency\Factory;
use SCL\Currency\Currency;

$factory = Factory::createDefaultInstance();

$money = $factory->create(10.99, 'GBP');
```

```php
use SCL\Currency\Factory;
use SCL\Currency\Currency;

$factory = Factory::createDefaultInstance();

$money = $factory->create(10.99, new Currency('GBP'));
```

```php
use SCL\Currency\Factory;
use SCL\Currency\Currency;

$factory = Factory::createDefaultInstance();

$factory->setDefaultCurrency(new Currency('GBP'));

$money = $factory->create(10.99);
```
