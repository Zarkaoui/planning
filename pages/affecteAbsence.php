<?php
/**************************************
 Cree le: 17-12-2010
 Derniere modification: 19-06-2015
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

$message = "";
$couleur = "vert";
$dateJour = date("d")."-".date("m")."-".date("Y");
$comment = "";

if (isset($_SESSION['login'])) {
	if (isset($_REQUEST["ajout"])) {
		if (isset($_REQUEST["comment"])) $comment = $_REQUEST["comment"];
		/**** On a une demi-journee  ****/
		if ($_REQUEST["jourType"] != "0") {
			$date = $_REQUEST['date1'];
			//on test si un conge n'a pas deja ete pris pour cette periode
			if (!checkAbsence($db,$date,$_REQUEST['empID'])) {
				list($jour,$mois,$annee) = explode("-",$date);
				//on verifie si le jour n'est pas ferie
				if (!checkFerie($db,$jour,$mois,$annee)) {
					if ($_REQUEST['jourType'] == "m") $jourType = LANG_MATIN;
					else $jourType = LANG_APRESMIDI;
					//si jour = 6-7 (week-end) on verifie si il travaille le samedi
					$jourNum = date("N", strtotime($date));
					if ($jourNum != 7) {
						if ($jourNum == 6) {
							if (checkSamedi($db,$_REQUEST['empID'])) {
								//ajout du conge
								$insert = $db->insert("abs_conges",
											array(
												"conges_employe" => $_REQUEST["empID"],
												"conges_date" => $date,
												"conges_type" => $_REQUEST["typeID"],
												"conges_demijournee" => $_REQUEST["jourType"],
												"conges_commentaire" => $comment,
												"conges_login_saisie" => $_SESSION["login"],
												"conges_date_saisie" => $dateJour
											)
										);

								if ($insert) $message = LANG_ADD_OK." (".LANG_DEMI_JOURN." $jourType)";
								else $message = LANG_ADD_NOK;
							}
							else {
								$message = LANG_ADD_NOK.", ".LANG_EMP_NOSAMEDI." !";
								$couleur = "rouge";
							}
						}
						else {
							//ajout du conge
							$insert = $db->insert("abs_conges",
										array(
											"conges_employe" => $_REQUEST["empID"],
											"conges_date" => $date,
											"conges_type" => $_REQUEST["typeID"],
											"conges_demijournee" => $_REQUEST["jourType"],
											"conges_commentaire" => $comment,
											"conges_login_saisie" => $_SESSION["login"],
											"conges_date_saisie" => $dateJour
										)
									);

							if ($insert) $message = LANG_ADD_OK." (".LANG_DEMI_JOURN." $jourType)";
							else $message = LANG_ADD_NOK;
						}
					}
					else {
						$message = LANG_ADD_NOK.", ".LANG_EMP_NODIMANCHE;
						$couleur = "rouge";
					}
				}
				else {
					$message = LANG_ADD_NOK.", ".LANG_SEL_FERIE." !";
					$couleur = "rouge";
				}
			}
			else {
				$message = LANG_ADD_NOK.", ".LANG_ABS_PRES." !";
				$couleur = "rouge";
			}				
		}
		else { /***** Journee Entiere *****/
			$dateDebut = $_REQUEST['date1'];
			$dateFin = $_REQUEST['date2'];
			$presenceConges = false;
			$nbJoursEcart = getEcartDates($dateDebut,$dateFin,"jours");
			//pour éviter les doubles tests, on recule la date du jour de 1
			list($jour,$mois,$annee) = explode("-",$dateDebut);
			$date = date("d-m-Y", mktime(0,0,0,date($mois),date($jour)-1,date($annee)));

			//si on a selectionne une seule journee entiere alors qu'un demi conge existe deja a cette date
			if ($nbJoursEcart == 0) {
				if (checkAbsence($db,$dateDebut,$_REQUEST['empID'])) $presenceConges = true;
			}

			//on test si un conge n'a pas deja ete pris pour cette periode
			while($nbJoursEcart > 0) {
				list($jour,$mois,$annee) = explode("-",$date);
				$date = date("d-m-Y", mktime(0,0,0,date($mois),date($jour)+1,date($annee)));
				list($jour,$mois,$annee) = explode("-",$date);
				if (checkAbsence($db,$date,$_REQUEST['empID'])) $presenceConges = true;
				$nbJoursEcart--;				
			}
			if ($presenceConges) {	//si un conge est deja present, on stoppe tout
				$message = LANG_ADD_NOK.", ".LANG_ABS_PRES." !";
				$couleur = "rouge";
			}
			else {
				$nbJoursEcart = getEcartDates($dateDebut,$dateFin,"jours");
				list($jour,$mois,$annee) = explode("-",$dateDebut);
				$date = date("d-m-Y", mktime(0,0,0,date($mois),date($jour)-1,date($annee)));
				$joursPris = 0;
				$recupID = 0;
				//on va inserer les jours 1 par 1
				while($nbJoursEcart >= 0) {
					list($jour,$mois,$annee) = explode("-",$date);
					$date = date("d-m-Y", mktime(0,0,0,date($mois),date($jour)+1,date($annee)));
					list($jour,$mois,$annee) = explode("-",$date);
					//on verifie si le jour n'est pas ferie
					if (!checkFerie($db,$jour,$mois,$annee)) {
						//si jour = 6-7 (week-end) on verifie si il travaille le samedi
						$jourNum = date("N", strtotime($date));
						if ($jourNum != 7) {	//si c'est un dimanche on arrete
							if ($jourNum == 6) {	//si c'est un samedi
								if (checkSamedi($db,$_REQUEST['empID'])) {	//on verifie si l'employe travaille le samedi
									if (DEBUG) echo $date." - SA.<br/>";	/* debug */
									//ajout du conge
									$insert = $db->insert("abs_conges",
												array(
													"conges_employe" => $_REQUEST["empID"],
													"conges_date" => $date,
													"conges_type" => $_REQUEST["typeID"],
													"conges_demijournee" => $_REQUEST["jourType"],
													"conges_debut" => $recupID,
													"conges_commentaire" => $comment,
													"conges_login_saisie" => $_SESSION["login"],
													"conges_date_saisie" => $dateJour
												)
											);

									if ($insert) $joursPris++;								
								}
								//else {
								//	$message = LANG_ADD_NOK.", ".LANG_EMP_NOSAMEDI." !";
								//	$couleur = "rouge";
								//}
							}
							else {	//ce n'est ni un jour ferie, ni un dimanche, ni un samedi, on l'ajoute par defaut
								if (DEBUG) echo $date."<br/>";	/* debug */

								$insert = $db->insert("abs_conges",
											array(
												"conges_employe" => $_REQUEST["empID"],
												"conges_date" => $date,
												"conges_type" => $_REQUEST["typeID"],
												"conges_demijournee" => $_REQUEST["jourType"],
												"conges_debut" => $recupID,
												"conges_commentaire" => $comment,
												"conges_login_saisie" => $_SESSION["login"],
												"conges_date_saisie" => $dateJour
											)
										);

								if ($insert) $joursPris++;
							}
							if ($recupID == 0) $recupID = $db->lastID();
							if (DEBUG) echo "recupID: $recupID<br/>";	
						}
					}
					$nbJoursEcart--;
				}
				if ($joursPris != 0) $message = LANG_ADD_OK." ($joursPris ".LANG_JOURS.")";
#				else {
#					$message = LANG_ADD_NOK;
#					$couleur = "rouge";
#				}
			}
		}

	}

echo "
<script type=\"text/javascript\">
/* <![CDATA[ */

	// Code Javascript pour l'affichage du calendrier de selection des dates 
	DatePickerControl.onSelect = function(inputid) {
		if (inputid == \"date1\"){
			var d1 = document.getElementById(\"date1\");
			var d2 = document.getElementById(\"date2\");
			var d3 = document.getElementById(\"perioDate1\");
			d2.setMinDate(d1.value);
			d2.disabled = false;
			d3.setMinDate(d1.value);
			setTimeout(\"document.getElementById('date2').focus()\", 5);
		}

		if (inputid == \"perioDate1\"){
			var d = document.getElementById(\"date1\");
			var d1 = document.getElementById(\"perioDate1\");
			var d2 = document.getElementById(\"perioDate2\");
			d1.setMinDate(d.value);
			d2.setMinDate(d.value);
			d2.disabled = false;
			setTimeout(\"document.getElementById('perioDate2').focus()\", 5);
		}
	}


	//Fonction de test des dates de saisies d'absence
	function checkDates() {
		var d1 = document.formAbsence.date1.value;
		var d2 = document.formAbsence.date2.value;
		var d3 = document.getElementById(\"date3\");
		
		if ((d1 == d2) && d2 != \"\") d3.style.visibility = \"visible\";
		else d3.style.visibility = \"hidden\";
	}


	function afficheComm(type) {
		var tabComm = new Array;
";
	$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
	if ($db->numRows($result) != 0) {
		for($i = 0; $i < count($result); ++$i) {
			$id = $result[$i]["type_id"];
			if ($result[$i]["type_commentaire"] == 1) {
				echo "tabComm[$id] = true;";
			}
			else echo "tabComm[$id] = false;";
		}
	}

echo "
		if (tabComm[type]) document.getElementById(\"typeComment\").style.visibility = \"visible\";
		else document.getElementById(\"typeComment\").style.visibility = \"hidden\";
	}


	//Verification du formulaire
	function checkForm() {

		var ok = true;
		if (document.formAbsence.empID.value < 1) {
			alert(\"".LANG_ERREUR_SEL_EMP."\");
			ok = false;
		}
		if (document.formAbsence.typeID.value == 0) {
			alert(\"".LANG_ERREUR_SEL_ABS."\");
			ok = false;
		}
		if (document.formAbsence.date1.value == \"\") {
			alert(\"".LANG_ERREUR_SEL_DATE_DEBUT."\");
			ok = false;
		}
		if (document.formAbsence.date2.value == \"\") {
			alert(\"".LANG_ERREUR_SEL_DATE_FIN."\");
			ok = false;
		}
	
		if (ok) document.formAbsence.submit();
	}
/* ]]> */
</script>
";
?>

<div class="width500">
	<div id="status"></div>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
            		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
				<form name="formAbsence" method="post" action="index.php?action=doAbs&amp;ajout">
					<!-- Parametres calendriers -->
					<input type="hidden" id="DPC_TODAY_TEXT" value="<?php echo LANG_AUJOURDHUI; ?>">
					<input type="hidden" id="DPC_BUTTON_TITLE" value="<?php echo LANG_OUVRIR_CAL; ?>">
					<input type="hidden" id="DPC_FIRST_WEEK_DAY" value="1">
			<?php
				$mois = "[";
				for ($i=1;$i<13;$i++) {
					$mois .= "'".$tabMonth[$i]."'";
					if ($i != 12) $mois .= ",";
				}
				$mois .= "]";

				//Must be Sunday first
				$jours = "['".substr($tabDay[7],0,3)."',";
				for ($j=1;$j<7;$j++) {
					$jours .= "'".substr($tabDay[$j],0,3)."'";
					if ($j != 6) $jours .= ",";
				}
				$jours .= "]";
				
			?>
					<input type="hidden" id="DPC_MONTH_NAMES" value="<?php echo $mois; ?>">
					<input type="hidden" id="DPC_DAY_NAMES" value="<?php echo $jours; ?>">
					<br/>
					<table border="0" cellpadding="5" cellspacing="5">
						<tr>
							<th class="txtLeft width200"><?php echo LANG_EMP; ?>: </th>
							<td>
								<select name="empID">
									<option value="0">- <?php echo LANG_SELECT; ?> -</option>
							<?php
									//liste des employes selon le niveau de l'utilisateur
									$result = $db->query("SELECT * FROM abs_employe WHERE emp_actif = 1 ORDER BY emp_nom");
									if ($db->numRows($result) != 0) {
										for($i = 0; $i < count($result); ++$i) {
											if ($_SESSION['admin_general'] == 1) echo "<option value=\"".$result[$i]["emp_id"]."\">".utf8_encode($result[$i]["emp_nom"])." ".utf8_encode($result[$i]["emp_prenom"])."</option>";
											else {
												if (checkDroitsSecteur($db,$_SESSION['login'],$result[$i]["emp_secteur"]) && checkDroitsVille($db,$_SESSION['login'],$result[$i]["emp_ent"])) {
													echo "<option value=\"".$result[$i]["emp_id"]."\">".utf8_encode($result[$i]["emp_nom"])." ".utf8_encode($result[$i]["emp_prenom"])."</option>";
												}
											}
										}											
									}
									else echo "<option value=\"-1\">".LANG_NO_EMP."</option>";
							?>
								</select>
							</td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_TYPE_ABS; ?>: </th>
							<td>
								<select name="typeID" onchange="javascript:afficheComm(this.value);">
									<option value="0">- <?php echo LANG_SELECT; ?> -</option>
						<?php
									$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
									if ($db->numRows($result) != 0) {
										for($i = 0; $i < count($result); ++$i) {
											if ($result[$i]["type_commentaire"] == 1) {
												echo "<option value=\"".$result[$i]["type_id"]."\" >".utf8_encode($result[$i]["type_nom"])."</option>";
											}
											else {
												echo "<option value=\"".$result[$i]["type_id"]."\" >".utf8_encode($result[$i]["type_nom"])."</option>";
											}
										}
									}
									else echo "<option value=\"0\">".LANG_AUCUN."</option>";

						?>
								</select>
							</td>
						</tr>
						<tr id="typeComment" class="txtRight">
							<th class="txtLeft"><?php echo LANG_COMM; ?>: </th>
							<td><textarea name="comment" class="formTextArea" rows="3" cols="30" value=""></textarea></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_DE; ?>: </th>
							<td><input id="date1" name="date1" class="formInputText" maxlength="10" type="text" datepicker="true" datepicker_format="DD-MM-YYYY"/></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_A; ?>: </th>
							<td><input type="text" name="date2" id="date2" class="formInputText" maxlength="10" datepicker="true" datepicker_format="DD-MM-YYYY" disabled="true" onfocus="checkDates();"/></td>
						</tr>
						<tr id="date3" class="txtRight">
							<td colspan="2">
								<input type="radio" name="jourType" value="0" checked />&nbsp;<?php echo LANG_JOURNEE; ?>
								<input type="radio" name="jourType" value="m" />&nbsp;<?php echo LANG_MATIN; ?>
								<input type="radio" name="jourType" value="a" />&nbsp;<?php echo LANG_APRESMIDI; ?>
							</td>
						</tr>
					</table>
					<br/>
				<?php
						if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
				?>
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" onclick="checkForm();" />
						<a href="index.php" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
<!-- Appel a la fonction de test des dates -->
<script type="text/javascript">
	checkDates();
	document.getElementById("typeComment").style.visibility = "hidden";
	document.getElementById("affPerioDate1").style.visibility = "hidden";
	document.getElementById("affPerioDate2").style.visibility = "hidden";
</script>
<?php
}
else echo "<br/>".LANG_NO_ACCES."<br/><br/>";
?>

