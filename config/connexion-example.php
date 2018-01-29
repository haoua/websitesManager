<?php 
	// DEFINIR LES CONSTANTES DE CONNEXION
	define("HOST", "");
	define("LOGIN", "");
	define("PASS", "");
	define("BDD", "");

	// CONNEXION A LA BASE DE DONNEES
	// @ permet de désactiver les messages d'erreurs du serveur
	// (ces messages laissent trop d'informations à un hacker)
	$mysqli = @new mysqli(HOST,LOGIN,PASS,BDD);

	$mysqli->set_charset("utf8");

	// Si une erreur de connexion
	// Je vais faire appel à une méthode qui retourne le numéro de l'erreur
	if ($mysqli -> connect_errno) {
		echo $mysqli -> connect_error;
		// Alors je tue le script et retourne mon message personnalisé
		die("<p class=\"alerte\">Error data.</p>");
	}
 ?>