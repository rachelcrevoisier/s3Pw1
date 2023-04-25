<?php

/**
 * Classe Contrôleur des requêtes de l'application frontend
 */

class Frontend extends Routeur
{

  private $id_enchere;
  private $oUtilConn;

  private $classRetour = "fait";
  private $messageRetourAction = "";

  /**
   * Constructeur qui initialise le contexte du contrôleur  
   */
  public function __construct()
  {
    $this->oUtilConn = $_SESSION['oUtilConn'] ?? null;
    $this->id_enchere = $_GET['id_enchere'] ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }


  /**
   * Afficher la page d'accueil
   */
  public function Accueil()
  {
    $encheresEncours = $this->oRequetesSQL->getEncheres($critere = 'encours');
    $encheresNouvelles = $this->oRequetesSQL->getEncheres($critere = 'nouvelles');
    $encheresImminentes = $this->oRequetesSQL->getEncheres($critere = 'imminentes');
    $encheresCertifiees = $this->oRequetesSQL->getEncheres($critere = 'certifie');
    new Vue(
      'vAccueil',
      array(
        'oUtilConn' => $this->oUtilConn,
        'titre'  => 'Accueil',
        'encheresNouvelles' => $encheresNouvelles,
        'encheresImminentes' => $encheresImminentes,
        'encheresCertifiees' => $encheresCertifiees,
        'encheresEncours' => $encheresEncours
      ),
      'gabarit-frontend'
    );
  }
  
}
