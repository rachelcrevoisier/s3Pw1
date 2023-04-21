<?php

/**
 * Classe Contrôleur des requêtes de l'application admin
 */

class Admin extends Routeur
{

    private $entite;
    private $action;
    //private $timbre_id;
    //private $enchere_id;
    private $id_usager;

    private $oUtilConn;

    private $methodes = [
        /* 'timbre' => [
            'l' => ['nom' =>  'listerTimbres'],
            'a' => ['nom' =>  'ajouterTimbre'],
            'm' => ['nom' =>  'modifierTimbre'],
            's' => ['nom' =>  'supprimerTimbre']
        ],
        'enchere' => [
            'l' => ['nom' =>  'listerEncheres'],
            'a' => ['nom' =>  'ajouterEnchere'],
            'm' => ['nom' =>  'modifierEnchere'],
            's' => ['nom' =>  'supprimerEnchere']
        ], */
        'usager' => [
            'l' => ['nom' =>  'listerUsagers'],
            'a' => ['nom' =>  'ajouterUsager'],
            'm' => ['nom' =>  'modifierUsager'],
            's' => ['nom' =>  'supprimerUsager'],
            'd' => ['nom' =>  'deconnecter']
        ]
    ];

  private $classRetour = "fait";
  private $messageRetourAction = "";

  /**
   * Constructeur qui initialise le contexte du contrôleur  
   */
  public function __construct()
  {
    $this->entite   = $_GET['entite']   ?? 'usager';
    $this->action   = $_GET['action']   ?? 'l';
    //$this->timbre_id  = $_GET['timbre_id']  ?? null;
    //$this->enchere_id  = $_GET['enchere_id']  ?? null;
    $this->id_usager  = $_GET['id_usager']  ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }

  /**
   * Gérer l'interface d'administration 
   */
  public function gererAdmin()
  {
    
    if (isset($_SESSION['oUtilConn'])) {
      
      $this->oUtilConn = $_SESSION['oUtilConn'];
      if (isset($this->methodes[$this->entite])) {
        if (isset($this->methodes[$this->entite][$this->action])) {
          $methode = $this->methodes[$this->entite][$this->action]['nom'];
          $this->$methode();
        } else {
          throw new Exception("L'action $this->action de l'entité $this->entite n'existe pas.");
        }
      } else {
        throw new Exception("L'entité $this->entite n'existe pas.");
      }
    } else {
      $this->connecter();
    }
  }

  /**
   * Connecter un Usager
   */
  public function connecter()
  {
    
    $messageErreurConnexion = "";
    if (count($_POST) !== 0) {
      
      $usager = $this->oRequetesSQL->connecter($_POST);
      if ($usager !== false) {
        $_SESSION['oUtilConn'] = new Usagers($usager);
        $this->oUtilConn = $_SESSION['oUtilConn'];
        $this->gererAdmin();
        exit;
      } else {
        $messageErreurConnexion = "Courriel ou mot de passe incorrect.";
      }
    }
    new Vue(
        'modaleConnexion',
        array(
          'titre'                  => 'Connexion',
          'actionUri'              => 'admin',
          'messageErreurConnexion' => $messageErreurConnexion
        ),
        'gabarit-admin-min'
      );
  }

  /**
   * Déconnecter un Usager
   */
  public function deconnecter()
  {
    unset($_SESSION['oUtilConn']);
    $this->connecter();
  }

    /**
     * Lister les encheres
     */
    /* public function listerEncheres()
    {
        $encheres = $this->oRequetesSQL->getEncheres();

        new Vue(
            'vAccueil',
            array(
                'oUtilConn'           => $this->oUtilConn,
                'titre'               => 'Accueil',
                'encheres'            => $encheres,
                'classRetour'         => $this->classRetour,
                'messageRetourAction' => $this->messageRetourAction
            ),
            'gabarit-frontend'
        );
    } */


    /**
     * Lister les Usagers
     */
    public function listerUsagers()
    {
        if ($this->oUtilConn->idprofil !== Usagers::PROFIL_ADMINISTRATEUR)
            throw new Exception(self::ERROR_FORBIDDEN);

        $usagers = $this->oRequetesSQL->getlisterUsagers();

        new Vue(
            'vAdminUsagers',
            array(
                'oUtilConn'           => $this->oUtilConn,
                'titre'               => 'Gestion des Usagers',
                'Usagers'             => $usagers,
                'classRetour'         => $this->classRetour,
                'messageRetourAction' => $this->messageRetourAction
            ),
            'gabarit-admin'
        );
    }

    /**
     * Ajouter un Usager
     */
    public function ajouterUsager()
    {
        $usager  = [];
        $erreurs = [];
        if (count($_POST) !== 0) {

            // retour de saisie du formulaire
            $usager = $_POST;

            $oUsager = new Usagers($usager); // création d'un objet Usager pour contrôler la saisie
            $erreurs = $oUsager->erreurs;
            if (count($erreurs) === 0) { 
                $id_usager = $this->oRequetesSQL->getAjouterUsager([
                    'nom'    => $oUsager->nom,
                    'prenom' => $oUsager->prenom,
                    'courriel' => $oUsager->courriel,
                    'mdp' => $oUsager->mdp,
                    'profil' => $oUsager->idprofil
                ]);

                if ($id_usager > 0) { 
                    $this->messageRetourAction = "Ajout de l'Usager numéro $id_usager effectué.";
                } else {
                    $this->classRetour = "erreur";
                    $this->messageRetourAction = "Ajout de l'Usager non effectué.";
                }
                $this->listerUsagers(); // retour sur la page de liste des Usager
                exit;
            }
        }

        new Vue(
            'vAdminUsagerAjouter',
            array(
                'oUtilConn'   => $this->oUtilConn,
                'titre'       => 'Ajouter un Usager',
                'Usager'        => $usager,
                'erreurs'     => $erreurs
            ),
            'gabarit-admin'
        );
    }

    /**
     * Modifier un Usager identifié par sa clé dans la propriété id_usager
     */
    public function modifierUsager()
  {
    if (count($_POST) !== 0) {
      $usager = $_POST;
      $oUsager = new Usagers($usager);
      $erreurs = $oUsager->erreurs;
      if (count($erreurs) === 0) {
        if ($this->oRequetesSQL->modifierUsager([
          'id_usager'     => $oUsager->id_usager,
          'nom'    => $oUsager->nom,
          'prenom' => $oUsager->prenom,
          'courriel' => $oUsager->courriel,
          'profil' => $oUsager->profil
        ])) {
          $this->messageRetourAction = "Modification de l'Usager numéro $this->id_usager effectuée.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "modification de l'Usager numéro $this->id_usager non effectuée.";
        }
        $this->listerUsagers();
        exit;
      }
    } else {
    // chargement initial du formulaire  
    // initialisation des champs dans la vue formulaire avec les données SQL de cet Usager  
         $usager  = $this->oRequetesSQL->getUsager($this->id_usager);
      $erreurs = [];
    }

    new Vue(
      'vAdminUsagerModifier',
      array(
        'oUtilConn' => $this->oUtilConn,
        'titre'     => "Modifier l'Usager numéro $this->id_usager",
        'Usager'    => $usager,
        'erreurs'   => $erreurs
      ),
      'gabarit-admin'
    );
  }

    /**
     * Supprimer un Usager identifié par sa clé dans la propriété id_usager
     */
     public function supprimerUsager()
  {

    if (
      $this->oUtilConn->idprofil !== Usagers::PROFIL_ADMINISTRATEUR
    )
      throw new Exception(self::ERROR_FORBIDDEN);

    if ($this->oRequetesSQL->supprimerUsager($this->id_usager)) {
      $this->messageRetourAction = "Suppression de l'utilisateur numéro $this->id_usager effectuée.";
    } else {
      $this->classRetour = "erreur";
      $this->messageRetourAction = "Suppression de l'utilisateur numéro $this->id_usager non effectuée.";
    }
    $this->listerusagers();
  }

}
