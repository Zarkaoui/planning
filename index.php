<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 05-03-2012
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

// ORANGE - Pierre NICOLETTA - Edgar FERNANDES
// ********************************************

// Get FEATURE_TOGGLE from environment variables
$feature_toggle = getenv('FEATURE_TOGGLE');

if ($feature_toggle != "enabled") {
        $feature_toggle = "disabled";
}

// Get DARK_LAUNCH from environment variables
$dark_launch = getenv('DARK_LAUNCH');

if ($dark_launch != "enabled") {
        $dark_launch = "disabled";
}

// Get connexion from ETCD server
$url = "http://etcd:2379/v2/keys/planning/feature-countdays";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$feature_countdays = $json_data["node"]["value"];

if ($feature_countdays != "enabled") {
	$feature_countdays = "disabled";
}

// ********************************************

require ("include/config.php");
require ("include/db.config.php");
require ("include/db.class.php");

include ("include/lang/".LANG.".php");
include ("include/fonctions.php");

//Test le fichier db.config.php pour verifier si l'installation a ete effectuee
if (!checkConfig()) header("Location: install/setup.php");


//connexion a la base
$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

//recuperation de l'action a effectuer pour la page
if (isset($_REQUEST["action"])) $action = $_REQUEST["action"];
else $action = "";

//on recupere les infos de la page
$tabPage = array();
$tabPage = getIncludePage($action);
$includePage = $tabPage[0];
$titrePage = $tabPage[1];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo LANG_TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	<script src="js/datepickercontrol.js" type="text/javascript" ></script>
	<script src="js/autocompletion/prototype.js" type="text/javascript"></script>
	<script src="js/autocompletion/scriptaculous.js" type="text/javascript"></script>
 	<link href="style/datepickercontrol_lnx.css" type="text/css" rel="stylesheet" />
	<link href="style/style.css" rel="stylesheet" type="text/css"/>
	<link href="style/menu.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!--[if IE]>
	<link href="style/IE6_menu.css" rel="stylesheet" type="text/css">
	<![endif]--> 	

	<!--[if lte IE 6]>
	<style type="text/css">
	#top-menu {
	    /*width:expression(document.body.clientWidth < 1000 ? "900px" : "100%" );*/
	}
	</style>
	<![endif]-->
</head>
<body>
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
	<tr><td id="ds_calclass">
	</td></tr>
</table>

<a href="index.php" class=""><img src="images/companyLogo.png" alt="Login" /></a><div id="rightHeaderImage"></div>
<div id="option-menu-bar">
	<div align="center"><?php echo $titrePage; ?></div>
<?php
//pas de menu de deconnexion pour session visiteur
if (isset($_SESSION['login'])) {
?>
		<ul id="option-menu">
    			<li><sup><span class="italique"><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]; ?></span></sup></li>
			<li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
	 		<li><a href="logout.php" class="lienNoDeco"><img src="images/quitter.gif" alt="" />&nbsp; <sup> <?php echo LANG_FIN_SESSION; ?></sup></a></li>
		</ul>
<?php
}
?>
</div>     
       	<!-- Debut Menu -->           
	<div id="top-menu">
		<ul id="menu">
<?php
		//Utilisateur avec statut admin_general
		if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
			//Menu : Admin
?>
			<li id="admin">
			<a href="#" class="l1_link"><span>Admin</span></a>
				<ul class="sousMenu">
<?php
			//Admin general du site uniquement
			if (isset($_SESSION['login']) && ($_SESSION['login'] == LOGIN_ADMIN)) {
?>
	
					<li id="ent">
						<a href="#" class="l2_link"><?php echo LANG_ENT; ?></a>
						<ul>
							<li id="entGen"><a class="l2_link" href="index.php?action=entGen"><?php echo LANG_ENTGEN; ?></a></li>
							<li id="entSucc"><a class="l2_link" href="index.php?action=entSucc"><?php echo LANG_ENTSUC; ?></a></li>
						</ul>
					</li>
<?php
			}
?>
					<li id="postes">
						<a href="#" class="l2_link"><?php echo LANG_POSTES; ?></a>
						<ul>
							<li id="fonct"><a class="l2_link" href="index.php?action=listPostes&amp;fonct"><?php echo LANG_FONCTS; ?></a></li>
							<li id="cat"><a class="l2_link" href="index.php?action=listPostes&amp;cat"><?php echo LANG_CAT; ?> 1</a></li>
							<li id="cat"><a class="l2_link" href="index.php?action=listPostes&amp;cat2"><?php echo LANG_CAT; ?> 2</a></li>
						</ul>
					</li>
<?php
			//Admin general du site uniquement
			if (isset($_SESSION['login']) && ($_SESSION['login'] == LOGIN_ADMIN)) {
?>
					<li id="util">
						<a href="#" class="l2_link"><span class="drop"><?php echo LANG_UTILS; ?></span></a>
						<ul class="sousMenu">
							<li id="utilList" class="drop">
								<a class="l2_link" href="index.php?action=listUtil"><?php echo LANG_LIST; ?></a>
							</li>
							<li id="utilAdd" class="drop">
								<a class="l2_link" href="index.php?action=addUtil&amp;add"><?php echo LANG_ADD; ?></a>
							</li>
							<li id="utilDroits" class="drop">
								<a class="l2_link" href="index.php?action=droitsUtil"><?php echo LANG_DROITS; ?></a>
							</li>
						</ul>
					</li>
					<li id="typeAbs" class="drop">
						<a href="index.php?action=typeAbs&amp;liste" class="l2_link"><?php echo LANG_TYPE_ABS; ?></a>
					</li>
<?php
			}
			//Utilisateur avec statut admin_general
			if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {
?>
					<li id="sect" class="drop">
						<a href="index.php?action=sect&amp;liste" class="l2_link"><?php echo LANG_SECTS; ?></a>
					</li>
					<li id="perio" class="drop">
						<a href="index.php?action=periodicite&amp;liste" class="l2_link"><?php echo LANG_PERIO; ?></a>
					</li>
<?php
			}
?>
				</ul>
			</li>
<?php
}
			//Menu : Employes
?>
			<li id="empl">
				<a href="#" class="l1_link"><span class="drop"><?php echo LANG_EMPS; ?></span></a>
				<ul class="sousMenu">
					<li id="emplList" class="drop">
						<a class="l2_link" href="index.php?action=listEmpl"><?php echo LANG_LIST; ?></a>
					</li>
<?php
		//Utilisateur avec statut admin_general
		if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
?>		
					<li id="emplAdd" class="drop">
						<a class="l2_link" href="index.php?action=addEmpl&amp;add"><?php echo LANG_ADD; ?></a>
					</li>
<?php
}
?>
				</ul>
			</li>
<?php			//Menu: Absences
?>
			<li id="abs">
				<a href="#" class="l1_link"><span class="drop"><?php echo LANG_ABSS; ?></span></a>
				<ul class="sousMenu">
					<li id="feries" class="drop">
						<a class="l2_link" href="index.php?action=affFeries&amp;liste"><?php echo LANG_JFERIES; ?></a>
					</li>
<?php
		//Utilisateur avec statut admin_general ou admin_secteur
		if (isset($_SESSION['login']) && ( $_SESSION['admin_secteur'] == 1 || $_SESSION['admin_general'] == 1)) {
?>
					<li id="absAssign" class="drop">
						<a class="l2_link txtRight" href="index.php?action=doAbs"><?php echo LANG_ASSIGNABS; ?></a>
					</li>
<?php
}
?>
					<li id="absList" class="drop">
						<a class="l2_link txtRight" href="index.php?action=listAbs"><?php echo LANG_LISTABSS; ?></a>
					</li>
					<li id="cal" class="drop">
						<a class="l2_link" href="index.php?action=affCal"><?php echo LANG_CAL; ?></a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- Fin Menu -->

	<!-- Debut Page -->
<?php
	//on inclut la page a afficher
	include("pages/".$includePage.".php");

	//deconnexion de la base
	$db->close();
?>
	<!-- Fin Page -->
<br/><br/>
</body>
</html>

