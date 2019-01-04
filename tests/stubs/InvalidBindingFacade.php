<?php declare(strict_types=1);

use BapCat\Facade\Facade;

class InvalidBindingFacade extends Facade {
  protected static $binding = 'ThisIsAClassThatDoesNotExist';
}
