<?php declare(strict_types=1);

class Foo {
  public function getBar(): string {
    return 'bar';
  }

  public function returnThisVar($var) {
    return $var;
  }

  public function returnThis(): self {
    return $this;
  }
}
