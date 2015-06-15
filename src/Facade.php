<?php namespace BapCat\Facade;

use BapCat\Interfaces\Ioc\Ioc;

use InvalidArgumentException;

/**
 * Pseudo-static accessors for Phi bindings
 * 
 * All Facades must set `protected static $_binding` to a valid Phi binding.
 */
class Facade {
  private static $ioc = null;
  
  public static function setIoc(Ioc $ioc) {
    self::$ioc = $ioc;
  }
  
  /**
   * Passes arguments on to the instance gotten from Phi
   * 
   * @throws  InvalidArgumentException  If $_binding wasn't set in the subclass
   * 
   * @param   string  $name       The function to call
   * @param   array   $arguments  The arguments to pass to the binding
   * 
   * @returns mixed   The return value of the function
   */
  public static function __callStatic($name, array $arguments) {
    // Throw an exception if $_binding wasn't set in the subclass
    if(!isset(static::$_binding)) {
      throw new InvalidArgumentException(get_called_class() . ' must set "protected static $_binding".');
    }
    
    // Grab the instance and call the function
    $instance = self::$ioc->make(static::$_binding);
    return call_user_func_array([$instance, $name], $arguments);
  }
}
