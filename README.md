[![Build Status](https://travis-ci.org/BapCat/Facade.svg?branch=1.0.0)](https://travis-ci.org/BapCat/Facade)
[![Coverage Status](https://coveralls.io/repos/BapCat/Facade/badge.svg?branch=1.0.0)](https://coveralls.io/r/BapCat/Facade?branch=1.0.0)
[![License](https://img.shields.io/packagist/l/BapCat/Facade.svg)](https://img.shields.io/packagist/l/BapCat/Facade.svg)

# Phi Facades

Facades are a way to make Phi bindings feel more natural.

## Installation

### Composer
[Composer](https://getcomposer.org/) is the recommended method of installation for Facade.

```
$ composer require bapcat/facade
```

### GitHub

Facade may be downloaded from [GitHub](https://github.com/BapCat/Facade/).

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

$phi = BapCat\Phi\Phi::instance();
$phi->bind('core.log', $logger);
```

```php
use BapCat\Facade\Facade;

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
$phi = BapCat\Phi\Phi::instance();
$phi->bind('phi', $phi);
```

```php
use BapCat\Facade\Facade;

class Phi extends Facade {
  protected static $_binding = 'phi';
}
```

This will allow Phi to be accessed as such:

```php
Phi::bind('Bar', 'Foo');
$foo = Phi::make('Bar');
```

### Phi Custom Resolvers
If you are using Phi 1.2.0 or greater, Phi facades will work seamlessly with custom resolvers.
