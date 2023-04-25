<?php

/**
 * Classe Contrôleur des requêtes de l'application Enchere
 */

class cEnchere extends Routeur
{

    private $id_enchere;
    private $oUtilConn;


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
            $id_usager = $_POST['idusager'];
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
                $id_enchere = (int)$id_enchere;
                if ($id_enchere) {
                    $id_timbre = $this->oRequetesSQL->getAjouterTimbre([
                        'nom'        => $oTimbre->pays . '#10' . $id_enchere . ' ' . $oTimbre->idcondition . ' $' . $oEnchere->tarifBase,
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
                if ($id_timbre) {
                    $id_image = $this->oRequetesSQL->getAjouterVisuel([
                        'lien'        => $oTimbre->fichierVisuel,
                        'typeVisuel'  => $oTimbre->typeVisuel,
                        'idtimbre'    => $id_timbre
                    ]);
                }


                header("Location: /ProjetWebUn/site/voirUsager?id_usager=.$id_usager"); // retour sur la page du profil
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

    /**
     * Voir les informations d'une enchere
     */
    public function voirEnchere()
    {
        $enchere = false;
        if (!is_null($this->id_enchere)) {
            $enchere = $this->oRequetesSQL->getenchere($this->id_enchere);
            //$encheresUsager = $this->oRequetesSQL->getEncheresUsager($this->id_enchere);
            //$encheres = $this->oRequetesSQL->getEnchereUsager($this->id_usager);
            //$mise = $this->oRequetesSQL->getMiseUsager($this->id_usager);

            if (!$enchere) throw new Exception("Cette enchère n'existe pas");

            new Vue(
                'vEnchere',
                array(
                    'oUtilConn' => $this->oUtilConn,
                    'titre' => 'Fiche d\'une enchère',
                    'usager' => $enchere,
                    //'encheresUsager' => $encheresUsager,
                    //'mise' => $mise,
                ),
                'gabarit-frontend'
            );
        }
    }
}
