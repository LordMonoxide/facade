<?php

use BapCat\Facade\Facade;

class InvalidBindingFacade extends Facade {
  protected static $binding = 'ThisIsAClassThatDoesNotExist';
}
