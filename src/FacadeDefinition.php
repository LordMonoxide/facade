<?php namespace BapCat\Facade;

use BapCat\Interfaces\Ioc\Ioc;
use BapCat\Propifier\PropifierTrait;

use ReflectionClass;

class FacadeDefinition {
  use PropifierTrait;
  
  /**
   * @var  string  $name
   */
  private $name;
  
  /**
   * @var  string  $binding
   */
  private $binding;
  
  /**
   * @var  Ioc  $ioc
   */
  private $ioc;
  
  /**
   * @param  string  $name
   * @param  string  $binding
   * @param  Ioc     $ioc
   */
  public function __construct($name, $binding, Ioc $ioc) {
    $this->name    = $name;
    $this->binding = $binding;
    $this->ioc     = $ioc;
  }
  
  /**
   * @return  string
   */
  protected function getName() {
    return $this->name;
  }
  
  /**
   * @return  string
   */
  protected function getBinding() {
    return $this->binding;
  }
  
  /**
   * @return  string
   */
  protected function getIoc() {
    return $this->ioc;
  }
  
  /**
   * @return  array
   */
  public function toArray() {
    return [
      'name'    => $this->name,
      'binding' => $this->binding,
      'ioc'     => get_class($this->ioc),
      'reflect' => new ReflectionClass($this->ioc->resolve($this->binding)),
    ];
  }
}
