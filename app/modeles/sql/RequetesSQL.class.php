<?php
require 'app/includes/config.php';
/**
 * Classe des requêtes SQL
 *
 */
class RequetesSQL extends RequetesPDO
{
  /* GESTION DES USAGERS 
     ======================== */

  /**
   * Connecter un usager
   * @param array $champs, tableau avec les champs courriel et mdp  
   * @return array|false ligne de la table, false sinon 
   */
  public function connecter($champs)
  
  {
    //var_dump($champs);
    $this->sql = "
      SELECT id_usager, nom, prenom, courriel, idprofil
      FROM usagers
      WHERE courriel = :courriel AND mdp = SHA2(:mdp, 512)";

    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
    
  }

  /**
   * Récupération des encheres en cours, terminees, fin imminente, nouvellement en ligne, timbres favoris du Lord ou timbres certifiees
   * @param  string $critere
   * @return array tableau des lignes produites par la select   
   */
  public function getEncheres($critere = 'encours')
  {
    
    $oAujourdhui = ENV === "DEV" ? new DateTime(MOCK_NOW) : new DateTime();
    $aujourdhui  = $oAujourdhui->format('Y-m-d');
    $nouvelle = $oAujourdhui->modify('+2 day')->format('Y-m-d');
    $imminent = $oAujourdhui->modify('+30 day')->format('Y-m-d');
    $this->sql = "
      SELECT *
      FROM timbres
      INNER JOIN encheres ON timbres.idenchere = encheres.id_enchere
      INNER JOIN images ON timbres.id_timbre = images.idtimbre";

    switch ($critere) {
      case 'encours':
        $this->sql .= " WHERE encheres.dateFin > '$aujourdhui'";
        break;
      case 'imminent':
        $this->sql .= " WHERE '$aujourdhui' < '$imminent'";
        break;
      case 'termine':
        $this->sql .= " WHERE dateFin < '$aujourdhui'";
        break;
      case 'nouvelles':
        $this->sql .= " WHERE '$nouvelle' >= encheres.dateDebut AND dateFin > '$aujourdhui' ORDER BY dateDebut DESC LIMIT 5";
        break;
      case 'certifie':
        $this->sql .= " WHERE timbres.certifie = 'Oui' AND encheres.dateFin > '$aujourdhui' AND encheres.dateDebut <= '$aujourdhui' ORDER BY dateDebut LIMIT 5";
        break;
      case 'choixlord':
        $this->sql .= " WHERE encheres.choixLord = 'Oui' ";
        break;
      
    }
    return $this->getLignes();
  }

  /**
   * Récupération des usagers
   * @return array tableau des lignes produites par la select 
   */
  public function getlisterUsagers()
  {
    $this->sql = "
      SELECT *
      FROM usagers
      ORDER BY nom ASC";

    return $this->getLignes();
  }

  /**
   * Récupération d'un usager de la table usager
   * @param int $id_usager 
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */
   public function getUsager($id_usager)
  {
    $this->sql = '
      SELECT *
      FROM usagers
      WHERE id_usager = :id_usager';
    return $this->getLignes(['id_usager' => $id_usager], RequetesPDO::UNE_SEULE_LIGNE);
  }



  /**
   * Modifier un usager
   * @param array $champs tableau avec les champs à modifier et la clé id_usager
   * @return boolean true si modification effectuée, false sinon
   */
  /*   public function modifierusager($champs)
  {
    $this->sql = '
      UPDATE usagers SET nom = :nom, prenom = :prenom, courriel = :courriel, profil = :profil
      WHERE id_usager = :id_usager';
    return $this->CUDLigne($champs);
  } */

  /**
   * Supprimer un usager
   * @param int $id_usager clé primaire
   * @return boolean true si suppression effectuée, false sinon
   */
  public function supprimerusager($id_usager)

  {
    $this->sql = '
      DELETE FROM usagers WHERE id_usager = :id_usager';
    return $this->CUDLigne(['id_usager' => $id_usager]);
  }

  /**
   * Ajouter un usager
   * @param array $champs tableau des champs de l'usager
   * @return string|boolean clé primaire de la ligne ajoutée, false sinon
   */
  public function getInscription($champs)
  {
    $this->sql = '
      INSERT INTO usagers SET nom = :nom, prenom = :prenom, adresse = :adresse, codePostal = :codePostal, ville = :ville, pays = :pays, courriel = :courriel, telephone = :telephone, mdp = SHA2(:mdp, 512), idprofil = :idprofil';
    return $this->CUDLigne($champs);
  }

   public function getEncheresUsager($id_usager)
  {
    $this->sql = '
      SELECT *
      FROM timbres
      INNER JOIN encheres ON timbres.idenchere = encheres.id_enchere
      INNER JOIN images ON timbres.id_timbre = images.idtimbre
      WHERE encheres.idusager = :id_usager';
    return $this->getLignes(['id_usager' => $id_usager]);
  }

  public function getAjouterEnchere($champs)
  {
    $this->sql = '
      INSERT INTO encheres SET dateDebut = :dateDebut, dateFin = :dateFin, tarifBase = :tarifBase, choixLord = :choixLord, idusager = :idusager';

    return $this->CUDLigne($champs);
  }

  public function getAjouterTimbre($champs)
  {
    $this->sql = '
      INSERT INTO timbres SET nom = :nom, pays = :pays, certifie = :certifie, annee = :annee, couleur = :couleur, tirage = :tirage, dimensions = :dimensions, histoire = :histoire, idcondition = :idcondition, idenchere = :idenchere';

    return $this->CUDLigne($champs);
  }
  public function getAjouterVisuel($champs)
  {
    $this->sql = '
      INSERT INTO images SET lien = :lien, typeVisuel = :typeVisuel, idtimbre = :idtimbre';

    return $this->CUDLigne($champs);
  }


  /**
   * Récupération d'une enchère
   * @param int $id_enchere
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */
  public function getEnchere($id_enchere)
  {
    $this->sql = '
      SELECT *
      FROM encheres
      WHERE id_enchere = :id_enchere';
    return $this->getLignes(['id_enchere' => $id_enchere], RequetesPDO::UNE_SEULE_LIGNE);
  }

}
