<<?= '?php' ?>

use BapCat\Facade\Facade;

class <?= $name ?> extends Facade {
<?php foreach($binding->reflect()->getConstants() as $const => $val): ?>
  const <?= $const ?> = <?= $binding ?>::<?= $const ?>;
<?php endforeach; ?>
  
  protected static $ioc     = '<?= $ioc ?>';
  protected static $binding = '<?= $binding ?>';
<?php foreach($binding->reflect()->getMethods() as $method): ?>
<?php if($method->isPublic() && !($method->isConstructor() || $method->isDestructor())): ?>
  
  <?= $method->getDocComment() ?>
  
  public static function <?= $method->getName() ?>(...$args) {
    return self::inst()-><?= $method->getName() ?>(...$args);
  }
<?php endif; ?>
<?php endforeach; ?>
}
