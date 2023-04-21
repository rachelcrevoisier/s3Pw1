<?php

/**
 * Classe de l'entité Mises
 *
 */
class Mises
{
    private $id_mise;
    private $dateMise;
    private $montant;
    private $idusager;
    private $idenchere;

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
    public function getid_mise()
    {
        return $this->id_mise;
    }
    public function getdateMise()
    {
        return $this->dateMise;
    }
    public function getmontant()
    {
        return $this->montant;
    }
    public function getidusager()
    {
        return $this->idusager;
    }
    public function getidenchere()
    {
        return $this->idenchere;
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
    public function setid_mise($id_mise)
    {
        $this->id_mise = $id_mise; // à remplacer avec des contrôles
    }

    /**
     * Mutateur de la propriété dateDebut 
     * @param string $dateDebut
     * @return $this
     */
    public function setdateMise($dateMise)
    {
        $this->dateMise = $dateMise;
        unset($this->erreurs['dateMise']);
        $dateMise = trim($dateMise);
        $this->dateMise = $dateMise;
        return $this;
    }

    /**
     * Mutateur de la propriété Montant 
     * @param string $montant
     * @return $this
     */
    public function setmontant($montant)
    {
        $this->montant = $montant;
        unset($this->erreurs['montant']);
        $montant = trim($montant);
        $this->montant = $montant;
        return $this;
    }

    /**
     * Mutateur de la propriété idusager 
     * @param string $idusager
     * @return $this
     */
    public function setidusager($idusager)
    {
        $this->idusager = $idusager;
        unset($this->erreurs['idusager']);
        $idusager = trim($idusager);
        $this->idusager = $idusager;
        return $this;
    }

    /**
     * Mutateur de la propriété idenchere 
     * @param string $idenchere
     * @return $this
     */
    public function setidenchere($idenchere)
    {
        $this->idenchere = $idenchere;
        unset($this->erreurs['idenchere']);
        $idenchere = trim($idenchere);
        $this->idenchere = $idenchere;
        return $this;
    }
}
