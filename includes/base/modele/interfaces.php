<?php namespace Modele;


interface CollectionInterface {
  /**
   * Retourne la valeur de la clef primaire pour une valeur
   */
  public function getClefPrimaire($valeurs);

  /**
   * Liste des enregistrements
   *
   * @param array $conditions Tableau associatif des conditions
   * @return array Enregistrements comme tableau associatif
   */
  public function lister($options);

  /**
   * Trouve un enregistrement
   *
   * @param mixed $id L'identifiant de l'enregistrement à trouver
   * @return void
   */
  public function trouver($id);

}

interface ItemInterface {
  /**
   * Retourne la valeur de la clef primaire pour une valeur
   */
  public function getClefPrimaire($valeurs);

  /**
   * Met à jour un enregistrement
   *
   * @param array $valeurs Tableau associatif champ -> valeur
   * @return void
   */
  public function mettreAJour($valeurs);

  /**
   * Crée un enregistrement
   *
   * @param array $valeurs Tableau associatif champ -> valeur
   * @return void
   */
  public function creer($valeurs);

  /**
   * Efface un enregistrement
   *
   * @param mixed $id L'identifiant de l'enregistrement à effacer
   * @return void
   */
  public function effacer($id);

}
