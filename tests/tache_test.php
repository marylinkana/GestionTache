<?php

require_once dirname(__DIR__)."/includes/setup.php";

require_once "modeles/tache.php";
require_once "modeles/tache_pdo.php";

$DATABASE = new PDO('mysql:host=127.0.0.1;port=3307;dbname=taches_db;charset=utf8mb4', 'tasker', 'tasker');
// $DATABASE->query("delete from taches");

function exemple_de_taches() {
  return array(array("texte" => "tache 1", "termine" => 0),
               array("texte" => "tache 2", "termine" => 0),
               array("texte" => "tache 3", "termine" => 1));
}

echo "### TEST DE 'TachePdo'\n";

function tester($nom, $fonction) {
  global $DATABASE;
  $DATABASE->beginTransaction();
  try {
    echo $nom . "...";
    $fonction(Tache::objects(new TachePdo($DATABASE)));
    echo "OK\n";
  } catch (Exception $e) {
    echo "RATE\n";
  }
  $DATABASE->rollBack();
}

tester("Tache - creer", function ($taches) {
  $tache = $taches->nouveau();
  $tache->texte = "A faire ce jour";
  $tache->enregistrer();
  assert(count($taches->selectionner(array("texte" => "A faire ce jour"))) > 0);
});

tester("Tache - compter", function ($taches) {
  foreach (exemple_de_taches() as $t) {
    $taches->creer($t);
  }
  assert(count($taches->selectionner()) == 3);
});

tester("Tache - lister", function ($taches) {
  foreach (exemple_de_taches() as $t) { $taches->creer($t); }
  $i = 0;
  foreach ($taches->selectionner() as $tache) {
    assert($tache instanceof Tache);
    $i += 1;
  };
  assert($i == 3);
});

tester("Tache - trouver", function ($taches) {
  $ts = array();
  foreach (exemple_de_taches() as $t) { array_push($ts, $taches->creer($t)); }
  $id = $ts[0]->id;
  assert(($taches->trouver($id))->id == $id);
});

tester("Tache - modifier", function ($taches) {
  $ts = array();
  foreach (exemple_de_taches() as $t) { array_push($ts, $taches->creer($t)); }
  $ts[0]->texte = "Nouveau texte";
  $ts[0]->enregistrer();
  assert(($taches->trouver($ts[0]->id))->texte == "Nouveau texte");
});

tester("Tache - effacer", function ($taches) {
  $ts = array();
  foreach (exemple_de_taches() as $t) { array_push($ts, $taches->creer($t)); }
  $ts[0]->effacer();
  assert(count($taches->selectionner()) == 2);
});

//
// tester("Selectionner des taches", function () {
//
// })
