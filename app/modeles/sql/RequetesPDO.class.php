<?php

/**
 * Classe des requêtes PDO 
 *
 */
class RequetesPDO {

  protected $sql;

  const UNE_SEULE_LIGNE = true;

  /**
   * Requête $sql SELECT de récupération d'une ou plusieurs lignes
   * @param array   $params paramètres de la requête préparée
   * @param boolean $uneSeuleLigne true si une seule ligne à récupérer false sinon 
   * @return array|false false si aucune ligne retournée par fetch
   */ 
  public function getLignes($params = [], $uneSeuleLigne = false) {
    $sPDO = SingletonPDO::getInstance();
    $oPDOStatement = $sPDO->prepare($this->sql);
    $nomsParams = array_keys($params);
    foreach ($nomsParams as $nomParam) $oPDOStatement->bindParam(':'.$nomParam, $params[$nomParam]);
    $oPDOStatement->execute();
    $result = $uneSeuleLigne ? $oPDOStatement->fetch(PDO::FETCH_ASSOC) : $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * Requête $sql de Création Update ou Delete d'une ligne
   * @param array   $params paramètres de la requête préparée
   * @return boolean|string chaîne contenant lastInsertId s'il est > 0
   */ 
  public function CUDLigne($params = []) {
    $sPDO = SingletonPDO::getInstance();

    $oPDOStatement = $sPDO->prepare($this->sql);
    foreach ($params as $nomParam => $valParam) $oPDOStatement->bindValue(':'.$nomParam, $valParam);
    $oPDOStatement->execute();
    if ($oPDOStatement->rowCount() <= 0) return false;
    if ($sPDO->lastInsertId() > 0)       return $sPDO->lastInsertId();
    return true;
  }
}