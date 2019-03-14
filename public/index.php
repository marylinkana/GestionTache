<?php

require_once dirname(__DIR__)."/includes/setup.php";

$DATABASE = new PDO('mysql:host=127.0.0.1;port=3306;dbname=taches_db;charset=utf8mb4', 'root', '');
$DATABASE->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$context = array("database" => $DATABASE, "datadir" =>  getenv('DATADIR') ? getenv('DATADIR') : $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "data");

$nomControleur = isset($_GET['controleur']) ? $_GET['controleur'] : 'taches';
$nomAction = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($nomControleur) {
  case 'taches':
    require_once "controleurs/taches_controleur.php";
    $controleur = new TachesControleur($context);
    break;
  default:
    header("HTTP/1.0 404 Not Found");
    exit;
}

$controleur->executerAction($nomAction, $_REQUEST);

?>
