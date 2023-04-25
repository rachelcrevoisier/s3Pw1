<?php

/**
 * Classe Routeur
 * analyse l'uri et exécute la méthode associée  
 *
 */
class Routeur
{

  private $routes = [
    // uri, classe, méthode
    // --------------------
    ['admin',                 'Admin',    'gererAdmin'],
    ['',                      'Frontend', 'accueil'],
    ['accueil',               'Frontend', 'accueil'],
    ['connecter',             'cUsager', 'connecter'],
    ['deconnecter',           'cUsager', 'deconnecter'],
    ['inscription',           'cUsager', 'inscription'],
    ['validationInscription', 'cUsager', 'validationInscription'],
    ['voirUsager',            'cUsager', 'voirUsager'],
    ['ajoutEnchere',          'cEnchere', 'ajouterEnchere'],
    ['enchere     ',          'cEnchere', 'voirEnchere']
  ];

  protected $oRequetesSQL; // objet RequetesSQL utilisé par tous les contrôleurs

  // const BASE_URI = '/31B/'; // dossier racine du site par rapport au dossier racine d'Apache 
  //const BASE_URI = '/Users/14384/Dropbox/Mes%20documents/Perso%20-%202018-07-26/College/session%203/ProjetWebUn/site/'; // pour le PHP Server de Visual Studio Code
  const BASE_URI = '/ProjetWebUn/site/'; // pour le PHP Server de Visual Studio Code
  //const BASE_URI = '/projetWeb1/'; //Pour webdev
  const ERROR_FORBIDDEN = "HTTP 403";
  const ERROR_NOT_FOUND = 'HTTP 404';

  /**
   * Constructeur qui valide l'URI,
   * instancie un contrôleur et exécute une méthode de ce contrôleur,
   * chaque URI valide est associé à un contrôleur et une méthode de ce contrôleur
   */
  public function __construct()
  {
    try {

      // contrôle de l'uri si l'action coïncide

      $uri =  $_SERVER['REQUEST_URI'];
      if (strpos($uri, '?')) $uri = strstr($uri, '?', true);

      foreach ($this->routes as $route) { // balayage du tableau des routes

        $routeUri     = self::BASE_URI . $route[0];
        $routeClasse  = $route[1];
        $routeMethode = $route[2];

        if ($routeUri ===  $uri) {
          // on exécute la méthode associée à l'uri
          $oControleur = new $routeClasse;
          $oControleur->$routeMethode();
          exit;
        }
      }
      // aucune route ne correspond à l'uri
      throw new Exception(self::ERROR_NOT_FOUND);
    } catch (Error | Exception $e) {
      $this->erreur($e);
    }
  }

  /**
   * Méthode qui envoie un compte-rendu d'erreur
   * @param Exception $e 
   */
  public function erreur($e)
  {
    $message = $e->getMessage();
    if ($message == self::ERROR_FORBIDDEN) {
      header('HTTP/1.1 403 Forbidden');
    } else if ($message == self::ERROR_NOT_FOUND) {
      header('HTTP/1.1 404 Not Found');
      new Vue('vErreur404', [], 'gabarit-erreur');
    } else {
      header('HTTP/1.1 500 Internal Server Error');
      new Vue('vErreur500', ['e' => $e], 'gabarit-erreur');
    }
    exit;
  }
}
