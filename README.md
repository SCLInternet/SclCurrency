SclCurrency
===========

[![Build Status](https://travis-ci.org/SCLInternet/SclCurrency.png?branch=master)](https://travis-ci.org/SCLInternet/SclCurrency)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/quality-score.png?s=f4363743635da83f8501f2c9513fb29ef057672e)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)
[![Code Coverage](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/badges/coverage.png?s=9dc68e44337ee0d7e1aba07e020d5b9224d8450d)](https://scrutinizer-ci.com/g/SCLInternet/SclCurrency/)

Money
-----------

### Factory
```php
use SCL\Currency\MoneyFactory;

$factory = MoneyFactory::createDefaultInstance();

$money = $factory->create(10.99, 'GBP');
```

```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Currency;

$factory = MoneyFactory::createDefaultInstance();

$money = $factory->create(10.99, new Currency('GBP'));
```

```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Currency;

$factory = MoneyFactory::createDefaultInstance();

$factory->setDefaultCurrency(new Currency('GBP'));

$money = $factory->create(10.99);
```

### Static Factory

```php
use SCL\Currency\MoneyFactory;

$money = MoneyFactory::staticCreate(10.99, 'GBP');
```

```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Currency;

$money = MoneyFactory::staticCreate(10.99, new Currency('GBP'));
```

```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Currency;

MoneyFactory::getStaticFactory()->setDefaultCurrency(new Currency('GBP'));

$money = MoneyFactory::staticCreate(10.99);
```

### Formatter
```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Money\Formatter;

$money = MoneyFactory::staticCreate(10.99, 'GBP');

echo Formatter::getDefaultInstance()->formatAsNumber($money);
// Result: 10.99
```
```php
use SCL\Currency\MoneyFactory;
use SCL\Currency\Money\Formatter;

$money = MoneyFactory::staticCreate(10.99, 'GBP');

echo Formatter::getDefaultInstance()->formatAsString($money);
// Result: '£ 10.99'
```
