<?php namespace BapCat\Facade;

use BapCat\Propifier\PropifierTrait;
use BapCat\Values\ClassName;
use BapCat\Values\Text;

class FacadeDefinition {
  use PropifierTrait;
  
  /**
   * @var  string  $name
   */
  private $name;
  
  /**
   * @var  ClassName  $binding
   */
  private $binding;
  
  /**
   * @var  string  $ioc
   */
  private $ioc;
  
  /**
   * @param  string     $name
   * @param  ClassName  $binding
   * @param  string     $ioc
   */
  public function __construct($name, ClassName $binding, $ioc) {
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
   * @return  ClassName
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
