<?php namespace Modele;

class Collection implements \Iterator, \ArrayAccess, \Countable {
  private $requetes;
  private $options;
  private $construire;
  private $index;
  private $items;
  private $doitRecharger = true;

  function __construct(&$construire, &$adaptateur, $options = array()) {
    $this->construire = $construire;
    $this->adaptateur = $adaptateur;
    $this->options = $options;
    $this->items = array();
    $this->index = 0;
    // $this->charger();
  }

  public function offsetExists($offset) {
    return isset($this->items[$offset]);
  }

  public function offsetGet($offset) {
    return $this->items[$offset];
  }

  public function offsetSet($offset, $value) {
    $this->items[$offset] = $value;
  }

  public function offsetUnset($offset) {
    unset($this->items[$offset]);
  }

  public function count() {
    return $this->adaptateur->compter($this->options);
  }

  private function charger() {
    $this->doitRecharger = false;
    $this->items = array();
    foreach($this->adaptateur->lister($this->options) as $valeur) {
      array_push($this->items, $this->nouveau($valeur));
    }
    $this->index = 0;
  }

  public function nouveau($valeurs=array()) {
    $c = $this->construire;
    $i = $c($valeurs);
    $i->setAdaptateur($this->adaptateur);
    return $i;
  }

  public function rewind() {
    if ($this->doitRecharger) {
      $this->charger();
    }
  }

  public function key() {
    return $this->index;
  }

  public function current() {
    return $this[$this->index];
  }

  public function next() {
    $this->doitRecharger = true;
    return ++$this->index;
  }

  public function valid() {
    return isset($this[$this->index]);
  }

  public function creer($valeurs) {
    return $this->nouveau($this->adaptateur->creer($valeurs));
  }

  public function selectionner($options=array()) {
    return new static($this->construire, $this->adaptateur, $options);
  }

  public function trouver($id) {
    return $this->nouveau($this->adaptateur->trouver($id));
  }
}
