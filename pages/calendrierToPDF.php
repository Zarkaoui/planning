<?php
/**************************************
 Cree le: 24-12-2010
 Derniere modification: 11-07-2011
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

require ("../include/config.php");
require ("../include/db.config.php");
require ("../include/db.class.php");
require("../include/phpToPDF.php");

include ("../include/lang/".LANG.".php");
include ("../include/fonctions.php");


//debug
if (DEBUG) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL & E_NOTICE);
}
//ini_set('max_execution_time','120');
//ini_set('max_input_time','120');
//set_time_limit(120);

// ORANGE - Edgar FERNANDES
// variables sur 3 mois
$year = $_REQUEST['year'];
$type_export = $_REQUEST['type_export'];

/*
if ($size == 3) {
	$month = $_REQUEST['month'];
	$yearCurrent = $year;
	$monthCurrent = $month;

	if ($month == 12) {
        	$moisSuiv = 1;
        	$yearSuiv = $year + 1;
	}
	else {
        	$moisSuiv = $month + 1;
        	$yearSuiv = $year;
	}
	if ($month == 1) {
        	$moisPrec = 12;
        	$yearPrec = $year - 1;
	}
	else {
        	$moisPrec = $month - 1;
        	$yearPrec = $year;
	}
} else
	
}
*/

if ($type_export == "3months") {
	$month = $_REQUEST['month'];
	$min = 1;
	$max = 3;
} else if ($type_export == "semester1") {
	$month = 1;
	$min = 1;
	$max = 6;
} else if ($type_export == "semester2") {
	$month = 7;
	$min = 1;
	$max = 6;
}

// boucle sur 3 mois
//for($a = 0; $a < 3; ++$a) {
//boucle sur 12 mois
//for($m = 1; $m < 13; ++$m) {

for($cpt = $min; $cpt <= $max; ++$cpt) {

/*
if ($m == $monthCurrent) {
                $year = $yearCurrent;
                $month = $monthCurrent;
        } else if ($m == $moisSuiv) {
                $year = $yearSuiv;
                $month = $monthCurrent;
        } else if ($a == 2) {
                $year = $yearSuiv;
                $month = $moisSuiv;
        }
*/

//connexion a la base
$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();


//nettoyage d'un eventuel ancien PDF
try {
        ob_end_clean();
} catch (Exception $e) {}


$where = "";
$sectID = $_REQUEST['sectID'];
$entID = $_REQUEST['entID'];
//$year = $_REQUEST['year'];
//$month = $_REQUEST['month'];
$utilID = $_REQUEST['utilid'];

$date_aux = $year . "-" . $month;
$seeDate = date("Y-m", strtotime($date_aux));
$numDays = monthDays($month, $year);
$titreDate = getSeeDate($tabDay,$tabMonth,$seeDate);
$titreDate = str_replace("&eacute;","é",$titreDate);
$titreDate = str_replace("&ucirc;","û",$titreDate);
$titreDate = str_replace("&egrave;","è",$titreDate);
$titreDate = str_replace("&ecirc;","ê",$titreDate);


$entrepriseNom = "";
$result = $db->query("SELECT ent_nom FROM abs_entreprise WHERE ent_parent = 0");
if ($db->numRows($result) != 0) $entrepriseNom =  $result[0]["ent_nom"];

//on recupere la ville
$entrepriseLieu = "";
if ($entID != "all") {
	$result = $db->query("SELECT ent_ville FROM abs_entreprise WHERE ent_id = $entID");
	if ($db->numRows($result) != 0) $entrepriseLieu =  $result[0]["ent_ville"];

	$where .= " AND emp_ent = $entID";			
}


$secteurNom = LANG_TOUS;
if ($sectID != "all") {
	$result = $db->query("SELECT sect_intitule FROM abs_secteur WHERE sect_id = $sectID");
	if ($db->numRows($result) != 0) $secteurNom =  $result[0]["sect_intitule"];

	$where .= " AND emp_secteur = $sectID";			
}

if ($utilID != "all") $where .= " AND emp_id = $utilID";

/*** Generation des images pour les absences ***/
$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
if ($db->numRows($result) != 0) {
	for($i = 0; $i < count($result); ++$i) {
		$tabRVB = hexaToRVBColors($result[$i]["type_couleur"]);
		$image = imagecreate(20,20);
		imagecolorallocate($image, $tabRVB[0], $tabRVB[1], $tabRVB[2]);
		imagepng($image, "../images/absences/abs-".$result[$i]["type_couleur"].".png");
	}
}


/*********************************/
/**** Debut Generation du PDF ****/
if ($cpt == 1) {
  $PDF=new phpToPDF();
}
$PDF->AddPage("L");
$PDF->SetFont('Arial','B',16);

//Titre
$PDF->Image("../images/companyLogo.jpg",0,5);
$PDF->Text(130,10,utf8_decode(LANG_PDF_TITRE." $entrepriseNom ".$entrepriseLieu));
$PDF->Text(110,20,utf8_decode(LANG_PDF_PERIODE.": ".$titreDate));
$PDF->Text(190,20,utf8_decode(LANG_PDF_SECT.": ".$secteurNom));

//$x = 50;
$x = 42;
$y = 35;
//Calendrier
$requeteEmp = $db->query("SELECT * FROM abs_employe WHERE emp_actif = 1 ".$where." ORDER BY emp_nom ASC");
if ($db->numRows($requeteEmp) != 0) {
	$PDF->SetFont('Arial','',12);
	for($i = 1; $i <= $numDays; $i++) {
		$PDF->Text($x,$y,$i);
		$x += 8;
	}

	//$x = 50;
	$x = 42;
	$y = 40;

	for($i = 1; $i <= $numDays; $i++) {
		$PDF->Text($x,$y,getJour($tabDay,$year,$month,$i));
		$x += 8;
	}

	$y = 47;
	// ORANGE
	$cptDays = 0;
	$cptDaysTotal = 0;
	
	for($k = 0; $k < count($requeteEmp); ++$k) {
		$x = 2;
		$empID = $requeteEmp[$k]["emp_id"];
		$empNom = $requeteEmp[$k]["emp_nom"];
		$empPrenom = $requeteEmp[$k]["emp_prenom"];

		$PDF->Text($x,$y,$empNom." ".$empPrenom[0].".");
		//$x = 49;
		$x = 41;
		$y -= 5;
		for($j = 1; $j <= $numDays; $j++) {
			$day = checkDay($db,$empID, $j, $month, $year);
			if ($day[0] == "ferie") $PDF->Image("../images/absences/ferie.png",$x,$y);
			elseif ($day[0] == "weekend") $PDF->Image("../images/absences/weekend.png",$x,$y);
			elseif ($day[0] == "full") {
				$PDF->Image("../images/absences/abs-".$day[2].".png",$x,$y);
			}
			elseif ($day[0] == "demi_m" || $day[0] == "demi_a") {
				$PDF->Image("../images/absences/abs-".$day[2].".png",$x,$y);
				$y += 5;
				$x += 2;
				if ($day[0] == "demi_m") $PDF->Text($x,$y,"M");
				if ($day[0] == "demi_a") $PDF->Text($x,$y,"A");
				$y -= 5;
				$x -= 2;
				// ORANGE
				$cptDays += 0.5;
			}
			else {	//Present
				$PDF->Image("../images/absences/present.png",$x,$y);
				// ORANGE
				$cptDays += 1;
			}

			$x += 8;
		}
		// ORANGE - Add days count
		$y += 5;
		if ($cptDays < 10) {
                        $x += 4;
		} else {
                	$x += 2;
		}
		$PDF->Text($x,$y,$cptDays);
		$y -= 5;
		if ($cptDays < 10) {
			$x -= 4;
		} else {
                	$x -= 2;
		}
		$cptDaysTotal += $cptDays;
		$cptDays = 0;
		//

		$y += 15;
		//saut de page eventuel
		if ($y >= 200) {
			$PDF->AddPage("L");
			$y = 10;
			//$x = 50;
			$x = 42;
			//reaffichage des numeros jours
			for($d = 1; $d <= $numDays; $d++) {
				$PDF->Text($x,$y,$d);
				$x += 8;
			}

			//$x = 50;
			$x = 42;
			$y = 15;

			for($d = 1; $d <= $numDays; $d++) {
				$PDF->Text($x,$y,getJour($tabDay,$year,$month,$d));
				$x += 8;
			}
			$y = 23;
		}
        }
	// ORANGE
	$PDF->Text($x,$y,$cptDaysTotal);
}
else $PDF->Text($x,$y,utf8_decode(LANG_PDF_NO_EMPL_CRITERES));


//saut de page eventuel
if ($y >= 200) {
	$PDF->AddPage("L");
	$y = 10;
}

/*** Legende ***/
//ligne1: Present - Ferie - WEND - Apres-Midi - Matin
$x = 55;
$PDF->Image("../images/absences/present.png",$x,$y);
$x += 10;
$y += 5;
$PDF->Text($x,$y,utf8_decode(LANG_PDF_PRESENT));
$y -= 5;
$x += 40;

$PDF->Image("../images/absences/ferie.png",$x,$y);
$x += 10;
$y += 5;
$PDF->Text($x,$y,utf8_decode(LANG_PDF_FERIE));
$y -= 5;
$x += 40;

$PDF->Image("../images/absences/weekend.png",$x,$y);
$x += 10;
$y += 5;
$PDF->Text($x,$y,utf8_decode(LANG_PDF_WEEKEND));
$y -= 5;
$x += 40;

$PDF->Image("../images/absences/a.png",$x,$y);
$x += 10;
$y += 5;
$PDF->Text($x,$y,utf8_decode(LANG_PDF_APRESMIDI));
$y -= 5;
$x += 40;

$PDF->Image("../images/absences/m.png",$x,$y);
$x += 10;
$y += 5;
$PDF->Text($x,$y,utf8_decode(LANG_PDF_MATIN));

//Le reste
$x = 55;
$y += 5;

//saut de page eventuel
if ($y >= 200) {
	$PDF->AddPage("L");
	$y = 10;
}

$nbTypes = 0;
$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
if ($db->numRows($result) != 0) {
	$tabCouleurs = array();
	$nbCouleurs = 0;
	for($i = 0; $i < count($result); ++$i) {
		if ($nbTypes == 5) {
			//$x = 55;
			$x = 47;
			$y += 10;
			//saut de page eventuel
			if ($y >= 200) {
				$PDF->AddPage("L");
				$y = 10;
			}
			$nbTypes = 0;
		}
		$PDF->Image("../images/absences/abs-".$result[$i]["type_couleur"].".png",$x,$y);
		$x += 10;
		$y += 5;

		$PDF->Text($x,$y,$result[$i]["type_nom"]);
		$y -= 5;
		$x += 40;

		$nbTypes++;
	}
/*
	//Une case pour une meme couleur avec plusieurs types
	for($i = 0; $i < count($result); ++$i) {
		if ($i == 0) {
			$tabCouleurs[$nbCouleurs]["id"] = $result[$i]["type_id"];
			$tabCouleurs[$nbCouleurs]["nom"] = $result[$i]["type_nom"];
			$tabCouleurs[$nbCouleurs]["couleur"] = $result[$i]["type_couleur"];
			$nbCouleurs++;
		}
		else {
			$couleurPresente = false;
			for($j = 0; $j < count($tabCouleurs); ++$j) {
				if ($tabCouleurs[$j]["couleur"] == $result[$i]["type_couleur"]) {
					$tabCouleurs[$j]["nom"] .= " - ".$result[$i]["type_nom"];
					$couleurPresente = true;
				}									
			}
			if (!$couleurPresente) {
				$tabCouleurs[$nbCouleurs]["id"] = $result[$i]["type_id"];
				$tabCouleurs[$nbCouleurs]["nom"] = $result[$i]["type_nom"];
				$tabCouleurs[$nbCouleurs]["couleur"] = $result[$i]["type_couleur"];
				$nbCouleurs++;
			}
		}
	}
	
	for($i = 0; $i < count($tabCouleurs)-1; ++$i) {
		if ($nbTypes == 5) {
			$x = 70;
			$y += 5;
			//saut de page eventuel
			if ($y >= 200) {
				$PDF->AddPage("L");
				$y = 10;
			}
			$nbTypes = 0;
		}
		$PDF->Image("../images/absences/abs-".$tabCouleurs[$i]["id"].".png",$x,$y);
		$x += 10;
		$y += 5;
		//if (
		$PDF->Text($x,$y,$tabCouleurs[$i]["nom"]);
		$y -= 5;
		$x += 40;

		$nbTypes++;
	}
*/
}
else $PDF->Text($x,$y,utf8_decode(LANG_PDF_NO_TYPES_ABS));

//deconnexion de la base
$db->close();

if ($type_export == "3months") {
        if ($month == 12) {
                $month = 1;
                $year = $year + 1;
        }
        else {
                $month = $month + 1;
                $year = $year;
        }
} else {
        $month = $month + 1;
}
}


//Envoi du PDF
$PDF->Output(LANG_PDF_NOM.".pdf","D");


?>
