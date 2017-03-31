<?php

class Foo {
  public function getBar() {
    return 'bar';
  }
  
  public function returnThisVar($var) {
    return $var;
  }
  
  public function returnThis() {
    return $this;
  }
}
