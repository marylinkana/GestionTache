<?php

require_once dirname(__DIR__)."/includes/setup.php";

// $DATABASE->query("delete from taches");
require_once "modeles/tache_pdo.php";

$DATABASE = new PDO('mysql:host=127.0.0.1;port=3307;dbname=taches_db;charset=utf8mb4', 'tasker', 'tasker');

function exemple_de_taches() {
  return array(array("texte" => "tache 1", "termine" => 0),
               array("texte" => "tache 2", "termine" => 0),
               array("texte" => "tache 3", "termine" => 1));
}

echo "### TEST DE 'TachePdo'\n";

// fonction de teste
function tester($nom, $fonction) {
  global $DATABASE;
  $DATABASE->beginTransaction();
  try {
    echo $nom . "...";
    $fonction(new TachePdo($DATABASE));
    echo "OK\n";
  } catch (Exception $e) {
    echo "RATÉ\n";
    $DATABASE->rollBack();
    exit;
  }
  $DATABASE->rollBack();
}

tester("TachePdo - creer", function ($modele) {
  $item = array("texte" => "A faire ce jour");
  $modele->creer($item);
  assert(count($modele->lister(array("texte" => "A faire ce jour"))) > 0);
});

tester("TachePdo - compter", function ($modele) {
  foreach (exemple_de_taches() as $t) {
    $modele->creer($t);
  }
  assert($modele->compter() == 3);
});

tester("TachePdo - lister", function ($modele) {
  $exemples = exemple_de_taches();
  foreach (array_reverse($exemples) as $t) { $modele->creer($t); }
  $i = 0;
  foreach ($modele->lister() as $tache) {
    assert($exemples[$i]["texte"] == $tache["texte"]);
    $i += 1;
  };
});

tester("TachePdo - trouver", function ($modele) {
  foreach (exemple_de_taches() as $t) { $modele->creer($t); }
  $tache0 = $modele->lister()[0];
  assert($modele->trouver($tache0["id"])["id"] == $tache0["id"]);
});

tester("TachePdo - modifier", function ($modele) {
  foreach (exemple_de_taches() as $t) { $modele->creer($t); }
  $tache0 = $modele->lister()[0];
  $tache0["texte"] = "Nouveau texte";
  $modele->mettreAJour($tache0);
  assert($modele->trouver($tache0["id"])["texte"] == "Nouveau texte");
});

tester("TachePdo - effacer", function ($modele) {
  foreach (exemple_de_taches() as $t) { $modele->creer($t); }
  $tache0 = $modele->lister()[0];
  $modele->effacer($tache0["id"]);
  assert($modele->compter() == 2);
});

//
// tester("Selectionner des taches", function () {
//
// })
