<?php

require_once "modeles/tache.php";
require_once "modeles/tache_pdo.php";

class TachesControleur {
  public function __construct (&$contexte) {
    $this->taches = Tache::objects(new TachePdo($contexte["database"]));
  }

  public function executerAction ($action, $parametres) {
    switch ($action) {
      case 'effacer':
        $tache = $this->taches->trouver($parametres["id"]);
        if ($tache) {
          $tache->effacer();
        }
        header("Location: index.php?controlleur=taches&action=lister");
        exit;     
      case 'modifier':
        $tache = $this->taches->trouver($parametres["id"]);
        if ($tache) {
            if (isset($parametres["termine"])) {
                if($tache->termine == "termine"){
                    $tache->termine = "enAttente" ;
                }
                else{
                    $tache->termine = "termine" ;
                }
            $tache->enregistrer();
            }
            else{
                if (!empty(trim($parametres["texte"]))) {
                      $tache->texte = $parametres["texte"];
                      $tache->enregistrer();
                }
                else{
                    if (!empty(trim($parametres["dateDebut"]))) {
                      $tache->texte = $parametres["dateDebut"];
                      $tache->enregistrer();
                    }
                    else{
                        $taches->effacer();
                    }
                }
            }
        }
        header("Location: index.php?controlleur=taches&action=lister");
        exit;
      case 'ajouter':
        if (isset($parametres["texte"]) && !empty(trim($parametres["texte"])) && isset($parametres["date"]) &&  !empty(trim($parametres["date"]))) {
          $this->taches->creer(array(
            "texte" => $parametres["texte"],
            "dateDeFin" => $parametres["date"]
          ));
        }
        header("Location: index.php?controlleur=taches&action=lister");
        exit;
      case 'lister':
      default:
        $conditions = array();
        if(isset($parametres["texte"])){
          $conditions['texte'] = $parametres["texte"];
        }
        if(isset($parametres["termine"])){
          $conditions['termine'] = $parametres["termine"];
        }
        $taches = $this->taches->selectionner($conditions);
        require "gabarits/taches/index.php";
        exit;
    }
  }
}

?>
