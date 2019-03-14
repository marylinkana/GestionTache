<?php

require "base/modele.php";

class Tache extends \Modele\Item {
  public $id;
  public $dateDebut;
  public $texte;
  public $termine;

  function __construct($v=array()) {
    foreach($v as $k => $v) {
      $this->$k = $v;
    }
  }

  public function getValeurs() : array {
    return array("id" => $this->id, "termine" => $this->termine, "texte" => $this->texte);
  }
}
