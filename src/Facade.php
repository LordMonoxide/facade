<?php declare(strict_types=1); namespace BapCat\Facade;

use BapCat\Phi\Phi;

use InvalidArgumentException;
use ReflectionException;

abstract class Facade {
  /** @var string $ioc */
  protected static $ioc = Phi::class;

  /** @var string $binding */
  protected static $binding;

  protected static function inst() {
    // Throw an exception if $binding wasn't set in the subclass
    if(!isset(static::$binding)) {
      throw new InvalidArgumentException(static::class . ' must set "protected static $binding".');
    }

    try {
      return static::$ioc::instance()->make(static::$binding);
    } catch(ReflectionException $e) {
      throw new InvalidArgumentException(static::class . " has an invalid binding: {$e->getMessage()}", 0, $e);
    }
  }

  /**
   * Passes arguments on to the instance gotten from IoC
   *
   * @throws  InvalidArgumentException  If $binding wasn't set in the subclass
   *
   * @param  string  $name       The function to call
   * @param  array   $arguments  The arguments to pass to the binding
   *
   * @return  mixed  The return value of the function
   */
  public static function __callStatic(string $name, array $arguments) {
    return static::inst()->$name(...$arguments);
  }
}
