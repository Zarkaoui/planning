<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 13-03-2014
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

if (mysql_connect($_SESSION["dbInfo"]["dbHostName"], $_SESSION["dbInfo"]["dbUserName"],$_SESSION["dbInfo"]["dbPassword"])) {

	$erreur = false;

	if (mysql_select_db($_SESSION["dbInfo"]["dbName"])) {
	      	$query = "CREATE TABLE IF NOT EXISTS `abs_categorie` (
			  `cat_id` int(2) NOT NULL AUTO_INCREMENT,
			  `cat_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`cat_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_categorie' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_categorie' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_categorie2` (
			  `cat2_id` int(2) NOT NULL AUTO_INCREMENT,
			  `cat2_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`cat2_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_categorie2' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_categorie2' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_conges` (
			`conges_id` int(5) NOT NULL AUTO_INCREMENT,
			`conges_employe` int(3) NOT NULL,
			`conges_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			`conges_type` int(2) NOT NULL,
			`conges_demijournee` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
			`conges_debut` int(5) NOT NULL,
			`conges_periodicite` int(2) NOT NULL,
			`conges_periodicite_debut` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			`conges_periodicite_fin` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			`conges_commentaire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			`conges_login_saisie` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
			`conges_date_saisie` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`conges_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_conges' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_conges' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_droits_ent` (
			  `droits_ent_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
			  `droits_ent_id` int(2) NOT NULL,
			  PRIMARY KEY (`droits_ent_util`,`droits_ent_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_droits_ent' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_droits_ent' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_droits_sect` (
			  `droits_sect_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
			  `droits_sect_id` int(2) NOT NULL,
			  PRIMARY KEY (`droits_sect_util`,`droits_sect_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_droits_sect' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_droits_sect' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_employe` (
			  `emp_id` int(3) NOT NULL AUTO_INCREMENT,
			  `emp_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_actif` int(1) NOT NULL,
			  `emp_arrivee` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_statut` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_samedi` int(1) NOT NULL,
			  `emp_date_naissance` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_categorie1` int(2) NOT NULL,
			  `emp_categorie2` int(2) NOT NULL,
			  `emp_fonction` int(2) NOT NULL,
			  `emp_secteur` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_depart` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `emp_ent` int(2) NOT NULL,
			  `emp_nb_conges_cours` float NOT NULL,
			  `emp_nb_conges_report` float NOT NULL,
			  PRIMARY KEY (`emp_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_employe' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_employe' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_entreprise` (
			  `ent_id` int(2) NOT NULL AUTO_INCREMENT,
			  `ent_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_addr1` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_addr2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_cp` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_tel` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_fax` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
			  `ent_comm` text COLLATE utf8_unicode_ci NOT NULL,
			  `ent_parent` int(2) NOT NULL,
			  PRIMARY KEY (`ent_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_entreprise' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_entreprise' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_feries` (
			  `feries_id` int(3) NOT NULL AUTO_INCREMENT,
			  `feries_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `feries_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `feries_fixe` int(1) NOT NULL,
			  PRIMARY KEY (`feries_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_feries' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_feries' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_fonction` (
			  `fonct_id` int(2) NOT NULL AUTO_INCREMENT,
			  `fonct_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`fonct_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_fonction' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_fonction' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_periodicite` (
			  `periodicite_id` int(2) NOT NULL AUTO_INCREMENT,
			  `periodicite_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `periodicite_jours` int(3) NOT NULL,
			  PRIMARY KEY (`periodicite_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_periodicite' : ".mysql_error()."<br/><br/>";
		}
		else {
			$query = "INSERT INTO `abs_periodicite` (`periodicite_id`, `periodicite_libelle`, `periodicite_jours`) VALUES (0, 'Aucune', 0)";
			@mysql_query($query);
			echo "Table 'abs_periodicite' OK <br/><br/>";
		}

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_secteur` (
			  `sect_id` int(2) NOT NULL AUTO_INCREMENT,
			  `sect_nom` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
			  `sect_intitule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`sect_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_secteur' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_secteur' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_type` (
			  `type_id` int(2) NOT NULL AUTO_INCREMENT,
			  `type_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `type_couleur` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
			  `type_commentaire` int(1) NOT NULL,
			  PRIMARY KEY (`type_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_type' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_type' OK <br/><br/>";

	      	$query = "CREATE TABLE IF NOT EXISTS `abs_utilisateur` (
			  `util_login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
			  `util_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
			  `util_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `util_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  `util_admin_secteur` int(1) NOT NULL,
			  `util_admin_general` int(1) NOT NULL,
			  `util_actif` int(1) NOT NULL,
			  PRIMARY KEY (`util_login`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	      	if(!@mysql_query($query)) {
			$erreur = true;
			echo "Erreur table 'abs_utilisateur' : ".mysql_error()."<br/><br/>";
		}
		else echo "Table 'abs_utilisateur' OK <br/><br/>";


		if ($erreur) {
			echo "Si les probl&egrave;mes d'installation persistent, utilisez le script 'base.sql' situ&eacute; dans le r&eacute;pertoire 'install'.<br/><br/>
				<input type=\"button\" value=\"Retour\" onclick=\"back();\"/>";
			
		}
		else {
?>		
		<form name="formMysqlCheck2" method="post" action="setup.php">
			<input type="hidden" name="numEtape" value="5" />
			Ins&eacute;rer des donn&eacute;es primaires pour l'utilisation (jours f&eacute;ri&eacute;s, type d'absences, ...):<br/>
			Oui <input type="radio" name="insertData" value="1" checked> &nbsp;&nbsp;&nbsp;Non <input type="radio" name="insertData" value="0" >
			<br/><br/>
			<input type="submit" value="Continuer" />
		</form>
<?php
		}
	}
}
else echo "Impossible d'&eacute;tablir une connexion &agrave;la base: ".mysql_error();
?>

