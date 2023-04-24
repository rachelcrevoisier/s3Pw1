<?php

/**
 * Classe de l'entité Timbres
 *
 */
class Timbres
{
    private $id_timbre;
    private $nom;
    private $pays;
    private $certifie;
    private $annee;
    private $couleur;
    private $idcondition;
    private $tirage;
    private $dimensions;
    private $histoire;
    private $lien;
    private $typeVisuel;
    private $fichierVisuel;


    private $erreurs = array();

    /**
     * Constructeur de la classe
     * @param array $proprietes, tableau associatif des propriétés 
     *
     */
    public function __construct($proprietes = [])
    {
        $t = array_keys($proprietes);
        foreach ($t as $nom_propriete) {
            $this->__set($nom_propriete, $proprietes[$nom_propriete]);
        }
    }

    /**
     * Accesseur magique d'une propriété de l'objet
     * @param string $prop, nom de la propriété
     * @return property value
     */
    public function __get($prop)
    {
        return $this->$prop;
    }

    // Getters explicites nécessaires au moteur de templates TWIG
    public function getid_timbre()
    {
        return $this->id_timbre;
    }
    public function getnom()
    {
        return $this->nom;
    }
    public function getpays()
    {
        return $this->pays;
    }
    public function getcertifie()
    {
        return $this->certifie;
    }
    public function getannee()
    {
        return $this->annee;
    }
    public function getcouleur()
    {
        return $this->couleur;
    }
    public function gettirage()
    {
        return $this->tirage;
    }
    public function getdimensions()
    {
        return $this->dimensions;
    }
    public function gethistoire()
    {
        return $this->histoire;
    }
    public function getchoixLord()
    {
        return $this->choixLord;
    }
    public function getidcondition()
    {
        return $this->idcondition;
    }
    public function getlien()
    {
        return $this->lien;
    }
    public function gettypeVisuel()
    {
        return $this->typeVisuel;
    }
    public function getfichierVisuel()
    {
        return $this->fichierVisuel;
    }
    public function getErreurs()
    {
        return $this->erreurs;
    }

    /**
     * Mutateur magique qui exécute le mutateur de la propriété en paramètre 
     * @param string $prop, nom de la propriété
     * @param $val, contenu de la propriété à mettre à jour    
     */
    public function __set($prop, $val)
    {
        $setProperty = 'set' . ucfirst($prop);
        $this->$setProperty($val);
    }


    /**
     * Mutateur de la propriété ID 
     * @param int $ID
     * @return $this
     */
    public function setid_timbre($id_timbre)
    {
        $this->id_timbre = $id_timbre; // à remplacer avec des contrôles
    }

    /**
     * Mutateur de la propriété nom 
     * @param string $nom
     * @return $this
     */
    public function setnom($nom)
    {
        $this->nom = $nom;
        unset($this->erreurs['nom']);
        $nom = trim($nom);
        $this->nom = $nom;
        return $this;
    }

    /**
     * Mutateur de la propriété pays 
     * @param string $pays
     * @return $this
     */
    public function setpays($pays)
    {
        $this->pays = $pays;
        unset($this->erreurs['pays']);
        $pays = trim($pays);
        $regExp = '/^[a-zÀ-ÖØ-öø-ÿ]{2,}( [a-zÀ-ÖØ-öø-ÿ]{2,})*$/i';
        if (!preg_match($regExp, $pays)) {
            $this->erreurs['pays'] = "Au moins 2 caractères alphabétiques pour chaque mot.";
        }
        $this->pays = $pays;
        return $this;
    }
    /**
     * Mutateur de la propriété certifie 
     * @param string $certifie
     * @return $this
     */
    public function setcertifie($certifie)
    {
        $this->certifie = $certifie;
        unset($this->erreurs['certifie']);
        $this->certifie = $certifie;
        return $this;
    }
    /**
     * Mutateur de la propriété annee 
     * @param string $annee
     * @return $this
     */
    public function setannee($annee)
    {
        $this->annee = $annee;
        unset($this->erreurs['annee']);
        $this->annee = $annee;
        return $this;
    }

    /**
     * Mutateur de la propriété Couleur 
     * @param string $couleur
     * @return $this
     */
    public function setcouleur($couleur)
    {
        $this->couleur = $couleur;
        unset($this->erreurs['couleur']);
        $this->couleur = $couleur;
        return $this;
    }

    /**
     * Mutateur de la propriété idCondition
     * @param string $idcondition
     * @return $this
     */
    public function setidcondition($idcondition)
    {
        $this->idcondition = $idcondition;
        unset($this->erreurs['idcondition']);
        $idcondition = trim($idcondition);
        $this->idcondition = $idcondition;
        return $this;
    }

    /**
     * Mutateur de la propriété tirage
     * @param string $tirage
     * @return $this
     */
    public function settirage($tirage)
    {
        $this->tirage = $tirage;
        unset($this->erreurs['tirage']);
        $tirage = trim($tirage);
        $this->tirage = $tirage;
        return $this;
    }
    /**
     * Mutateur de la propriété dimensions
     * @param string $dimensions
     * @return $this
     */
    public function setdimensions($dimensions)
    {
        $this->dimensions = $dimensions;
        unset($this->erreurs['dimensions']);
        $dimensions = trim($dimensions);
        $this->dimensions = $dimensions;
        return $this;
    }

    /**
     * Mutateur de la propriété histoire
     * @param string $histoire
     * @return $this
     */
    public function sethistoire($histoire)
    {
        $this->histoire = $histoire;
        unset($this->erreurs['histoire']);
        $histoire = trim($histoire);
        $this->histoire = $histoire;
        return $this;
    }
    /**
     * Mutateur de la propriété lien pour le visuel du timbre
     * @param string $lien
     * @return $this
     */
    public function setlien($lien)
    {
        $this->lien = $lien;
        unset($this->erreurs['lien']);
        $lien = trim($lien);
        $this->lien = $lien;
        return $this;
    }

    /**
     * Mutateur de la propriété visuel pour premier ou second
     * @param string $typeVisuel
     * @return $this
     */
    public function settypeVisuel($typeVisuel)
    {
        $this->typeVisuel = $typeVisuel;
        unset($this->erreurs['typeVisuel']);
        $typeVisuel = trim($typeVisuel);
        $this->typeVisuel = $typeVisuel;
        return $this;
    }
    /**
     * Mutateur de la propriété visuel pour premier ou second
     * @param string $typeVisuel
     * @return $this
     */
    public function setfichierVisuel($fichierVisuel)
    {
        $this->fichierVisuel = $fichierVisuel;
        unset($this->erreurs['fichierVisuel']);
        if (!is_uploaded_file($_FILES['fichierVisuel']['tmp_name'])) {
            $this->erreurs['fichierVisuel'] = "Aucun fichier n'a été chargé";
        } 
        else{
            if($_FILES['fichierVisuel']['type'] != 'image/webp'){
                $this->erreurs['fichierVisuel'] = "votre visuel doit être au format webp";
            }
            else if($_FILES['fichierVisuel']['size'] >300000){
                $this->erreurs['fichierVisuel'] = "votre visuel est trop lourd. Il ne doit pas dépasser 600ko";
            }else{
                $dossierVisuel = 'assets/img/timbres/';
                
                //$dossierVisuel = 'C:/wamp64/www/ProjetWebUn/site/assets/img/timbres/';
                $visuel = trim($_FILES['fichierVisuel']['name']);

                $nomVisuel = basename(time() . str_replace(" ", "-", $visuel));
                $uploadfile = $dossierVisuel . $nomVisuel;
                if (move_uploaded_file($_FILES['fichierVisuel']['tmp_name'], $uploadfile)) {
                    $this->fichierVisuel = $nomVisuel;
                    return $this;
                } else {
                    $this->erreurs['fichierVisuel'] = "Une erreur est survenue lors du téléchargement de votre fichier";
                }
            }
            
        }
    }
}
