<?php namespace BapCat\Facade;

use BapCat\Hashing\Hasher;
use BapCat\Interfaces\Ioc\Ioc;
use BapCat\Persist\File;
use BapCat\Tailor\HashGenerationStrategy;

use ReflectionClass;

class FacadeHashGenerator implements HashGenerationStrategy {
  private $ioc;
  private $hasher;
  
  public function __construct(Ioc $ioc, Hasher $hasher) {
    $this->ioc    = $ioc;
    $this->hasher = $hasher;
  }
  
  public function generateHash(File $template, array $params) {
    return $this->hasher->make($template->path . json_encode($params) . $template->modified . filemtime($params['reflect']->getFileName()));
  }
}
