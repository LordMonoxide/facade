<?php namespace BapCat\Facade;

use BapCat\Propifier\PropifierTrait;

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
   * @var  string  $ioc
   */
  private $ioc;
  
  /**
   * @param  string  $name
   * @param  string  $binding
   * @param  string  $ioc
   */
  public function __construct($name, $binding, $ioc) {
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
   * @return  array<string, string>
   */
  public function toArray() {
    return [
      'name'    => $this->name,
      'binding' => $this->binding,
      'ioc'     => $this->ioc,
    ];
  }
}
