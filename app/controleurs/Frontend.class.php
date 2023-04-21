<?php

/**
 * Classe Contrôleur des requêtes de l'application frontend
 */

class Frontend extends Routeur {

  private $id_enchere;
  private $id_usager;
  private $oUtilConn;

  private $classRetour = "fait";
  private $messageRetourAction = "";

  /**
   * Constructeur qui initialise le contexte du contrôleur  
   */  
  public function __construct() {
    $this->oUtilConn = $_SESSION['oUtilConn'] ?? null; 
    $this->id_enchere = $_GET['id_enchere'] ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }



  /**
   * Connecter un usager
   */
  public function connecter()
  {
    $usager = $this->oRequetesSQL->connecter($_POST);
    
    if ($usager !== false) {
      $_SESSION['oUtilConn'] = new Usagers($usager);
      
    }
    echo json_encode($usager);
  }

  /**
   * Déconnecter un usager
   */
  public function deconnecter()
  {
    unset($_SESSION['oUtilConn']);
    echo json_encode(true);
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
  /**
   * Afficher la page inscription
   */
  public function inscription()
  {
    
    new Vue(
      'vInscription',
      array(
        
        'titre'  => 'Inscription membre'
      ),
      'gabarit-frontend'
    );
  }
  /**
   * Inscription d'un nouveau membre
   */

  public function validationInscription()
  {

    $usager  = [];
    $erreurs = [];
    if (count($_POST) !== 0) {

      // retour de saisie du formulaire
      $usager = $_POST;
      $oUsager = new Usagers($usager); // création d'un objet usager pour contrôler la saisie
      $erreurs = $oUsager->erreurs;
      if (count($erreurs) === 0) {
        $id_usager = $this->oRequetesSQL->getInscription([
          'nom'    => $oUsager->nom,
          'prenom' => $oUsager->prenom,
          'adresse' => $oUsager->adresse,
          'codePostal' => $oUsager->codePostal,
          'ville' => $oUsager->ville,
          'pays' => $oUsager->pays,
          'telephone' => $oUsager->telephone,
          'courriel' => $oUsager->courriel,
          'mdp' => $oUsager->mdp,
          'idprofil' => $oUsager->idprofil
        ]);
        if ($id_usager > 0) {
          $this->accueil(); // retour sur la page de liste des utilisateur
          
          exit;
        }
        
      }
      new Vue(
        'vInscription',
        array(
          'titre'    => 'Ajouter un Membre',
          'usager'   => $usager,
          'erreurs'  => $erreurs
        ),
        'gabarit-frontend'
      );
    }

  }
  
}