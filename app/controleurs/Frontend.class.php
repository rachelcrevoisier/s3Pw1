<?php

/**
 * Classe Contrôleur des requêtes de l'application frontend
 */

class Frontend extends Routeur
{

  private $id_enchere;
  private $id_usager;
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
    $this->id_usager = $_GET['id_usager'] ?? null;
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
  /**
   * Voir les informations d'un membre
   */
  public function voirUsager()
  {
    $usager = false;
    if (!is_null($this->id_usager)) {
      $usager = $this->oRequetesSQL->getUsager($this->id_usager);
      $encheresUsager = $this->oRequetesSQL->getEncheresUsager($this->id_usager);
      //$encheres = $this->oRequetesSQL->getEnchereUsager($this->id_usager);
      //$mise = $this->oRequetesSQL->getMiseUsager($this->id_usager);

      if (!$usager) throw new Exception("Ce membre n'existe pas");

      new Vue(
        'vUsager',
        array(
          'oUtilConn' => $this->oUtilConn,
          'titre' => 'Fiche d\'un membre',
          'usager' => $usager,
          'encheresUsager' => $encheresUsager,
          //'mise' => $mise,
        ),
        'gabarit-frontend'
      );
    }
  }
  /**
   * Ajouter une enchere
   */
  public function ajouterEnchere()
  {
    



    $timbre  = [];
    $enchere  = [];
    $lien = "";
    $erreursTimbre = [];
    $erreursEnchere = [];
    if (count($_POST) !== 0) {
      $enchere = [
        'dateDebut'  => $_POST['dateDebut'],
        'dateFin'    => $_POST['dateFin'],
        'tarifBase'  => $_POST['tarifBase'],
        'idusager'   => $_POST['idusager'],
        'choixLord'  => $_POST['choixLord']
      ];
      $timbre = [
        'pays'       => $_POST['pays'],
        'certifie'   => $_POST['certifie'],
        'annee'      => $_POST['annee'],
        'couleur'    => $_POST['couleur'],
        'tirage'     => $_POST['tirage'],
        'dimensions' => $_POST['dimensions'],
        'histoire'   => $_POST['histoire'],
        'idcondition' => $_POST['idcondition'],
        'typeVisuel' => $_POST['typeVisuel'],
        'fichierVisuel' => $_FILES['fichierVisuel']['tmp_name']
      ];
      
      // retour de saisie du formulaire

      $oEnchere = new Encheres($enchere); // création d'un objet enchere
      $oTimbre = new Timbres($timbre); // création d'un objet timbre
      $erreursEnchere = $oEnchere->erreurs;
      $erreursTimbre = $oTimbre->erreurs;
      //var_dump($erreursTimbre);
      //var_dump($timbre);
      //var_dump($erreursEnchere);
      if (count($erreursEnchere) === 0 && count($erreursTimbre) === 0) {
        $id_enchere = $this->oRequetesSQL->getAjouterEnchere([
          'dateDebut'  => $oEnchere->dateDebut,
          'dateFin'    => $oEnchere->dateFin,
          'tarifBase'  => $oEnchere->tarifBase,
          'idusager'   => $oEnchere->idusager,
          'choixLord'  => $oEnchere->choixLord
        ]);
        $id_enchere=(int)$id_enchere;
          if ( $id_enchere) {
            $id_timbre = $this->oRequetesSQL->getAjouterTimbre([
              'nom'        => $oTimbre->pays . '#10' . $id_enchere . ' ' .$oTimbre->idcondition . ' $' . $oEnchere->tarifBase,
              'pays'       => $oTimbre->pays,
              'certifie'   => $oTimbre->certifie,
              'annee'      => $oTimbre->annee,
              'couleur'    => $oTimbre->couleur,
              'tirage'     => $oTimbre->tirage,
              'dimensions' => $oTimbre->dimensions,
              'histoire'   => $oTimbre->histoire,
              'idcondition' => $oTimbre->idcondition,
              'idenchere'  => $id_enchere
            ]);
            $id_timbre = (int)$id_timbre;
          }
          if ($id_timbre){
            $id_image = $this->oRequetesSQL->getAjouterVisuel([
                'lien'        => $oTimbre->fichierVisuel,
                'typeVisuel'  => $oTimbre->typeVisuel,
                'idtimbre'    => $id_timbre
              ]);
          }

      $this->Accueil(); // retour sur la page du profil
      exit;
      }
    }
    
    new Vue(
      'vAjoutEnchere',
      array(
        'oUtilConn'       => $this->oUtilConn,
        'titre'           => 'Ajouter une enchère',
        'enchere    '     => $enchere,
        'timbre    '      => $timbre,
        'erreursEnchere'  => $erreursEnchere,
        'erreursTimbre'   => $erreursTimbre
      ),
      'gabarit-frontend'
    );
  }
}
