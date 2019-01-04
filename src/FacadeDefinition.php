<?php declare(strict_types=1); namespace BapCat\Facade;

use BapCat\Phi\Ioc;
use BapCat\Propifier\PropifierTrait;

use ReflectionClass;

/**
 * @property-read  string  $name
 * @property-read  string  $binding
 * @property-read  Ioc     $ioc
 */
class FacadeDefinition {
  use PropifierTrait;

  /** @var  string  $name */
  private $name;

  /** @var  string  $binding */
  private $binding;

  /** @var  Ioc  $ioc */
  private $ioc;

  /**
   * @param  string  $name
   * @param  string  $binding
   * @param  Ioc     $ioc
   */
  public function __construct(string $name, string $binding, Ioc $ioc) {
    $this->name    = $name;
    $this->binding = $binding;
    $this->ioc     = $ioc;
  }

  /**
   * @return  string
   */
  protected function getName(): string {
    return $this->name;
  }

  /**
   * @return  string
   */
  protected function getBinding(): string {
    return $this->binding;
  }

  /**
   * @return  Ioc
   */
  protected function getIoc(): Ioc {
    return $this->ioc;
  }

  /**
   * @return  array
   */
  public function toArray(): array {
    return [
      'name'    => $this->name,
      'binding' => $this->binding,
      'ioc'     => get_class($this->ioc),
      'reflect' => new ReflectionClass($this->ioc->resolve($this->binding)),
    ];
  }
}
