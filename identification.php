<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 20-09-2013
 Cree par: JC Prin
**************************************

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

session_start();

require ("include/config.php");
require ("include/db.config.php");
require ("include/db.class.php");

include ("include/fonctions.php");

//connexion a la base
$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();


if (isset($_REQUEST["ident"]) && isset($_REQUEST["login"]) && isset($_REQUEST["pass"]) ) {
	$utilLogin = strtolower($_REQUEST["login"]);
	$utilPass = sha1($_REQUEST["pass"]);

	if ($utilLogin != "" && $utilPass != "") { 
		$result = $db->query("SELECT * FROM abs_utilisateur WHERE util_login = '$utilLogin' AND util_password  = '$utilPass'");
		if ($db->numRows($result) != 0) {
			if ($result[0]["util_actif"] == 1) {
				//enregistrement de la session
				//session_register("authabsences"); //plus supporte par PHP 5.3

				// déclaration des variables de session
				$_SESSION['login'] = $utilLogin; 
				$_SESSION['nom'] = utf8_encode($result[0]["util_nom"]);
				$_SESSION['prenom'] = utf8_encode($result[0]["util_prenom"]);
				$_SESSION['admin_secteur'] = $result[0]["util_admin_secteur"];
				$_SESSION['admin_general'] = $result[0]["util_admin_general"];
				
				//deconnexion de la base
				$db->close();

				//On redirige vers l'index
				header("Location: index.php");
			}
			else header("Location: login.php?erreur=desactive");	//$message .= "L'utilisateur entre est desactive";
		}
		else header("Location: login.php?erreur=badlog");	//$message .= "Mauvais login ou mot de passe";
	}
	else header("Location: login.php?erreur=badlog");	//$message .= "Mauvais login ou mot de passe";
}
else header("Location: login.php?erreur=empty");


?>
