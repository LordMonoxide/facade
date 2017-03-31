<?php
use BapCat\Facade\Facade;

class HelloFacade extends Facade {
  const HELLO = Test::HELLO;
  
  protected static $ioc     = 'BapCat\Phi\Phi';
  protected static $binding = 'Test';
  
  /**
   * @return  void
   */  
  public static function hello(...$args) {
    return self::inst()->hello(...$args);
  }
}
