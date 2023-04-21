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
    private $choixLord;
    private $idcondition;


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
    public function getchoixLord()
    {
        return $this->choixLord;
    }
    public function getidcondition()
    {
        return $this->idcondition;
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
        $regExp = '/^[a-zÀ-ÖØ-öø-ÿ]{2,}( [a-zÀ-ÖØ-öø-ÿ]{2,})*$/i';
        if (!preg_match($regExp, $nom)) {
            $this->erreurs['nom'] = "Au moins 2 caractères alphabétiques pour chaque mot.";
        }
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
     * Mutateur de la propriété Choix Lord 
     * @param string $choixLord
     * @return $this
     */
    public function setchoixLord($choixLord)
    {
        $this->pays = $choixLord;
        unset($this->erreurs['choixLord']);
        $this->choixLord = $choixLord;
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

}
