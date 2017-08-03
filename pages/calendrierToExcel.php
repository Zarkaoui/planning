<?php
/**************************************
 Cree le: 20-06-2012
 Derniere modification: 11-07-2012
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
require("../include/PHPExcel.php");
require("../include/PHPExcel/Writer/Excel5.php");

include ("../include/lang/".LANG.".php");
include ("../include/fonctions.php");


//debug
if (DEBUG) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL & E_NOTICE);
}

//connexion a la base
$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

/*
//nettoyage d'un eventuel ancien PDF
try {
        ob_end_clean();
} catch (Exception $e) {}
*/

$where = "";
$sectID = $_REQUEST['sectID'];
$entID = $_REQUEST['entID'];
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
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


/*************************************/
/**** Debut Generation du tableur ****/

$tableur = new PHPExcel;

$feuille = $tableur->getActiveSheet();

$feuille->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);


//En tete et titre
$feuille->setCellValue('M2',LANG_PDF_TITRE." ".$entrepriseNom." ".$entrepriseLieu);
$feuille->setCellValue('L4',LANG_PDF_PERIODE.": ".$titreDate);
$feuille->setCellValue('R4',LANG_PDF_SECT.": ".$secteurNom);


$requeteEmp = $db->query("SELECT * FROM abs_employe WHERE emp_actif = 1 ".$where." ORDER BY emp_nom ASC");
if ($db->numRows($requeteEmp) != 0) {
	//Largeur col A
	$feuille->getColumnDimension('A')->setWidth(20);

	$ligne = 7;

	//affichage des numeros de jours
	$col = 1;	//colonne 1, correspond a la lettre B
	for($i = 1; $i <= $numDays; $i++) {
		$feuille->getColumnDimensionByColumn($col)->setWidth(3);
		$feuille->setCellValueByColumnAndRow($col,$ligne,$i);
		$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$col++;
	}

	//affichage 1ere lettre du jour
	$ligne++;
	$col = 1;
	for($i = 1; $i <= $numDays; $i++) {
		$feuille->setCellValueByColumnAndRow($col,$ligne,getJour($tabDay,$year,$month,$i));
		$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$col++;
	}

	//Liste des utilisateurs
	for($k = 0; $k < count($requeteEmp); ++$k) {
		$ligne++;
		$col = 0;
		$empID = $requeteEmp[$k]["emp_id"];
		$empNom = $requeteEmp[$k]["emp_nom"];
		$empPrenom = $requeteEmp[$k]["emp_prenom"];

		$feuille->setCellValueByColumnAndRow($col,$ligne,$empNom." ".$empPrenom[0].".");

		for($j = 1; $j <= $numDays; $j++) {
			$col++;
			$day = checkDay($db,$empID, $j, $month, $year);

			$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			if ($day[0] == "ferie") {
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('0000FF');
			}
			elseif ($day[0] == "weekend") {
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('CECECE');
			}
			elseif ($day[0] == "full") {
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB(substr($day[2],1));
			}
			elseif ($day[0] == "demi_m" || $day[0] == "demi_a") {
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB(substr($day[2],1));

				if ($day[0] == "demi_m") $feuille->setCellValueByColumnAndRow($col,$ligne,"M");
				if ($day[0] == "demi_a") $feuille->setCellValueByColumnAndRow($col,$ligne,"A");
			}
			else {	//Present
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('339933');
			}

		}
	}

	/*** Legende ***/
	$col = 1;
	$ligne += 2;

	//ligne1: Present - Ferie - WEND - Apres-Midi - Matin
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('339933');
	$col++;
	$feuille->setCellValueByColumnAndRow($col,$ligne,LANG_PDF_PRESENT);

	$col += 6;
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('0000FF');
	$col++;
	$feuille->setCellValueByColumnAndRow($col,$ligne,LANG_PDF_FERIE);

	$col += 6;
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB('CECECE');
	$col++;
	$feuille->setCellValueByColumnAndRow($col,$ligne,LANG_PDF_WEEKEND);

	$col += 6;
	$feuille->setCellValueByColumnAndRow($col,$ligne,"A");
	$col++;
	$feuille->setCellValueByColumnAndRow($col,$ligne,LANG_PDF_APRESMIDI);

	$col += 6;
	$feuille->setCellValueByColumnAndRow($col,$ligne,"M");
	$col++;
	$feuille->setCellValueByColumnAndRow($col,$ligne,LANG_PDF_MATIN);

	//Les autres absences
	$col = 1;
	$ligne += 2;

	$nbTypes = 0;
	$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
	if ($db->numRows($result) != 0) {
		for($i = 0; $i < count($result); ++$i) {
			$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$style = $feuille->getStyleByColumnAndRow($col,$ligne)->getFill()->getStartColor()->setRGB(substr($result[$i]["type_couleur"],1));
			$col++;
			$feuille->setCellValueByColumnAndRow($col,$ligne,iconv("ISO-8859-1//TRANSLIT","UTF-8",$result[$i]["type_nom"]));

			$col += 6;
			$nbTypes++;
			
			if ($nbTypes == 5) {	
				$col = 1;
				$ligne += 2;
			}
		}
	}

}
else $feuille->setCellValue('M8',LANG_PDF_NO_EMPL_CRITERES);

$writer = new PHPExcel_Writer_Excel5($tableur);

//$records = "./excel/".LANG_PDF_NOM.".ods";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:inline;filename=".LANG_PDF_NOM.".ods");
$writer->save("php://output");

//$writer->save($records);


?> 
