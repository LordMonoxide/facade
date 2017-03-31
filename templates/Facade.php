@php

use BapCat\Facade\Facade;

class {! $name !} extends Facade {
@each($binding->reflect()->getConstants() as $const, $val)
  const {! $const !} = {! $binding !}::{! $const !};
@endeach
  
  protected static $ioc     = '{! $ioc !}';
  protected static $binding = '{! $binding !}';
@each($binding->reflect()->getMethods() as $method)
@if($method->isPublic() && !($method->isConstructor() || $method->isDestructor()))
  
  {! $method->getDocComment() !}
  
  public static function {! $method->getName() !}(...$args) {
    return self::inst()->{! $method->getName() !}(...$args);
  }
@endif
@endeach
}
