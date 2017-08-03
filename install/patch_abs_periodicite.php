<?php
/**************************************
 Cree le: 06-03-2012
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

/**** FOR MANUAL PATCH, EXECUTE THIS CODE INTO mysql SERVER 

DROP TABLE abs_periodicite;

CREATE TABLE IF NOT EXISTS `abs_periodicite` (
  `periodicite_id` int(2) NOT NULL AUTO_INCREMENT,
  `periodicite_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `periodicite_jours` int(3) NOT NULL,
  PRIMARY KEY (`periodicite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `abs_periodicite` (`periodicite_id`, `periodicite_libelle`, `periodicite_jours`) VALUES (1, 'Aucune', 0);
UPDATE `abs_conges` SET `conges_periodicite` = '1' WHERE `conges_periodicite` = 0;

****/


session_start();

require ("../include/db.class.php");
require ("../include/db.config.php");
require ("../include/fonctions.php");

//Utilisateur avec statut admin_general
if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {

$titreEtape = "";
$message = "<div align=\"center\">This patch will erase and recreate 'abs_periodicite' table.<br/><br/>
		<input class=\"formButton\" value=\"START\" type=\"button\" onclick=\"document.location.replace('patch.php?step01');\" /></div>";

if (isset($_REQUEST["step01"])) {

	$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
	$db->connect();


	$drop = $db->query("DROP TABLE abs_periodicite;");
	if($drop) {
	
		$create = $db->query("CREATE TABLE IF NOT EXISTS `abs_periodicite` (
			  `periodicite_id` int(2) NOT NULL AUTO_INCREMENT,
			  `periodicite_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `periodicite_jours` int(3) NOT NULL,
			  PRIMARY KEY (`periodicite_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	      	if(!$create) {
			$message = "Error table 'abs_periodicite' : ".mysql_error()."<br/><br/>";
		}
		else {
			$insert = $db->query("INSERT INTO `abs_periodicite` (`periodicite_id`, `periodicite_libelle`, `periodicite_jours`) VALUES ('1', 'Aucune', 0)");
			$update = $db->query("UPDATE `abs_conges` SET `conges_periodicite` = '1' WHERE `conges_periodicite` = 0");

			$message =  "Table 'abs_periodicite' OK <br/><br/> Application Patched successfully.<br/><br/>
					<div align=\"center\"><input class=\"formButton\" value=\"INDEX\" type=\"button\" onclick=\"document.location.replace('../index.php');\" /></div>";


		}
	}
	else {
		$message = "ERROR: CANNOT DELETE 'abs_periodicite': ".mysql_error()."<br/><br/>PLEASE PATCH MANUALLY (reade source code of /install/patch.php).";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Gestion des Cong&eacute; et Absences: Patch</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../style/style.css" rel="stylesheet" type="text/css"/>
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" type="image/png" href="../images/favicon.png" />
</head>
<body>
	<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
	<tr><td id="ds_calclass">
	</td></tr>
	</table>

	<div id="setupLogoHeader"></div><div id="rightHeaderImage"></div>

	<div id="option-menu-bar"><br/>
		<div align="center"><h3>Patch</h3></div>
	</div>
	<br/>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
	    		<div class="pageTitleLogin"><h2><?php echo $titreEtape; ?></h2></div>
				<br/>
				<div align="center">
<?php
					if (isset($message)) echo $message."<br/><br/>";

?>
				</div>
				<br/>
			</div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
}
else echo "<br/>FORBIDDEN - Must be Admin<br/><br/>";
?>

