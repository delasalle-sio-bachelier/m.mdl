<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlAnnulerReservation.php : annulation d'une réservation
// Ecrit le 12/10/2015 par Jim
// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.php');
$dao = new DAO();

	if ( empty ($_POST ["nom"]) == true)  $nom = "";  else   $nom = $_POST ["nom"];
	
	if ($nom == '') {
		// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
		$msgFooter = 'Données incomplètes !';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueSupprimerUtilisateur.php');
	} 
	elseif ($dao->existeUtilisateur($nom)== false) {
		$msgFooter = 'Nom d\'utilisateur inexistant !';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueSupprimerUtilisateur.php');
	}
	elseif ($dao->aPasseDesReservations($nom)) {
		$msgFooter = 'Cet utilisateur a passé des réservations à venir !';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueSupprimerUtilisateur.php');
	}
	elseif (empty($dao->supprimerUtilisateur($nom))) {
		$msgFooter = 'Problème lors de la suppression de l\'utilisateur !';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueSupprimerUtilisateur.php');
	}
	