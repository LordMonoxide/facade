<?php

require_once __DIR__ . '/stubs/BadFacade.php';
require_once __DIR__ . '/stubs/Foo.php';
require_once __DIR__ . '/stubs/FooFacade.php';

use BapCat\Facade\Facade;
use BapCat\Phi\Phi;

class FacadeTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    Facade::setIoc(Phi::instance());
  }
  
  public function testFacade() {
    $this->assertEquals('bar', FooFacade::getBar());
    $this->assertEquals('bar', FooFacade::returnThisVar('bar'));
  }
  
  public function testBadFacade() {
    $this->setExpectedException('InvalidArgumentException');
    $bar = BadFacade::test();
  }
}
