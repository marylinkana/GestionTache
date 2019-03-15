<?php

require_once "base/modele/interfaces.php";

class TachePDO implements \Modele\CollectionInterface, \Modele\ItemInterface {
  function __construct(&$bdd) {
    $this->bdd = $bdd;
  }

  public function compter($conditions=array()) {
    $res = $this->lister($conditions, "count(*) as compteur");
    return $res[0]["compteur"];
  }

  public function lister($conditions=array(), $selection="*") {
    $requete = "SELECT $selection FROM taches ";
    $parametres = array();
    $where = array();
    if (isset($conditions['termine'])) {
      array_push($where, "termine=?");
      array_push($parametres, $conditions['termine']);
    }
    if (isset($conditions['id'])) {
      array_push($where, "id=?");
      array_push($parametres, $conditions["id"]);
    }
    if (isset($conditions['texte'])) {
      array_push($where, "texte=?");
      array_push($parametres, $conditions["texte"]);
    }
    if (count($where) > 0) {
      $requete .= "WHERE ".implode(" AND ", $where);
    }
    $requete .= " ORDER BY id DESC;";
    $stmt = $this->bdd->prepare($requete);
    $stmt->execute($parametres);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  function creer($valeurs) {
    $champs = array();
    $sqlval = array();
    $parametres = array();
    $sqlDefaut = array("dateDebut" => "NOW()");
    foreach(array("texte","dateDebut" , "dateDeFin" , "termine") as $champ) {
      if (isset($valeurs[$champ])) {
        array_push($champs,$champ);
        array_push($sqlval, "?");
        array_push($parametres, $valeurs[$champ]);
      } else {
        if (isset($sqlDefaut[$champ])) {
          array_push($champs, $champ);
          array_push($sqlval, $sqlDefaut[$champ]);
        }
      }
    }
    $stmt = $this->bdd->prepare("INSERT INTO taches(".implode(",",$champs).") VALUES (".implode(",", $sqlval).");");
    $stmt->execute($parametres);
    $valeurs["id"] = $this->bdd->lastInsertId();
  }

  function mettreAJour($valeurs) {
    $champs = array();
    $parametres = array();
    foreach(array("texte","dateDebut" , "dateDeFin" , "termine") as $champ) {
      if (isset($valeurs[$champ])) {
        array_push($champs,"$champ=?");
        array_push($parametres, $valeurs[$champ]);
      }
    }
    array_push($parametres, $valeurs["id"]);
    $stmt = $this->bdd->prepare("UPDATE taches SET ".implode(", ",$champs)." WHERE id=?;");
    $stmt->execute($parametres);
  }

  function effacer($id) {
    $stmt = $this->bdd->prepare("DELETE FROM taches WHERE id=:id OR termine=:id;");
    $stmt->execute(array("id" => $id));
  }

  function trouver($id) {
    $stmt = $this->bdd->prepare("SELECT * FROM taches WHERE id=:id LIMIT 1;");
    $stmt->execute(array("id" => $id));
    $valeurs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return isset($valeurs[0]) ? $valeurs[0] : null;
  }


  function getClefPrimaire($valeurs) {
    return $valeurs["id"];
  }
}
