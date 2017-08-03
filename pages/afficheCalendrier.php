<?php
/**************************************
 Cree le: 14-12-2010
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


$sectID = "all";
$entID = "all";
$utilID = "all";
$where = "";
$contenuPage = "";

if (isset($_REQUEST['sectID']) && $_REQUEST["sectID"] != "all" && $_REQUEST["sectID"] != "") {
	$sectID = $_REQUEST['sectID'];
	$where .= " AND emp_secteur = $sectID";
}

if (isset($_REQUEST['entID']) && $_REQUEST["entID"] != "all" && $_REQUEST["entID"] != "") {
	$entID = $_REQUEST['entID'];
	$where .= " AND emp_ent = $entID";
}

//autocompletion
if (isset($_REQUEST["utilid"]) && $_REQUEST["utilid"] != "all" && $_REQUEST["utilid"] != "") {
	$utilID = $_REQUEST["utilid"];
	$where .= " AND emp_id = $utilID";		
}

//Year
if (isset($_REQUEST['year']))
	$year = $_REQUEST['year'];
else
	$year = date("Y");

//Month
if (isset($_REQUEST['month']))
	$month = $_REQUEST['month'];
else
	$month = date("m");

$date_aux = $year . "-" . $month;
$seeDate = date("Y-m", strtotime($date_aux));	


$numDays = monthDays($month, $year);
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

?>


<script type="text/javascript">
/* <![CDATA[ */
	/** Javascript pour info bulle a l'affichage du calendrier **/
	sfHover = function() {
		var sfEls = document.getElementById("menu").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+="sfhover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp("sfhover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);



	function GetId(id) {
		return document.getElementById(id);
	}

	var i=false;

	function move(e) {
		if(i) {
			if (navigator.appName!="Microsoft Internet Explorer") {
				GetId("curseur").style.left=e.pageX + 5+"px";
				GetId("curseur").style.top=e.pageY + 10+"px";
			}
			else {
				if(document.documentElement.clientWidth>0) {
					GetId("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
					GetId("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
				}
				else {
					GetId("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
					GetId("curseur").style.top=10+event.y+document.body.scrollTop+"px";
				}
			}
		}
	}

	function montre(text) {
		if(i==false) {
			GetId("curseur").style.visibility="visible";
			GetId("curseur").innerHTML = text;
			i=true;
		}
	}

	function cache() {
		if(i==true) {
			GetId("curseur").style.visibility="hidden";
			i=false;
		}
	}
	document.onmousemove=move;
	/** FIN infobulle **/

	function cacheChargement() {
		document.getElementById('chargement').style.display = 'none';
	}
/* ]]> */ 
</script>
<!-- Info Bulle -->
<div id="curseur" class="infobulle"></div>
<div class="width100p">
	<div id="status"></div>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
            		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
  <div id="sort" style="padding-right: 10%">
      <div align="center">

	<div align="center" id="chargement">
		<br/><br/>
		<img src="images/loading.gif" alt="<?php echo LANG_CHARGEMENT; ?>" />
	</div>
<?php
//rafraichissement pour afficher le debut de la page
flush(); ob_flush(); flush(); ob_flush();

	//Affichage de la date et des fleches de navigation en titre
	$contenuPage .= "
	<h2>
		<a href=\"index.php?action=affCal&amp;year=".$yearPrec."&amp;month=".$moisPrec."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."\" class=\"lienNoDeco\">&lt;</a>
			&nbsp;&nbsp;&nbsp;".getSeeDate($tabDay,$tabMonth,$seeDate)."&nbsp;&nbsp;&nbsp;
		<a href=\"index.php?action=affCal&amp;year=".$yearSuiv."&amp;month=".$moisSuiv."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."\" class=\"lienNoDeco\">></a>
	</h2>

	<span class=\"petit\"><br/></span>
	";


	//autocompletion liste employes
	$contenuPage .= "
		<input autocomplete=\"off\" id=\"champ_util\" name=\"champ_util\" type=\"text\" class=\"autocompleteInput\" value=\"".LANG_EMP."\" onclick=\"this.value='';\"/>
		<div class=\"update\" id=\"util_update\"></div> &nbsp;&nbsp;&nbsp;
	";
		
		//Affichage des listes de selection pour le tri

		$contenuPage .= LANG_SECT. ":

	      <select name=\"sectID\" onchange=\"window.location.href='index.php?action=affCal&amp;year=".$year."&amp;month=".$month."&amp;sectID='+this.options[this.selectedIndex].value+'&amp;entID=".$entID."'\">
			<option value=\"all\">- ".LANG_SELECT." -</option>
		";

				$result = $db->query("SELECT * FROM abs_secteur ORDER BY sect_nom");
				if ($db->numRows($result) != 0) {
					for($i = 0; $i < count($result); ++$i) {
						$selected = "";
						if ($sectID == $result[$i]["sect_id"]) $selected = "selected";
						$contenuPage .= "<option value=\"".$result[$i]["sect_id"]."\" $selected>".utf8_encode($result[$i]["sect_nom"])." (".utf8_encode($result[$i]["sect_intitule"]).")</option>";
					}
				}
	$contenuPage .= "			
	      </select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		".LANG_LOCALIS. ":
		 <select name=\"entID\" onchange=\"window.location.href='index.php?action=affCal&amp;year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID='+this.options[this.selectedIndex].value\">
			<option value=\"all\">- ".LANG_SELECT." -</option>
		";
				$result = $db->query("SELECT * FROM abs_entreprise ORDER BY ent_ville");
				if ($db->numRows($result) != 0) {
					for($i = 0; $i < count($result); ++$i) {
						$selected = "";
						if ($entID == $result[$i]["ent_id"]) $selected = "selected";
						$contenuPage .= "<option value=\"".$result[$i]["ent_id"]."\" $selected>".utf8_encode($result[$i]["ent_ville"])."</option>";
					}
				}
	$contenuPage .= "
	      </select>	

	
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

     		".LANG_MOIS. ":
		<select name=\"listMonth\" onchange=\"window.location.href='index.php?action=affCal&amp;year=".$year."&amp;month='+this.options[this.selectedIndex].value+'&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."'\">
	";
			$curr_month = $month;
		
			foreach ($tabMonth as $key => $val) {
				if ($key == $curr_month) $contenuPage .= "\t<option value=\"$key\" selected=\"selected\">$val</option>";
				else $contenuPage .= "\t<option value=\"$key\" >$val</option>";
			}
	$contenuPage .= "
     		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	     	".LANG_ANNEE. ":
	      <select name=\"listYear\" onchange=\"window.location.href='index.php?action=affCal&amp;year='+this.options[this.selectedIndex].value+'&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."'\">
	";
				if ((date("Y")-FIRST_YEAR) < 6) $debut = FIRST_YEAR;
				else $debut = date("Y")-5;
				
				for ($i=$debut;$i<$debut+6;$i++) {
					if ($i == $year) $contenuPage .= "\t<option value=\"$i\" selected=\"selected\">$i</option>";
					else $contenuPage .= "\t<option value=\"$i\">$i</option>";

				}
	$contenuPage .= "
	      </select>

</div>
	<br/><br/>
<div id=\"tabConges\">
<table class=\"width95p\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
	";

		$resultEmpl = $db->query("SELECT * FROM abs_employe WHERE emp_actif = 1 ".$where." ORDER BY emp_nom ASC");
		if ($db->numRows($resultEmpl) != 0) {
		//si on a des employes qui correspondent, on affiche l'en-tete du calendrier (numero et initiale des jours)
	
	$contenuPage .= "
			<tr>
				<td >&nbsp;</td>
	";

				for($i = 1; $i <= $numDays; $i++) {
					 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".$i."</div></td>";
				}
	$contenuPage .= "
			</tr>
			<tr>
				<td >&nbsp;</td>
	";

				for($i = 1; $i <= $numDays; $i++) {

					 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".getJour($tabDay,$year,$month,$i)."</div></td>";
				}
	$contenuPage .= "
			</tr>
	";

			$even = 1;
			$cptDaysTotal = 0;
			//On affiche une ligne par employe
			for($j = 0; $j < count($resultEmpl); ++$j) {
				$empID = $resultEmpl[$j]["emp_id"];
				$empNom = utf8_encode($resultEmpl[$j]["emp_nom"]);
				$empPrenom = utf8_encode($resultEmpl[$j]["emp_prenom"]);
				$nomPrenom = $empNom." ".$empPrenom;
/*
				//repeter les numeros de jours toutes les 20 lignes
				if ($even%20 == 0) {
			$contenuPage .= "
					<tr>
						<td >&nbsp;</td>
			";
						for($d = 1; $d <= $numDays; $d++) {

							 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".$d."</div></td>";
						}
			$contenuPage .= "
					</tr>
					<tr>
						<td >&nbsp;</td>
			";
						for($d = 1; $d <= $numDays; $d++) {
							 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".getJour($tabDay,$year,$month,$d)."</div></td>";
						}
			$contenuPage .= "
					</tr>
			";
				}
*/
				if (strlen($nomPrenom) >= 20) $nomPrenom = $empNom." ".$empPrenom[0].".";
			
				$contenuPage .= "<tr>
					<td class=\"width100\">
						<div align=\"right\" class=\"horizCentrer\">						
							$nomPrenom  &nbsp;
							<a href=\"index.php?action=fichEmpl&amp;empID=$empID\" ><img src=\"images/menu/icons/ficheEmpl.png\" onmouseover=\"montre('".LANG_FICHE."');\" onmouseout=\"cache();\" alt=\"Fiche\" /></a>&nbsp;
						</div>
					</td>";

			
				$even++;
				$cptDays = 0;

				for($i = 1; $i <= $numDays; $i++) {
			
					$day = checkDay($db,$empID, $i, $month, $year);

					//$day[0] = 'default';
					
					switch($day[0]) {
						case 'default':
							$contenuPage .= " <td class=\"present\" ></td>";
							$cptDays += 1;
							break;				
						case 'weekend':
							$contenuPage .= " <td class=\"weekend\" ></td>";
							break;
						case 'full':
							if ($day[3] != "") $txtBulle = $day[1].": ".$day[3];
							else $txtBulle = $day[1];
							$txtBulle = utf8_encode($txtBulle);
							$contenuPage .= " <td style=\"background-color:".$day[2].";\" onmouseover=\"montre('$txtBulle');\" onmouseout=\"cache();\"></td>";
							break;
						case 'demi_m':
							if ($day[3] != "") $txtBulle = $day[1].": ".$day[3];
							else $txtBulle = $day[1];
							$txtBulle = utf8_encode($txtBulle);
							$contenuPage .= " <td style=\"background-color:".$day[2].";\" onmouseover=\"montre('$txtBulle');\" onmouseout=\"cache();\" align=\"center\">M</td>";
							$cptDays += 0.5;
							break;
						case 'demi_a':
							if ($day[3] != "") $txtBulle = $day[1].": ".$day[3];
							else $txtBulle = $day[1];
							$txtBulle = utf8_encode($txtBulle);
							$contenuPage .= " <td style=\"background-color:".$day[2].";\" onmouseover=\"montre('$txtBulle');\" onmouseout=\"cache();\" align=\"center\">A</td>";
							$cptDays += 0.5;
							break;
						case 'ferie':
							$contenuPage .= " <td class=\"ferie\" onmouseover=\"montre('".utf8_encode($day[1])."');\" onmouseout=\"cache();\"></td>";
							break;
						default:
							$contenuPage .= " <td class=\"present\" ></td>";
							$cptDays += 1;
							break;				
					}
				}
				
				// *******************
				// Feature Toggle & Dark Launch
				if ((($feature_toggle == "enabled") || ($dark_launch == "enabled")) && ($feature_countdays == "enabled")) {
					$contenuPage .= "<td style='width:10px'>&nbsp;$cptDays</td></tr>";
					$cptDaysTotal += $cptDays;
					$cptDays = 0;
				}
				// *******************
			}
			$contenuPage .= "<tr><td></td>";
			for($i = 1; $i <= $numDays; $i++) {
				$contenuPage .= "<td></td>";
			}
			
			// *******************
			// Feature toggle & Dark Launch
			if ((($feature_toggle == "enabled") || ($dark_launch == "enabled")) && ($feature_countdays == "enabled")) {
				$contenuPage .= "<td style='width:10px'><font color='red'>&nbsp;$cptDaysTotal</font></td>";
			}
			// *******************

			$contenuPage .= "</tr>";

				//on ajoute les nums jours a la fin si au moins 20 lignes
				if ($even >= 20) {
	$contenuPage .= "
					<tr>
						<td >&nbsp;</td>
	";
						for($d = 1; $d <= $numDays; $d++) {
							 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".$d."</div></td>";
						}
	$contenuPage .= "
					</tr>
					<tr>
						<td >&nbsp;</td>
	";
						for($d = 1; $d <= $numDays; $d++) {
							 $contenuPage .= "<td class=\"width12\"><div class=\"txtCentrer gras joursCal\">".getJour($tabDay,$year,$month,$d)."</div></td>";
						}
	$contenuPage .= "
					</tr>
	";
				}
		}
		else {	//si pas d'employe qui correspondent, on affiche un message
			$contenuPage .= "<tr><td align=\"center\" class=\"gras\">".LANG_NO_EMPL_CRITERES."</td></tr>";
		}
		
	$contenuPage .= "
	
			</table>
			</div>	
			<br/><br/>
			<div align=\"center\">
				<!-- Affichage de la légende -->
				<table class=\"width800\" border=\"0\" cellspacing=\"5\" cellpadding=\"2\">
					<tr>
					   	<td class=\"present width20\">&nbsp;</td>
					    	<td class=\"width150\"><div align=\"left\" class=\"style2\">".LANG_PRESENT."</div></td>
						<td class=\"ferie\">&nbsp;</td>
						<td><div align=\"left\" class=\"style2\">".LANG_FERIE."</div></td>
						<td class=\"weekend width20\">&nbsp;</td>
						<td class=\"width150\"><div align=\"left\" class=\"style2\">".LANG_WEEKEND."</div></td>
						<td><div align=\"center\">A</div></td>
						<td><span class=\"style2\">".LANG_ABS_PARTIELLE." (".LANG_APRESMIDI.") </span></td>
						<td class=\"width20 border\"><div align=\"center\">M</div></td>
						<td class=\"width150\"><div align=\"left\" class=\"style2\">".LANG_ABS_PARTIELLE." (".LANG_MATIN.") </div></td>
					</tr>
					<tr>
	";

					$nbTypes = 0;
					$resultAbs = $db->query("SELECT * FROM abs_type ORDER BY type_id");
					if ($db->numRows($resultAbs) != 0) {
						$tabCouleurs = array();
						$nbCouleurs = 0;
						for($i = 0; $i < count($resultAbs); ++$i) {
							if ($i == 0) {
								$tabCouleurs[$nbCouleurs]["nom"] = $resultAbs[$i]["type_nom"];
								$tabCouleurs[$nbCouleurs]["couleur"] = $resultAbs[$i]["type_couleur"];
								$nbCouleurs++;
							}
							else {
								$couleurPresente = false;
								for($j = 0; $j < count($tabCouleurs); ++$j) {
									if ($tabCouleurs[$j]["couleur"] == $resultAbs[$i]["type_couleur"]) {
										$tabCouleurs[$j]["nom"] .= " - ".$resultAbs[$i]["type_nom"];
										$couleurPresente = true;
									}									
								}
								if (!$couleurPresente) {
									$tabCouleurs[$nbCouleurs]["nom"] = $resultAbs[$i]["type_nom"];
									$tabCouleurs[$nbCouleurs]["couleur"] = $resultAbs[$i]["type_couleur"];
									$nbCouleurs++;
								}
							}
						}
						
						for($i = 0; $i < count($tabCouleurs); ++$i) {
							if ($nbTypes == 5) {
								$contenuPage .= "  </tr>
									<tr>";
								$nbTypes = 0;
							}
							$contenuPage .= "
								<td style=\"background-color:".$tabCouleurs[$i]["couleur"].";\" class=\"width20\">&nbsp;</td>
								<td class=\"width150\"><div align=\"left\" class=\"style2\">".utf8_encode($tabCouleurs[$i]["nom"])."</div></td>
							";
							$nbTypes++;
						}
						$contenuPage .= "</tr>";

					}
					else {
						$contenuPage .= "<td>".LANG_NO_TYPES_ABS."</td></tr>";
					}
	$contenuPage .= "
				</table>
	";
			//Affichage du lien de generation PDF
			if (EXPORT_PDF) {
	$contenuPage .= "
			<br/><br/>			
			<div align=\"center\">
				<table border=\"0\">
					<tr>
						<td align=\"left\">
							<a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=3months\" class=\"lienNoDeco\">
								<img src=\"images/pdf.png\" alt=\"PDF\" />
							</a>
						</td>
						<td align=\"left\">
							<a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=3months\" class=\"lienNoDeco\">
								".LANG_EXPORT_PDF." (3 mois)
							</a>
						</td>
					</tr>
                                        <tr>
                                                <td align=\"left\">
                                                        <a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=semester1\" class=\"lienNoDeco\">
                                                                <img src=\"images/pdf.png\" alt=\"PDF\" />
                                                        </a>
                                                </td>
                                                <td align=\"left\">
                                                        <a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=semester1\" class=\"lienNoDeco\">
                                                                ".LANG_EXPORT_PDF." (1er semestre)
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align=\"left\">
                                                        <a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=semester2\" class=\"lienNoDeco\">
                                                                <img src=\"images/pdf.png\" alt=\"PDF\" />
                                                        </a>
                                                </td>
                                                <td align=\"left\">
                                                        <a href=\"pages/calendrierToPDF.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."&amp;type_export=semester2\" class=\"lienNoDeco\">
                                                                ".LANG_EXPORT_PDF." (2eme semestre)
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
			</div>
	";

			}

			//Affichage du lien de generation Excel
			/*
			if (EXPORT_EXCEL) {
	$contenuPage .= "
			<br/>			
			<div align=\"center\">
				<table border=\"0\">
					<tr>
						<td align=\"left\">
							<a href=\"pages/calendrierToExcel.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."\" class=\"lienNoDeco\">
								<img src=\"images/excel.png\" alt=\"Excel\" />
							</a>
						</td>
						<td align=\"left\">
							<a href=\"pages/calendrierToExcel.php?year=".$year."&amp;month=".$month."&amp;sectID=".$sectID."&amp;entID=".$entID."&amp;utilid=".$utilID."\" class=\"lienNoDeco\">
								".LANG_EXPORT_EXCEL." (1 mois)
							</a>
						</td>
					</tr>
				</table>
			</div>
	";

			}
			*/
?>
		<!-- On efface l'image de chargement -->
		<script type="text/javascript">cacheChargement();</script>

<?php
		echo $contenuPage;

		echo "
			<script type=\"text/javascript\">
				// <![CDATA[
				new Ajax.Autocompleter ('champ_util',
					'util_update',
					'pages/afficheCalendrierAjax.php?year=$year&month=$month&sectID=$sectID&entID=$entID',
					{
						method: 'post',
						paramName: 'champ_util',
						minChars: 2
					});
				//]]>
			</script>
		";
?>

			<br/>

			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
		</div>
	</div>
</div></div></div>
