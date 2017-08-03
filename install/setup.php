<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 06-03-2012
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

require ("../include/db.class.php");
require ("../include/db.config.php");
require ("../include/fonctions.php");
require ("setupFonctions.php");

//Si la conf existe deja et que l'on est sur aucune etape, on redirige vers index.php
if (!isset($_REQUEST["numEtape"]) && checkConfig()) header("Location: index.php"); 


if (isset($_REQUEST["numEtape"])) $numEtape = $_REQUEST["numEtape"];
else $numEtape = 1;

//Etape 1 validee (LICENCE)
if (isset($_REQUEST["licenceok"])) $numEtape = 2;

//Etape 2: mysqlConfig
if (isset($_REQUEST["mysqlConfig"])) {
	$_SESSION["error"] = "";
	$_SESSION["dbInfo"] = array();
	$_SESSION["dbInfo"]["dbHostName"] = trim($_REQUEST["dbHostName"]);
	$_SESSION["dbInfo"]["dbName"] = trim($_REQUEST["dbName"]);
	$_SESSION["dbInfo"]["dbIsCreated"] = $_REQUEST["dbIsCreated"];
	$_SESSION["dbInfo"]["dbUserName"] = trim($_REQUEST["dbUserName"]);
	$_SESSION["dbInfo"]["dbPassword"] = trim($_REQUEST["dbPassword"]);
	$_SESSION["dbInfo"]["dbPlanningUserName"] = trim($_REQUEST["dbPlanningUserName"]);
	$_SESSION["dbInfo"]["dbPlanningPassword"] = trim($_REQUEST["dbPlanningPassword"]);
}

//Etape 4-b: Insertion de donnees dans les tables
if (isset($_REQUEST["insertData"])) {
	if ($_REQUEST["insertData"] == 1) $message = insertData($_SESSION["dbInfo"]["dbHostName"],$_SESSION["dbInfo"]["dbName"],$_SESSION["dbInfo"]["dbUserName"],$_SESSION["dbInfo"]["dbPassword"]);
}

//Etape 5: endSetup
if (isset($_REQUEST["endSetup"])) {
	$_SESSION["error"] = "";
	$_SESSION["confInfo"] = array();
	$_SESSION["confInfo"]["adminLogin"] = trim($_REQUEST["adminLogin"]);
	$_SESSION["confInfo"]["adminPassword"] = trim($_REQUEST["adminPassword"]);
	$_SESSION["confInfo"]["dateDebut"] = trim($_REQUEST["dateDebut"]);
	$_SESSION["confInfo"]["accesVisiteur"] = $_REQUEST["accesVisiteur"];
	$_SESSION["confInfo"]["exportPDF"] = $_REQUEST["exportPDF"];
	$_SESSION["confInfo"]["lang"] = $_REQUEST["lang"];
	$_SESSION["confInfo"]["timezone"] = trim($_REQUEST["timezone"]);
}


$titreEtape = getInstallEtape($numEtape);
$includePage = getIncludePageSetup($numEtape);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Gestion des Cong&eacute; et Absences: Installation</title>
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
		<div align="center"><h3>Installation du Planning de Gestion des Cong&eacute; et Absencess</h3></div>
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

					include($includePage.".php");
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
