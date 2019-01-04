<?php namespace BapCat\Facade;

use BapCat\Hashing\Hash;
use BapCat\Hashing\Hasher;
use BapCat\Persist\File;
use BapCat\Tailor\HashGenerationStrategy;

class FacadeHashGenerator implements HashGenerationStrategy {
  private $hasher;

  public function __construct(Hasher $hasher) {
    $this->hasher = $hasher;
  }

  public function generateHash(File $template, array $params): Hash {
    return $this->hasher->make($template->path . json_encode($params) . $template->modified . filemtime($params['reflect']->getFileName()));
  }
}
