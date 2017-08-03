<?php
/**************************************
 Cree le: 03-03-2010
 Derniere modification: 06-03-2012
 Cree par: JC Prin
***************************************

Copyright (C) 2010  PRIN Jean-Charles

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

******************************************************************************/


function getInstallEtape($numEtape) {

	switch ($numEtape) {

		case 1:		return "Etape 1: Licence";break;
		case 2:		return "Etape 2: Param&eacute;trage MySQL";break;
		case 3:		return "Etape 3: V&eacute;rification du param&eacute;trage MySQL";break;
		case 4:		return "Etape 4: Installation de la base et des tables";break;
		case 5:		return "Etape 5: Param&eacute;trage du compte Administrateur et des otpions";break;
		case 6:		return "Fin de l'installation";break;

		default:	return "Etape 1: Licence";break;
	}
}


function getIncludePageSetup($numEtape) {

	switch ($numEtape) {

		case 1:		return "licence";break;
		case 2:		return "mysqlConfig";break;
		case 3:		return "mysqlCheck";break;
		case 4:		return "dbSetup";break;
		case 5:		return "endSetup";break;
		case 6:		return "endSetup";break;

		default:	return "licence";break;
	}
}


function checkDB($dbHostName,$dbName,$dbIsCreated,$dbUserName,$dbPassword,$dbPlanningUserName,$dbPlanningPassword) {

	if ($dbIsCreated) {
		if (mysql_connect($dbHostName, $dbUserName, $dbPassword)) {
			if (mysql_select_db($dbName)) {
				$result = mysql_query("SHOW TABLES");
				if (mysql_num_rows($result) > 0) {
					$_SESSION['error'] = "La base '$dbName' n'est pas vide.";
					return false;
				}
				else return true;

			} else {
				$_SESSION['error'] = "Impossible de se connecter &agrave; la base: ".mysql_error();
				return false;
			}

		} else {
			$_SESSION['error'] = "Impossible d'&eacute;tablir une connexion &agrave;la base: ".mysql_error();
			return false;
		}
	} else {
		if (mysql_connect($dbHostName, $dbUserName, $dbPassword)) {
			mysql_query("CREATE DATABASE " . $dbName);

			if(!@mysql_select_db($dbName)) {
				$mysqlErrNo = mysql_errno();
				$errorMsg = mysql_error();

				if(!isset($errorMsg) || $errorMsg == '') {
					$_SESSION['error'] = "Impossible de cr&eacute;er la base: $mysqlErrNo";
					return false;
				}

				if (isset($mysqlErrNo)) {
					if ($mysqlErrNo == '1102') {
						$_SESSION['error'] = ". Veuillez utiliser un nom valide pour la base: $errorMsg";
						return false;
					}
				}
				
				return false;
			}
			else return true;
		} else {
			$_SESSION['error'] = "Impossible d'&eacute;tablir une connexion &agrave;la base: ".mysql_error();
			return false;
		}

	}
}


function checkUser($dbHostName,$dbName,$dbUserName,$dbPassword,$dbPlanningUserName,$dbPlanningPassword) {

	if (mysql_connect($dbHostName, $dbUserName, $dbPassword)) {
	      	$query = "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP, INDEX ON `$dbName`.*
				TO ".$dbPlanningUserName."@".$dbHostName." IDENTIFIED BY '$dbPlanningPassword'";

	      	if(!@mysql_query($query)) {
		 	$_SESSION['error'] = mysql_error() or die();
		 	return false;
	      	}
		else {
			$query = "SET PASSWORD FOR ".$dbPlanningUserName."@".$dbHostName." = password('$dbPlanningPassword')";
	      		if (!@mysql_query($query)) {
				$_SESSION['error'] = mysql_error() or die();
		 		return false ;
	      		}
			else return true;
		}
	}
	else {
		$_SESSION['error'] = "Impossible d'&eacute;tablir une connexion &agrave;la base: ".mysql_error();
		return false;
	}
}


function writeDBConfFile($dbHostName,$dbName,$dbPlanningUserName,$dbPlanningPassword) {
	
	$filename = "../include/db.config.php";

	$DBConfContent = <<< DBCONFCONT
<?php

//database server
define('DB_SERVER', "$dbHostName");
//database login name
define('DB_USER', "$dbPlanningUserName");
//database login password
define('DB_PASS', "$dbPlanningPassword");
//database name
define('DB_DATABASE', "$dbName");

?>

DBCONFCONT;

	if ($handle = fopen($filename, 'w')) {
		if (fwrite($handle, $DBConfContent)) {
    			fclose($handle);
			return true;
		}
		else return false;
	}
	else return false;
}





function insertData($dbHostName,$dbName,$dbUserName,$dbPassword) {
	
	$erreur = "Erreur d'insertion des donn&eacute;es";
	$_SESSION["insertData"] = "ok";

	if (mysql_connect($dbHostName, $dbUserName, $dbPassword)) {
		if(@mysql_select_db($dbName)) {
			$query = "INSERT INTO abs_feries (feries_id, feries_nom, feries_date, feries_fixe) VALUES
				(1, '1er Janvier', '01-01-1900', 1),
				(2, 'Fête du travail', '01-05-1947', 1),
				(3, 'Victoire 1945', '08-05-1946', 1),
				(4, '14 Juillet', '14-07-1880', 1),
				(5, 'Assomption', '15-08-1900', 1),
				(6, 'Toussaint', '01-11-1900', 1),
				(7, 'Armistice 1918', '11-11-1919', 1),
				(8, 'Noël', '25-12-1900', 1);";

		      	@mysql_query($query);

			$query = "INSERT INTO abs_periodicite (periodicite_id, periodicite_libelle, periodicite_jours) VALUES
				(1, 'Chaque semaine', 7),
				(2, 'Une semaine sur deux', 15),
				(3, 'Une semaine sur trois', 21);";

		      	@mysql_query($query);

			$query = "INSERT INTO abs_type (type_id, type_nom, type_couleur) VALUES
				(1, 'Congés Payés', '#E67E30'),
				(2, 'Congés Sans Solde', '#463F32'),
				(3, 'RTT', '#FEC3AC'),
				(4, 'Formation', '#A10684'),
				(5, 'Cours', '#A10684'),
				(6, 'Maternité / Paternité', '#463F32'),
				(7, 'Maladie', '#C60800'),
				(8, 'Décès', '#463F32'),
				(9, 'Autres', '#463F32');";

		      	@mysql_query($query);

			return "Donn&eacute;es primaires pour l'utilisation ins&eacute;r&eacute;e";
		}
		else return $erreur." -1";
	}
	return $erreur." -2";
}


function insertAdmin($dbHostName,$dbName,$dbUserName,$dbPassword,$adminLogin,$adminPassword) {

	if (mysql_connect($dbHostName, $dbUserName, $dbPassword)) {
		if (mysql_select_db($dbName)) {
			$adminPassword = sha1($adminPassword);
		      	$query = "INSERT INTO `abs_utilisateur` (`util_login`, `util_password`, `util_nom`, `util_prenom`, `util_admin_secteur`, `util_admin_general`, `util_actif`) 
					VALUES ('$adminLogin', '$adminPassword', 'Admin', 'Planning', 0, 1, 1)";

		      	if(!@mysql_query($query)) {
			 	$_SESSION['error'] = "Erreur de cr&eacute;ation du compte Administrateur: ".mysql_error() or die();
			 	return false;
		      	}
			else return true;
		} else {
			$_SESSION['error'] = "Impossible de se connecter &agrave; la base: ".mysql_error();
			return false;
		}		
	}
	else {
		$_SESSION['error'] = "Impossible d'&eacute;tablir une connexion &agrave;la base: ".mysql_error();
		return false;
	}
}


function writeOptConfFile($adminLogin,$dateDebut,$accesVisiteur,$exportPDF,$lang,$timezone) {

	if($accesVisiteur == 1) $accesVisiteur = "TRUE";
	else $accesVisiteur = "FALSE";

	if($exportPDF == 1) $exportPDF = "TRUE";
	else $exportPDF = "FALSE";

	
	$filename = "../include/config.php";

	$OptConfContent = <<< OPTCONFCONT
<?php

//Langue
define('LANG', '$lang');

if (phpversion() >= 5.1) {
//Fuseau Horaire
date_default_timezone_set('$timezone');
}

//mode debug
define('DEBUG', FALSE);

//Acces Visiteur
define('ACCES_VISITEUR', $accesVisiteur);

//Premiere Annee d'utilisation
define('FIRST_YEAR', '$dateDebut');

//Login Administrateur
define('LOGIN_ADMIN','$adminLogin');

//Export PDF du calendrier
define('EXPORT_PDF', $exportPDF);

?>

OPTCONFCONT;

	if ($handle = fopen($filename, 'w')) {
		if (fwrite($handle, $OptConfContent)) {
    			fclose($handle);
			return true;
		}
		else return false;
	}
	else return false;
}

?>
