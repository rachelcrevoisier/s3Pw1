<?php

/**
 * Classe Contrôleur des requêtes de l'application cUsager
 */

class cUsager extends Routeur
{

    private $id_enchere;
    private $id_usager;
    private $oUtilConn;

    /**
     * Constructeur qui initialise le contexte du contrôleur  
     */
    public function __construct()
    {
        $this->oUtilConn = $_SESSION['oUtilConn'] ?? null;
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
                    $this->voirUsager(); // retour sur la page de liste des utilisateur

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

}
