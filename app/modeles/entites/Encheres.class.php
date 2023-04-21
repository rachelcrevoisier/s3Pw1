<?php

/**
 * Classe de l'entité Encheres
 *
 */
class Encheres
{
    private $id_enchere;
    private $dateDebut;
    private $dateFin;
    private $idtimbre;


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
    public function getid_enchere()
    {
        return $this->id_enchere;
    }
    public function getdateDebut()
    {
        return $this->dateDebut;
    }
    public function getdateFin()
    {
        return $this->dateFin;
    }
    public function getidtimbre()
    {
        return $this->idtimbre;
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
    public function setid_enchere($id_enchere)
    {
        $this->id_enchere = $id_enchere; // à remplacer avec des contrôles
    }

    /**
     * Mutateur de la propriété dateDebut 
     * @param string $dateDebut
     * @return $this
     */
    public function setdateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
        unset($this->erreurs['dateDebut']);
        $dateDebut = trim($dateDebut);
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * Mutateur de la propriété dateFin 
     * @param string $dateFin
     * @return $this
     */
    public function setdateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        unset($this->erreurs['dateFin']);
        $dateFin = trim($dateFin);
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * Mutateur de la propriété idtimbre 
     * @param string $idtimbre
     * @return $this
     */
    public function setidtimbre($idtimbre)
    {
        $this->idtimbre = $idtimbre;
        unset($this->erreurs['idtimbre']);
        $idtimbre = trim($idtimbre);
        $this->idtimbre = $idtimbre;
        return $this;
    }
}
