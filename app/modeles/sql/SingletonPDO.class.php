<?php

class SingletonPDO extends PDO
{
  private static $instance = null;

  const DB_SERVEUR  = 'localhost';
  const DB_NOM      = 'projetweb1';
  const DB_DSN      = 'mysql:host=' . self::DB_SERVEUR . ';dbname=' . self::DB_NOM . ';charset=utf8';
  const DB_LOGIN    = 'root';
  const DB_PASSWORD = '';
  /* const DB_SERVEUR  = 'localhost';
  const DB_NOM      = 'e2194722';
  const DB_DSN      = 'mysql:host=' . self::DB_SERVEUR . ';dbname=' . self::DB_NOM . ';charset=utf8';
  const DB_LOGIN    = 'e2194722';
  const DB_PASSWORD = 'o5I1EUZdCsIpbF50OubM'; */

  /**
   * Constructeur qui instancie un objet SingletonPDO dans une propriété $instance, en l'initialisant comme un objet PDO
   */
  private function __construct()
  {

    $options = [
      PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,  // Gestion des erreurs par des exceptions de la classe PDOException
      PDO::ATTR_EMULATE_PREPARES  => false                    // Préparation des requêtes non émulée
    ];
    parent::__construct(self::DB_DSN, self::DB_LOGIN, self::DB_PASSWORD, $options);
    $this->query("SET lc_time_names = 'fr_FR'"); // Pour afficher les jours en français
  }

  /**
   * Méthode __clone inutilisable car private
   */
  private function __clone()
  {
  }

  /**
   * Instanciation d'un objet SingletonPDO s'il n'existe pas déjà dans la propriété $instance
   * @return object SingletonPDO
   */
  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new SingletonPDO();
    }
    return self::$instance;
  }
}
