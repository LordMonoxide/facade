<?php namespace BapCat\Facade;

use BapCat\Phi\Phi;

abstract class Facade {
  protected static $ioc = Phi::class;
  
  private static $inst;
  
  protected static function inst() {
    // Throw an exception if $binding wasn't set in the subclass
    if(!isset(static::$binding)) {
      throw new InvalidArgumentException(get_called_class() . ' must set "protected static $binding".');
    }
    
    self::$inst = self::$inst ?: (static::$ioc)::instance()->make(static::$binding);
    return self::$inst;
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
  public static function __callStatic($name, array $arguments) {
    return static::inst()->$name(...$arguments);
  }
}
