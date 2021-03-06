<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlConsulterReservations.php : traiter la demande de consultation de reservation
// Ecrit le 13/10/2015 par Nicodeo

if ( ! isset ($_POST ["numero"]) == true) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$msgFooter = 'Annuler une réservation';
		$themeFooter = $themeNormal;
		include_once ('vues/VueAnnulerReservation.php');
	}
	if ( empty ($_POST ["numero"]) == true)  $numero = "";  else   $numero = $_POST ["numero"];
	if ($numero == '') {
		// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
		$msgFooter = 'Données incomplètes !';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueAnnulerReservation.php');
	}
	else {
		// connexion du serveur web à la base MySQL
		include_once ('modele/DAO.class.php');
		$dao = new DAO();
		// test de l'existence d'une réservation
		// la méthode existeReservation de la classe DAO retourne true si $nom existe, false s'il n'existe pas
		if ( ! $dao->existeReservation($numero) )  {
			// si le nom n'existe pas, retour à la vue
			$msgFooter = "Numéro de réservation inexistant !";
			$themeFooter = $themeProbleme;
			include_once ('vues/VueAnnulerReservation.php');
		}
		else {
			if($dao->estLeCreateur($_SESSION["nom"], $numero)){
				$dao->creerLesDigicodesManquants();
				$res = $dao->getReservation($numero);
					if($res->getEnd_time()<time()){
						$msgFooter = "Cette réservation est déjà passééé.";
						$themeFooter = $themeProbleme;
					}else{
						// annule la réservation du numéro suivant donné en paramètre
						$dao->annulerReservation($numero);
						$msgFooter = 'La réservation a été annulée.';
						$themeFooter = $themeNormal;
					}
				
			}else{
				$msgFooter = "Vous n'êtes pas l'auteur de cette réservation.";
				$themeFooter = $themeProbleme;
			}
			include_once ('vues/VueAnnulerReservation.php');
		}
		
		unset($dao);		// fermeture de la connexion à MySQL
	}

