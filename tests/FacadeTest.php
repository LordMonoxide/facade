<?php

require_once __DIR__ . '/stubs/BadFacade.php';
require_once __DIR__ . '/stubs/Foo.php';
require_once __DIR__ . '/stubs/FooFacade.php';

use BapCat\Facade\Facade;

class FacadeTest extends PHPUnit_Framework_TestCase {
  public function testCallingFacadeMethods() {
    $this->assertEquals('bar', FooFacade::getBar());
    $this->assertEquals('bar', FooFacade::returnThisVar('bar'));
  }
  
  /**
   * @dataProvider       badBindingsProvider
   * @expectedException  InvalidArgumentException
   */
  public function testBadBindings($class) {
    require_once __DIR__ . "/stubs/$class.php";
    
    $class::test();
  }
  
  public function badBindingsProvider() {
    return [
      [BadFacade::class],
      [InvalidBindingFacade::class],
    ];
  }
  
  /**
   * @requires PHP 7
   * @expectedException Error
   */
  public function testCallingMethodThatDoesntExist() {
    FooFacade::thisMethodDoesntExist();
  }
  
  public function testThatInstanceIsNotCached() {
    $this->assertNotSame(FooFacade::returnThis(), FooFacade::returnThis());
  }
}
