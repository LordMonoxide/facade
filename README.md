[![Build Status](https://travis-ci.org/LordMonoxide/facade.svg?branch=1.0.0)](https://travis-ci.org/LordMonoxide/facade)
[![Coverage Status](https://coveralls.io/repos/LordMonoxide/facade/badge.svg?branch=1.0.0)](https://coveralls.io/r/LordMonoxide/facade?branch=1.0.0)
[![License](https://img.shields.io/packagist/l/LordMonoxide/facade.svg)](https://img.shields.io/packagist/l/LordMonoxide/facade.svg)

# Phi Facades

Facades are a way to make Phi bindings feel more natural.

## Features

### Pseudo-Static Access To Phi Singletons

A common use-case for Phi Facades is logging:

```php
namespace Vendor\Package\Logging;

class Logger {
  public function warning($text) {
    // ...
  }
}
```

```php
$logger = new Vendor\Package\Logging\Logger;

$phi = LordMonoxide\Phi\Phi::instance();
$phi->bind('core.log', $logger);
```

```php
use LordMonoxide\Facade\Facade;

class Log extends Facade {
  protected static $_binding = 'core.log';
}
```

Once the facade is set up, the `Vendor\Package\Logging` singleton can be accessed like this:

```php
Log::warning('Something bad happened!');
```

Phi Facades can even be used to create a facade for Phi:

```php
$phi = LordMonoxide\Phi\Phi::instance();
$phi->bind('phi', $phi);
```

```php
use LordMonoxide\Facade\Facade;

class Phi extends Facade {
  protected static $_binding = 'phi';
}
```

This will allow Phi to be accessed as such:

```php
Phi::bind('Bar', 'Foo');
$foo = Phi::make('Bar');
```
