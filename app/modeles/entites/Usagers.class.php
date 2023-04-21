<?php

/**
 * Classe de l'entité Usagers
 *
 */
class Usagers
{
  private $id_usager;
  private $nom;
  private $prenom;
  private $adresse;
  private $codePostal;
  private $ville;
  private $pays;
  private $courriel;
  private $telephone;
  private $mdp;
  private $idprofil;


  const PROFIL_ADMINISTRATEUR = "administrateur";
  const PROFIL_MEMBRE         = "membre";


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
  public function getid_usager()
  {
    return $this->id_usager;
  }
  public function getnom()
  {
    return $this->nom;
  }
  public function getprenom()
  {
    return $this->prenom;
  }
  public function getadresse()
  {
    return $this->adresse;
  }
  public function getcodePostal()
  {
    return $this->codePostal;
  }
  public function getville()
  {
    return $this->ville;
  }
  public function getpays()
  {
    return $this->pays;
  }
  public function getcourriel()
  {
    return $this->courriel;
  }
  public function gettelephone()
  {
    return $this->telephone;
  }
  public function getmdp()
  {
    return $this->mdp;
  }
  public function getidprofil()
  {
    return $this->idprofil;
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
   * Mutateur de la propriété id_usager 
   * @param int $id_usager
   * @return $this
   */
  public function setid_usager($id_usager)
  {
    $this->id_usager = $id_usager; // à remplacer avec des contrôles
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
   * Mutateur de la propriété prenom 
   * @param string $prenom
   * @return $this
   */
  public function setprenom($prenom)
  {
    $this->prenom = $prenom;
    unset($this->erreurs['prenom']);
    $prenom = trim($prenom);
    $regExp = '/^[a-zÀ-ÖØ-öø-ÿ]{2,}( [a-zÀ-ÖØ-öø-ÿ]{2,})*$/i';
    if (!preg_match($regExp, $prenom)) {
      $this->erreurs['prenom'] = "Au moins 2 caractères alphabétiques pour chaque mot.";
    }
    $this->prenom = $prenom;
    return $this;
  }
  /**
   * Mutateur de la propriété adresse 
   * @param string $adressee
   * @return $this
   */
  public function setadresse($adresse)
  {
    $this->adresse = $adresse;
    unset($this->erreurs['adresse']);
    $this->adresse = $adresse;
    return $this;
  }
  /**
   * Mutateur de la propriété Code Postal 
   * @param string $codePostal
   * @return $this
   */
  public function setcodePostal($codePostal)
  {
    $this->codePostal = $codePostal;
    unset($this->erreurs['codePostal']);
    $this->codePostal = $codePostal;
    return $this;
  }

  /**
   * Mutateur de la propriété Ville 
   * @param string $ville
   * @return $this
   */
  public function setville($ville)
  {
    $this->ville = $ville;
    unset($this->erreurs['ville']);
    $this->ville = $ville;
    return $this;
  }
  /**
   * Mutateur de la propriété Pays 
   * @param string $pays
   * @return $this
   */
  public function setpays($pays)
  {
    $this->pays = $pays;
    unset($this->erreurs['pays']);
    $this->pays = $pays;
    return $this;
  }

  /**
   * Mutateur de la propriété courriel
   * @param string $courriel
   * @return $this
   */
  public function setcourriel($courriel)
  {
    $this->courriel = $courriel;
    unset($this->erreurs['courriel']);
    $courriel = trim($courriel);
    $regExp = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/i';
    if (!preg_match($regExp, $courriel)) {
      $this->erreurs['courriel'] = "Saisissez une adresse mail valide.";
    }
    $this->courriel = $courriel;
    return $this;
  }

  /**
   * Mutateur de la propriété telephone
   * @param string $telephone
   * @return $this
   */
  public function settelephone($telephone)
  {
    $this->telephone = $telephone;
    unset($this->erreurs['telephone']);
    $this->telephone = $telephone;
    return $this;
  }


  /**
   * Mutateur de la propriété mdp
   * @param string $mdp
   * @return $this
   */
  public function setmdp($mdp)
  {
    $this->mdp = $mdp;
    unset($this->erreurs['mdp']);
    $mdp = trim($mdp);
    $regExp = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[%!\:=])([A-Za-z0-9%!\:=]{10,})$/i';
    if (!preg_match($regExp, $mdp)) {
      $this->erreurs['mdp'] = "Saisissez au moins 10 caracteres et un caractere parmi %!:= ainsi qu'un chiffre";
    }
    $this->mdp = $mdp;
    return $this;
  }

  /**
   * Mutateur de la propriété idprofil
   * @param string $idprofil
   * @return $this
   */
  public function setidprofil($idprofil)
  {
    $this->idprofil = $idprofil;
    unset($this->erreurs['idprofil']);
    $this->idprofil = $idprofil;
    return $this;
  }
}
