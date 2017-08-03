<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 24-02-2012
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

// ORANGE - Pierre NICOLETTA - Edgar FERNANDES
// ********************************************

// Get APP_VERSION from environment variables
$app_version = getenv('APP_VERSION');
if ($app_version == "") {
        $app_version = "X.X.X";
}

// Get connexion from ETCD server
$url = "http://etcd:2379/v2/keys/planning/connexion";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$connexion = $json_data["node"]["value"];

// ********************************************

require ("include/config.php");
require ("include/db.config.php");

include ("include/lang/".LANG.".php");
include ("include/fonctions.php");

//Test le fichier db.config.php pour verifier si l'installation a ete effectuee
if (!checkConfig()) header("Location: install/setup.php");

$message = "";
if (isset($_REQUEST["erreur"])) {
	
	switch ($_REQUEST["erreur"]) {
		case "badlog":		$message = LANG_LOGIN_BADLOG;$couleur = "rouge";break;
		case "desactive":	$message = LANG_LOGIN_UTIL_DESACT;$couleur = "rouge";break;
		case "logout":		$message = LANG_LOGIN_DECO;$couleur = "vert";break;
	
		default: 	$message = "";
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo LANG_LOGIN_TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="icon" type="image/png" href="images/favicon.png" />
	<link href="style/style.css" rel="stylesheet" type="text/css"/>
	<link href="style/menu.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass">
<tr><td id="ds_calclass">
</td></tr>
</table>

	<div id="companyLogoHeader"></div><div id="rightHeaderImage"></div>
	<div id="top-menu"><div align="center"><h2><?php echo LANG_LOGIN_TITLE; ?></h2></div>
<br/>
<div align="center">
	<div class="width500" >
		<div id="status"></div>
		<div class="outerbox">
			<div class="top">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
			<div class="maincontent">
		    		<div class="pageTitleLogin"><h2><?php echo LANG_LOGIN_CONNEXION; ?></h2></div>
					<br/>
					<form name="formLogin" method="post" action="identification.php">

						<table border="0">
							<tr>
								<th><?php echo LANG_LOGIN; ?>: </th>
								<td><input type="text" name="login" maxlength="30" /></td>
							</tr>
							<tr>
								<th><?php echo LANG_LOGIN_MDP; ?>: </th>
								<td><input type="password" name="pass" maxlength="15" /></td>							
							</tr>
						</table>
						<br/>
						<?php if ($message != "") echo "<div class=\"$couleur\" align=\"center\">$message</div>"; ?>
						<div class="formbuttons" align="center">
							<input class="formButton" value="<?php echo LANG_LOGIN_CONNEXION; ?>" name="ident" type="submit" />
							<input class="formButton" value="<?php echo LANG_LOGIN_EFFACER; ?>" type="reset" />
						</div>
					</form>
				</div>
				<div class="bottom">
					<div class="left"></div>
					<div class="right"></div>
					<div class="middle"></div>
				</div>
			</div>
		</div>

		<br/><br/>
<?php
//Bouton Acces Visiteur
if (ACCES_VISITEUR) {
?>
		<div align="center"><a href="index.php?action=index" class="noDeco"><input class="formButton lienNoDeco" value="<?php echo LANG_LOGIN_ACCES_VISIT; ?>" type="button" /></a></div>
<?php
}
?>

	</div>
</div>
</body>
</html>
			
