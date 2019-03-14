<?php namespace Modele;

require_once "collection.php";
require_once "interfaces.php";

abstract class Item {


  public static function objects ($adapter, $options=array()) {
    $construction = function ($valeurs) {
      return new static($valeurs);
    };
    return new Collection($construction, $adapter, $options);
  }

  abstract public function getValeurs() : array;

  protected function getAdaptateur() : ItemInterface  {
    return $this->_adaptateur;
  }

  public function setAdaptateur(ItemInterface &$value) {
    return $this->_adaptateur = $value;
  }

  public function estValide() {
    return true;
  }

  public function enregistrer($doitValider=true) {
    if ($doitValider && $this->estValide()) {
      $v = $this->getValeurs();
      $m = $this->getAdaptateur();
      if ($m->getClefPrimaire($v)) {
        $m->mettreAJour($v);
      } else {
        return $m->creer($v);
      }
    }
  }

  public function effacer() {
    $m = $this->getAdaptateur();
    return $m->effacer($m->getClefPrimaire($this->getValeurs()));
  }

}
