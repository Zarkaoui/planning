<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 22-02-2013
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

******************************************************************************



Liste des fonctions:

checkConfig
getIncludePage
getLocalisation
getSecteur
getCategorie
getFonction
weekDay
checkSamedi
checkFerie
getNomFerie
checkWeekEnd
checkAbsence
checkAbsenceModif
checkPeriodicite
checkDay
getCouleurAbsence
getNomMois
getSeeDate
getJour
getNbEmployes
getCongesPeriode
getCongesPris
checkBirthday
getListeSecteursUtil
getListeVillesUtil
affecteDroitsSecteur
affecteDroitsVille
checkDroitsSecteur
checkDroitsVille
checkPresenceCongesType
hexaToRVBColors
checkPresenceSecteur
checkPresencePeriodicite
checkPresencePoste
*/


function checkConfig() {

	if (DB_SERVER == "null" && DB_USER == "null" && DB_PASS == "null" && DB_DATABASE == "null") return false;
	else return true;
}


function getIncludePage($action) {
	
	$includePage = "";
	$titrePage = "";
	$tabRetour = array();

	//on autorise une session visiteur avec acces a la liste/fiche des employes, a la liste des absences, au calendrier des absences et des jours feries
	if (!isset($_SESSION['login'])) {
		if (ACCES_VISITEUR) {
			if ($action == "index" || $action == "affCal" || $action == "listEmpl" || $action == "affFeries" || $action == "fichEmpl" || $action == "listAbs") {
				switch ($action) {
			
					case "index":				$includePage = "accueil";$titrePage = TITRE_PAGE_ACCUEIL;break;
					case "listEmpl":			$includePage = "listeEmployes";$titrePage = TITRE_PAGE_LISTEEMP;break;
					case "fichEmpl":			$includePage = "ficheEmploye";$titrePage = TITRE_PAGE_FICHEEMP;break;
					case "affFeries":			$includePage = "joursFeries";$titrePage = TITRE_PAGE_FERIES;break;
					case "listAbs":				$includePage = "listeAbsences";$titrePage = TITRE_PAGE_LISTEABS;break;
					case "affCal":				$includePage = "afficheCalendrier";$titrePage = TITRE_PAGE_CALABS;break;
			
					default: 				header("Location: login.php");			
				}
			}
			else header("Location: login.php");
		}
		else header("Location: login.php");
	}
	else {
		switch ($action) {
	
			case "index":				$includePage = "accueil";$titrePage = TITRE_PAGE_ACCUEIL;break;
			case "entGen":				$includePage = "entrepriseGeneral";$titrePage = TITRE_PAGE_ENTGEN;break;
			case "entSucc":				$includePage = "entrepriseSuccursales";$titrePage = TITRE_PAGE_SUCC;break;
			case "addSucc":				$includePage = "entrepriseAjoutSuccursale";$titrePage = TITRE_PAGE_SUCCGEST;break;

			case "listPostes":			$includePage = "postes";$titrePage = TITRE_PAGE_POSTES;break;
			case "addPostes":			$includePage = "ajoutPoste";$titrePage = TITRE_PAGE_POSTES;break;

			case "listUtil":			$includePage = "listeUtilisateurs";$titrePage = TITRE_PAGE_LISTUTIL;break;
			case "addUtil":				$includePage = "ajoutUtilisateur";$titrePage = TITRE_PAGE_ADDUTIL;break;
			case "droitsUtil":			$includePage = "affecteDroits";$titrePage = TITRE_PAGE_GESTUTIL;break;

			case "typeAbs":				$includePage = "typeAbsences";$titrePage = TITRE_PAGE_TYPEABS;break;
			case "periodicite":			$includePage = "periodicite";$titrePage = TITRE_PAGE_PERIODICITE;break;
			case "sect":				$includePage = "secteurs";$titrePage = TITRE_PAGE_SECTS;break;

			case "listEmpl":			$includePage = "listeEmployes";$titrePage = TITRE_PAGE_LISTEEMP;break;
			case "addEmpl":				$includePage = "ajoutEmploye";$titrePage = TITRE_PAGE_ADDEMP;break;
			case "modEmpl":				$includePage = "modifEmploye";$titrePage = TITRE_PAGE_MODEMP;break;
			case "fichEmpl":			$includePage = "ficheEmploye";$titrePage = TITRE_PAGE_FICHEEMP;break;

			case "affFeries":			$includePage = "joursFeries";$titrePage = TITRE_PAGE_FERIES;break;
			case "doAbs":				$includePage = "affecteAbsence";$titrePage = TITRE_PAGE_AFFABS;break;
			case "listAbs":				$includePage = "listeAbsences";$titrePage = TITRE_PAGE_LISTEABS;break;
			case "modAbs":				$includePage = "modifAbsence";$titrePage = TITRE_PAGE_MODIFABS;break;
			case "affCal":				$includePage = "afficheCalendrier";$titrePage = TITRE_PAGE_CALABS;break;

			default:				$includePage = "accueil";$titrePage = TITRE_PAGE_ACCUEIL;break;
		}
	}

	$tabRetour[] = $includePage;
	$tabRetour[] = $titrePage;

	return $tabRetour;
}


function getLocalisation ($db,$id) {

	$result = $db->query("SELECT ent_ville FROM abs_entreprise WHERE ent_id = $id");
	if ($db->numRows($result) != 0) return $result[0]["ent_ville"];
	
	return "";
}


function getSecteur ($db,$id) {

	$tabRetour = array();

	$result = $db->query("SELECT sect_nom, sect_intitule FROM abs_secteur WHERE sect_id = $id");
	if ($db->numRows($result) != 0) {
		$tabRetour[0] = $result[0]["sect_nom"];
		$tabRetour[1] = $result[0]["sect_intitule"];
	}
	
	return $tabRetour;
}


function getCategorie ($db,$id,$num) {

	if ($num == 1) {
		$table = "abs_categorie";
		$prefixe = "cat";
	}
	else {
		$table = "abs_categorie2";
		$prefixe = "cat2";
	}

	$result = $db->query("SELECT ".$prefixe."_nom FROM $table WHERE ".$prefixe."_id = $id");
	if ($db->numRows($result) != 0) return $result[0][$prefixe."_nom"];
	
	return "";
}


function getFonction ($db,$id) {

	$result = $db->query("SELECT fonct_nom FROM abs_fonction WHERE fonct_id = $id");
	if ($db->numRows($result) != 0) return $result[0]["fonct_nom"];
	
	return "";
}


function getEcartDates($date1,$date2,$type) {

	if ($date1 != "00-00-0000") {
		list($jour1,$mois1,$annee1) = explode("-",$date1);
		// on transforme la date en timestamp
		$timestamp1 = mktime(0,0,0,$mois1,$jour1,$annee1);

		if ($date2 != "00-00-0000") {
			list($jour2,$mois2,$annee2) = explode("-",$date2);
			$timestamp2 = mktime(0,0,0,$mois2,$jour2,$annee2);
		}
		else {	// date du jour directement en timestamp
			$timestamp2 = time();
		}

		// on calcule le nombre de secondes d'écart entre les deux dates
		$ecartSecondes = $timestamp2 - $timestamp1;
		// puis on tranforme en jours (arrondi inférieur)
		$ecartJours = floor($ecartSecondes / (60*60*24));
		//annee
		$ecartAnnees = round($ecartJours/365,2);
	
		if ($type == "secondes") return $ecartSecondes;
		if ($type == "jours") return $ecartJours;
		if ($type == "annees") return $ecartAnnees;
	}
	else return "---";
}



/* Number of days in a month/Year */	
function monthDays($month, $year) {
	return date("t", strtotime($year . "-" . $month . "-01"));
}//

	
function weekDay($date) {

	$thisDay = date("D", strtotime($date));
	return $thisDay;
}

function checkSamedi($db,$empID) {

	$result = $db->query("SELECT emp_samedi FROM abs_employe WHERE emp_id = $empID");
	if ($db->numRows($result) > 0) {
		if ($result[0]["emp_samedi"] == 1) return true;
	}

	return false;
}

function checkFerie($db,$jour,$mois,$annee) {

	if ($jour < 10 && (strlen($jour) == 1)) $jour = "0".$jour;
	if ($mois < 10 && (strlen($mois) == 1)) $mois = "0".$mois;
	$date = $jour."-".$mois."-".$annee;

	//Vérification de jour férié non fixe
	$result = $db->query("SELECT feries_id FROM abs_feries WHERE feries_date = '$date'");
	if ($db->numRows($result) > 0) return true;


	//Vérification de jour férié fixe
	$result = $db->query("SELECT feries_id FROM abs_feries WHERE feries_fixe = 1 AND LEFT(feries_date,2) = '$jour' AND SUBSTRING( feries_date, 4, 2 ) = '$mois'");
	if ($db->numRows($result) > 0) return true;
/*
	if ($db->numRows($result) > 0) {
		for($i = 0; $i < count($result); ++$i) {
			list($j,$m,$a) = explode("-",$result[$i]["feries_date"]);
			if ($m == $mois && $j == ) return true;
		}
	}
*/	
	return false;
}


function getNomFerie($db,$jour,$mois,$annee) {

	if ($jour < 10 && (strlen($jour) == 1)) $jour = "0".$jour;
	if ($mois < 10 && (strlen($mois) == 1)) $mois = "0".$mois;
	$date = $jour."-".$mois."-".$annee;

	//Nom du jour férié non fixe
	$result = $db->query("SELECT feries_nom FROM abs_feries WHERE feries_date = '$date'");
	if ($db->numRows($result) > 0) return $result[0]["feries_nom"];

	//Vérification de jour férié fixe
	$result = $db->query("SELECT feries_nom FROM abs_feries WHERE feries_fixe = 1 AND LEFT(feries_date,2) = '$jour' AND SUBSTRING( feries_date, 4, 2 ) = '$mois'");
	if ($db->numRows($result) > 0) return $result[0]["feries_nom"];
	
	return "";
}


function checkWeekEnd ($db,$date,$empID) {

	if  (weekDay($date) == "Sun" || (weekDay($date) == "Sat" && (!checkSamedi($db,$empID)))) return true;
	else return false;
}


function checkAbsence($db,$date,$empID) {

	$result = $db->query("SELECT conges_id FROM abs_conges WHERE conges_employe = $empID AND conges_date = '$date' AND conges_type != -1");
	if ($db->numRows($result) > 0) return true;

	return false;	
}

function checkAbsenceModif($db,$date,$empID,$absID) {

	$result = $db->query("SELECT conges_id FROM abs_conges WHERE conges_employe = $empID AND conges_date = '$date' AND conges_type != -1 AND conges_id != $absID AND conges_debut != $absID");
	if ($db->numRows($result) > 0) {
		if (DEBUG) echo "SELECT conges_id FROM abs_conges WHERE conges_employe = $empID AND conges_date = '$date' AND conges_type != -1 AND conges_id != $absID AND conges_debut != $absID <br/>";
		return true;
	}

	return false;	
}

function checkPeriodicite($db,$empID, $i, $month, $year) {

	$periodicite = $db->query("SELECT conges_id,conges_date,periodicite_jours,conges_demijournee,type_nom,type_couleur,conges_commentaire
					FROM abs_conges, abs_type, abs_periodicite
					WHERE conges_employe = '$empID' AND periodicite_jours != 0 AND conges_periodicite = periodicite_id AND conges_type = type_id");
	if ($db->numRows($periodicite) > 0) {
		$retour = array();
		$jour = date('D', strtotime("$i-$month-$year"));
		$semaine = date('W', strtotime("$i-$month-$year"));
		for($j = 0; $j < count($periodicite); ++$j) {
			if (date('Y', strtotime($periodicite[$j]["conges_date"])) == $year) {
				$jourPeriode = date('D', strtotime($periodicite[$j]["conges_date"]));
				$semainePeriode = date('W', strtotime($periodicite[$j]["conges_date"]));
				if ($jour == $jourPeriode) {
					if ( ($periodicite[$j]["periodicite_jours"] == 7) || ($periodicite[$j]["periodicite_jours"] == 15 && ($semaine%2 == $semainePeriode%2)) || ($periodicite[$j]["periodicite_jours"] == 21 && (($semainePeriode-$semaine)%3 == 0)) ) {
						//demi journée matin
						if ($periodicite[$j]["conges_demijournee"] == "m" ) $retour[0] = "demi_m";
						//demi journée après midi
						if ($periodicite[$j]["conges_demijournee"] == "a" ) $retour[0] = "demi_a";
						//congé journée entière
						if ($periodicite[$j]["conges_demijournee"] == "0" ) $retour[0] = "full";

						$retour[1] = $periodicite[$j]["type_nom"];
						$retour[2] = $periodicite[$j]["type_couleur"];
						$retour[3] = $periodicite[$j]["conges_commentaire"];
						if (DEBUG) echo "<br/>nom: ".$retour[0]." - comm: ".$periodicite[$j]["conges_commentaire"];
						return $retour;
					}
				}
			}
		}
	}

	return false;
}


function checkDay($db,$empID, $i, $month, $year) {
	
	if ($i < 10 && (strlen($i) == 1)) $i = "0".$i;
	if ($month < 10 && (strlen($month) == 1)) $month = "0".$month;
	$date = $i."-".$month."-".$year;
	//echo "date: $date <br/>"; //debug
	$retour = array();

	if (checkFerie($db,$i,$month,$year)) {
		$retour[0] = "ferie";
		$retour[1] = getNomFerie($db,$i,$month,$year);
		return $retour;
	}

	//Vérification de W-end
	if (checkWeekEnd($db,$date,$empID))	 {		
		$retour[0] = "weekend";
		return $retour;		
	}
	
	//Récupération des absences
	$result = $db->query("SELECT conges_id,conges_demijournee,conges_type,conges_commentaire,type_nom,type_couleur
				FROM abs_conges, abs_type
				WHERE conges_employe = '$empID' AND conges_date = '$date'
				AND type_id = conges_type
				ORDER BY conges_date ASC");
	
	if ($db->numRows($result) == 0) {
		//Pas de conges pris, on verifie si il n'y a pas une absence periodique	
		if (($retour = checkPeriodicite($db,$empID, $i, $month, $year)) != false) return $retour;
		else {	//jour travaillé
			$retour = array();
			$retour[0] = "default";
			return $retour;
		}	
	}
	else {
		if ($result[0]["conges_type"] == -1) {
			$retour = array();
			$retour[0] = "default";
		}
		else {				
			//demi journée matin
			if ($result[0]["conges_demijournee"] == "m" ) $retour[0] = "demi_m";
			//demi journée après midi
			if ($result[0]["conges_demijournee"] == "a" ) $retour[0] = "demi_a";
			//congé journée entière
			if ($result[0]["conges_demijournee"] == "0" ) $retour[0] = "full";

			$retour[1] = $result[0]["type_nom"];
			$retour[2] = $result[0]["type_couleur"];
			$retour[3] = $result[0]["conges_commentaire"];
		}

		return $retour;		

	}
}


function getCouleurAbsence($db,$type) {

	$result = $db->query("SELECT type_couleur FROM abs_type WHERE type_id = $type");
	if ($db->numRows($result) != 0) return $result[0]["type_couleur"];

	return "";
}


function getNomMois ($tab,$num) {

	if ($num > 0 && $num < 13) {
		if ($num < 10 && strlen($num) == 2) $num = substr($num,1,1);
		return $tab[$num];
	}
	else return "";
}


function getSeeDate($tabD,$tabM,$seeDate) {

	$date = date("n Y", strtotime($seeDate));
	$tabDate = explode(" ",$date);
	$mois = getNomMois($tabM,$tabDate[0]);
	return $mois." ".$tabDate[1];
}	

function getJour($tab,$y,$m,$j) {
	
	$date = date("N", strtotime("$y-$m-$j"));
	$jour = $tab[$date];
	return substr($jour,0,1);
}


function getNbEmployes($db,$entID) {

	$where = "";
	if ($entID != 0) $where = " AND emp_ent = $entID";

	$resultat = $db->query("SELECT emp_id FROM abs_employe WHERE emp_actif = 1".$where);
	return ($db->numRows($resultat));

}


function getCongesPeriode($db,$congesID) {

	$tabDates = array();

	//on recupere la date debut
	$requeteDebut = $db->query("SELECT conges_date FROM abs_conges WHERE conges_id = $congesID");
	if ($db->numRows($requeteDebut) != 0) $tabDates[0] = $requeteDebut[0]["conges_date"];

	//on recupere la date fin
	$requeteFin = $db->query("SELECT conges_date FROM abs_conges WHERE conges_debut = $congesID ORDER BY conges_id DESC LIMIT 0,1");
	if ($db->numRows($requeteFin) != 0) $tabDates[1] = $requeteFin[0]["conges_date"];
	else $tabDates[1] = $tabDates[0];

	return $tabDates;
}


function getCongesPris($db,$empID, $annee) {

	$nbConges = 0;
	$timestampDebut = mktime(0,0,0,6,1,$annee);	//debut de periode le 1er juin de l'annee
	$timestampFin= mktime(0,0,0,5,31,$annee+1);	//fin de periode le 31 mai de l'anne suivante

	//on ne compte que les CP en journee entiere
	$requeteConges1 = $db->query("SELECT conges_date FROM abs_conges WHERE conges_employe = $empID AND conges_type = 1 AND conges_demijournee = '0'");
	if ($db->numRows($requeteConges1) != 0) {
		for($i = 0; $i < count($requeteConges1); ++$i) {
			list($jour,$mois,$annee) = explode("-",$requeteConges1[$i]["conges_date"]);
			$timestamp = mktime(0,0,0,$mois,$jour,$annee);
			if ($timestamp >= $timestampDebut && $timestamp <= $timestampFin) $nbConges++;
		}
	}

	//on compte les demi journees
	$requeteConges2 = $db->query("SELECT conges_date FROM abs_conges WHERE conges_employe = $empID AND conges_type = 1 AND conges_demijournee != '0'");
	if ($db->numRows($requeteConges2) != 0) {
		for($i = 0; $i < count($requeteConges2); ++$i) {
			list($jour,$mois,$annee) = explode("-",$requeteConges2[$i]["conges_date"]);
			$timestamp = mktime(0,0,0,$mois,$jour,$annee);
			if ($timestamp >= $timestampDebut && $timestamp <= $timestampFin) $nbConges += 0.5;
		}
	}

	return $nbConges;
}


function checkBirthday($db) {

	$employes = array();
	$jour = date("d");
	$mois = date("m");
	
	$requeteBirthday = $db->query("SELECT emp_nom,emp_prenom FROM abs_employe WHERE emp_actif = 1 AND emp_date_naissance LIKE '$jour-$mois-%'");
	if ($db->numRows($requeteBirthday) != 0) {
		for($i = 0; $i < count($requeteBirthday); ++$i) {
			$employes[] = $requeteBirthday[$i]["emp_prenom"]." ".$requeteBirthday[$i]["emp_nom"];
		}
	}

	return $employes;
}


function getListeSecteursUtil($db,$login) {
	
	$tabSecteurs = array();
	$secteurs = $db->query("SELECT droits_sect_id FROM abs_droits_sect WHERE droits_sect_util = '$login'");
	if ($db->numRows($secteurs) > 0) {
		for($i = 0; $i < count($secteurs); ++$i) {
			$tabSecteurs[] = $secteurs[$i]["droits_sect_id"];
		}
	}
	return $tabSecteurs;
}


function getListeVillesUtil($db,$login) {
	
	$tabVilles = array();
	$villes = $db->query("SELECT droits_ent_id FROM abs_droits_ent WHERE droits_ent_util = '$login'");
	if ($db->numRows($villes) > 0) {
		for($i = 0; $i < count($villes); ++$i) {
			$tabVilles[] = $villes[$i]["droits_ent_id"];
		}
	}
	return $tabVilles;
}


function affecteDroitsSecteur($db,$login,$id) {
	
	$db->insert ("abs_droits_sect",
			array(
				"droits_sect_util" =>$login,
				"droits_sect_id" => $id
			)
		);
}


function affecteDroitsVille($db,$login,$id) {
	
	$db->insert ("abs_droits_ent",
			array(
				"droits_ent_util" =>$login,
				"droits_ent_id" => $id
			)
		);
}


function checkDroitsSecteur($db,$login,$id) {

	$droits = $db->query("SELECT droits_sect_id FROM abs_droits_sect WHERE droits_sect_util = '$login' AND droits_sect_id = $id");
	if ($db->numRows($droits) > 0) return true;

	return false;
}


function checkDroitsVille($db,$login,$id) {

	$droits = $db->query("SELECT droits_ent_id FROM abs_droits_ent WHERE droits_ent_util = '$login' AND droits_ent_id = $id");
	if ($db->numRows($droits) > 0) return true;

	return false;
}


function checkPresenceCongesType($db,$id) {

	$conges = $db->query("SELECT type_id FROM abs_type,abs_conges WHERE conges_type = $id");
	if ($db->numRows($conges) > 0) return true;

	return false;
}


function hexaToRVBColors($couleur) {

	$tabCouleur = array();

	$couleur = substr($couleur,1,7);
	$r = substr($couleur,0,2);
	$v = substr($couleur,2,2);
	$b = substr($couleur,4,2);
	$tabCouleur[] = hexdec($r);
	$tabCouleur[] = hexdec($v);
	$tabCouleur[] = hexdec($b);
	
	return $tabCouleur;
}


function checkPresenceSecteur($db,$id) {

	$secteur = $db->query("SELECT emp_id FROM abs_employe WHERE emp_secteur = $id");
	if ($db->numRows($secteur) > 0) return true;

	return false;
}


function checkPresencePeriodicite($db,$id) {

	$periodicite = $db->query("SELECT conges_id FROM abs_conges WHERE conges_periodicite = $id");
	if ($db->numRows($periodicite) > 0) return true;

	return false;
}

function checkPresencePoste($db,$table,$id) {

	if ($table == "categorie") $table = "categorie1";

	$poste = $db->query("SELECT emp_id FROM abs_employe WHERE emp_".$table." = $id");
	if ($db->numRows($poste) > 0) return true;

	return false;
}

?>
