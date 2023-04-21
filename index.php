<?php
require 'app/includes/chargementClasses.inc.php';
// Après le script de chargement des classes
// pour pouvoir recharger l'objet de la classe Usager
// stocké dans $_SESSION si l'usager est connecté
session_start();

new Routeur;
