<?php
/**************************************
 Cree le: 16-12-2010
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

$message = "";
$empID = "";

$empNom = "";
$empPrenom = "";
$empNaiss = "00-00-0000";
$empStatut = "";
$empSamedi = 0;
$empEnt = "";
$empPoste = "";
$empCat1 = "";
$empCat2 = "";
$empSect = "";
$empCongesCours = 0;
$empCongesReport = 0;
$empArr = "00-00-0000";
$empDep = "00-00-0000";
$empActif = 1;



if ($_SESSION['admin_general'] == 1) {

	$afficheForm = true;
	$messageErreur = LANG_ERREUR_CREER_EMPL;

	$resultEnt = $db->query("SELECT ent_id, ent_nom, ent_ville FROM abs_entreprise");
	if ($db->numRows($resultEnt) == 0) {
		$afficheForm = false;
		$messageErreur .= "&nbsp; - &nbsp;".LANG_ENT."<br/>";
	}

	$resultFonct = $db->query("SELECT fonct_id, fonct_nom FROM abs_fonction ORDER BY fonct_nom");
	if ($db->numRows($resultFonct) == 0) {
		$afficheForm = false;
		$messageErreur .= "&nbsp; - &nbsp;".LANG_FONCT."<br/>";
	}

	$resultCat1 = $db->query("SELECT cat_id, cat_nom FROM abs_categorie ORDER BY cat_nom");
	if ($db->numRows($resultCat1) == 0) {
		$afficheForm = false;
		$messageErreur .= "&nbsp; - &nbsp;".LANG_CAT." 1<br/>";
	}

	$resultSect = $db->query("SELECT sect_id, sect_nom FROM abs_secteur ORDER BY sect_nom");
	if ($db->numRows($resultSect) == 0) {
		$afficheForm = false;
		$messageErreur .= "&nbsp; - &nbsp;".LANG_SECT."<br/>";
	}

	$resultCat2 = $db->query("SELECT cat2_id, cat2_nom FROM abs_categorie2 ORDER BY cat2_nom");
	if ($db->numRows($resultCat2) == 0) {
		$afficheForm = false;
		$messageErreur .= "&nbsp; - &nbsp;".LANG_CAT." 2<br/>";
	}

	if ($afficheForm) {



		if (isset($_REQUEST["empID"])) $empID = $_REQUEST["empID"];

		/* Formulaire de modification depuis la liste */
		if (isset($_REQUEST["modif"])) {
			$titrePage = LANG_EMP_MOD;
			$bouton1 = LANG_MODIF;
			$action1 = "modifier";

			$result = $db->query("SELECT * FROM abs_employe WHERE emp_id = $empID");
			if ($db->numRows($result) != 0) {
				$empNom = utf8_decode($result[0]["emp_nom"]);
				$empPrenom = utf8_decode($result[0]["emp_prenom"]);
				$empNaiss = $result[0]["emp_date_naissance"];
				$empStatut = $result[0]["emp_statut"];
				$empSamedi = $result[0]["emp_samedi"];
				$empEnt = $result[0]["emp_ent"];
				$empPoste = $result[0]["emp_fonction"];
				$empCat1 = $result[0]["emp_categorie1"];
				$empCat2 = $result[0]["emp_categorie2"];
				$empSect = $result[0]["emp_secteur"];
				$empCongesCours = $result[0]["emp_nb_conges_cours"];
				$empCongesReport = $result[0]["emp_nb_conges_report"];
				$empArr = $result[0]["emp_arrivee"];
				$empDep = $result[0]["emp_depart"];
				$empActif = $result[0]["emp_actif"];

			}
		}

		/* Modifications dans la base */
		if (isset($_REQUEST["modifier"])) {
			$titrePage = LANG_EMP_MOD;
			$bouton1 = LANG_MODIF;
			$action1 = "modifier";

			$update = $db->update("abs_employe",
						array(
							"emp_nom" => utf8_decode($_REQUEST["empNom"]),
							"emp_prenom" => utf8_decode($_REQUEST["empPrenom"]),
							"emp_date_naissance" => $_REQUEST["empNaiss"],
							"emp_statut" => $_REQUEST["empStatut"],
							"emp_samedi" => $_REQUEST["empSamedi"],
							"emp_ent" => $_REQUEST["empEnt"],
							"emp_fonction" => $_REQUEST["empPoste"],
							"emp_categorie1" => $_REQUEST["empCat1"],
							"emp_categorie2" => $_REQUEST["empCat2"],
							"emp_secteur" => $_REQUEST["empSect"],
							"emp_nb_conges_cours" => $_REQUEST["empCongesCours"],
							"emp_nb_conges_report" => $_REQUEST["empCongesReport"],
							"emp_arrivee" => $_REQUEST["empArr"],
							"emp_depart" => $_REQUEST["empDep"],
							"emp_actif" => $_REQUEST["empActif"]
						),
						"emp_id = $empID");

			if ($update) $message = LANG_MODIFS_OK;
			else $message = LANG_MODIFS_NOK;

			$result = $db->query("SELECT * FROM abs_employe WHERE emp_id = $empID");
			if ($db->numRows($result) > 0) {
				$empNom = utf8_encode($result[0]["emp_nom"]);
				$empPrenom = utf8_encode($result[0]["emp_prenom"]);
				$empNaiss = $result[0]["emp_date_naissance"];
				$empStatut = $result[0]["emp_statut"];
				$empSamedi = $result[0]["emp_samedi"];
				$empEnt = $result[0]["emp_ent"];
				$empPoste = $result[0]["emp_fonction"];
				$empCat1 = $result[0]["emp_categorie1"];
				$empCat2 = $result[0]["emp_categorie2"];
				$empSect = $result[0]["emp_secteur"];
				$empCongesCours = $result[0]["emp_nb_conges_cours"];
				$empCongesReport = $result[0]["emp_nb_conges_report"];
				$empArr = $result[0]["emp_arrivee"];
				$empDep = $result[0]["emp_depart"];
				$empActif = $result[0]["emp_actif"];
			}
		}

		/* Formulaire d'ajout depuis la liste */
		if (isset($_REQUEST["add"])) {
			$titrePage = LANG_EMP_ADD;
			$bouton1 = LANG_ADD;
			$action1 = "ajouter";
		}

		/* Ajout dans la base*/
		if (isset($_REQUEST["ajouter"])) {
			$titrePage = LANG_EMP_ADD;
			$bouton1 = LANG_ADD;
			$action1 = "ajouter";

			$insert = $db->insert("abs_employe",
						array(
							"emp_nom" => utf8_decode($_REQUEST["empNom"]),
							"emp_prenom" => utf8_decode($_REQUEST["empPrenom"]),
							"emp_date_naissance" => $_REQUEST["empNaiss"],
							"emp_statut" => $_REQUEST["empStatut"],
							"emp_samedi" => $_REQUEST["empSamedi"],
							"emp_ent" => $_REQUEST["empEnt"],
							"emp_fonction" => $_REQUEST["empPoste"],
							"emp_categorie1" => $_REQUEST["empCat1"],
							"emp_categorie2" => $_REQUEST["empCat2"],
							"emp_secteur" => $_REQUEST["empSect"],
							"emp_nb_conges_cours" => $_REQUEST["empCongesCours"],
							"emp_nb_conges_report" => $_REQUEST["empCongesReport"],
							"emp_arrivee" => $_REQUEST["empArr"],
							"emp_depart" => $_REQUEST["empDep"],
							"emp_actif" => $_REQUEST["empActif"]
						)
					);

			if ($insert) $message = LANG_ADD_OK;
			else $message = LANG_ADD_NOK;

			$empID = "";
			$empNom = "";
			$empPrenom = "";
			$empNaiss = "00-00-0000";
			$empStatut = "";
			$empSamedi = 0;
			$empEnt = "";
			$empPoste = "";
			$empCat1 = "";
			$empCat2 = "";
			$empSect = "";
			$empCongesCours = 0;
			$empCongesReport = 0;
			$empArr = "00-00-0000";
			$empDep = "00-00-0000";
			$empActif = 1;

		}

	echo "
	<script type=\"text/javascript\">
		function checkForm() {
		
			var ok = true;
			if (document.formEmpl.empNom.value == \"\") {
				alert(\"".LANG_SAISIR_NOMFAM."\");
				ok = false;
			}
			if (document.formEmpl.empPrenom.value == \"\") {
				alert(\"".LANG_SAISIR_PRENOM."\");
				ok = false;
			}
			if (document.formEmpl.empArr.value == \"\") {
				alert(\"".LANG_SAISIR_DATE_ARRIV."\");
				ok = false;
			}
			if (ok) document.formEmpl.submit();
		}
	</script>
	";
	?>

	<div class="width800">
		<div id="status"></div>
		<div class="outerbox">
			<div class="top">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
			<div class="maincontent">
		    		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
					<br/>
					<form name="formEmpl" method="post" action="index.php?action=addEmpl&amp;<?php echo $action1; ?>">
						<table border="0" cellpadding="5" cellspacing="5" class="width100p">
							<tr>
								<th class="txtLeft"><?php echo LANG_NOM_FAM; ?> <span class="required">*</span></th>
								<td><input name="empNom" class="formInputText" maxlength="30" value="<?php echo $empNom; ?>" type="text" /></td>
								<th class="txtLeft"><?php echo LANG_PRENOM; ?> <span class="required">*</span></th>
								<td><input name="empPrenom" class="formInputText" maxlength="30" value="<?php echo $empPrenom; ?>" type="text" /></td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_DATE_NAISS; ?></th>
								<td><input name="empNaiss" class="formInputText" maxlength="10" value="<?php echo $empNaiss; ?>" type="text" onclick="ds_sh(this);" /></td>
								<th class="txtLeft"><?php echo LANG_STATUT; ?></th>
								<td>
									<select name="empStatut" >
								<?php
									$selectPT = "";
									$selectMT = "";
									$selectAP = "";
									$selectST = "";
									if ($empStatut == "pt") $selectPT = "selected=\"selected\"";
									if ($empStatut == "mt") $selectMT = "selected=\"selected\"";
									if ($empStatut == "ap") $selectAP = "selected=\"selected\"";
									if ($empStatut == "st") $selectST = "selected=\"selected\"";
								?>
										<option value="pt" <?php echo $selectPT; ?>><?php echo LANG_PT; ?></option>
										<option value="mt" <?php echo $selectMT; ?>><?php echo LANG_MT; ?></option>
										<option value="ap" <?php echo $selectAP; ?>><?php echo LANG_AP; ?></option>
										<option value="st" <?php echo $selectST; ?>><?php echo LANG_ST; ?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_TRAVALE.$tabDay[6]; ?></th>
								<td>
									<select name="empSamedi" >
								<?php
									if ($empSamedi == 0) {
								?>
										<option value="0" selected="selected"><?php echo LANG_NON; ?></option>
										<option value="1"><?php echo LANG_OUI; ?></option>
								<?php
									}
									else {
								?>
										<option value="0"><?php echo LANG_NON; ?></option>
										<option value="1" selected="selected"><?php echo LANG_OUI; ?></option>
								<?php
									}
								?>
									</select>
								</td>
								<th class="txtLeft"><?php echo LANG_LOCALIS; ?></th>
								<td>
									<select name="empEnt" >
								<?php
									for($i = 0; $i < count($resultEnt); ++$i) {
										if ($resultEnt[$i]["ent_id"] == $empEnt) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$resultEnt[$i]["ent_id"]."\" $selected>".utf8_encode($resultEnt[$i]["ent_nom"])." - ".utf8_encode($resultEnt[$i]["ent_ville"])."</option>";
									}
								?>
									</select>
								</td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_FONCT; ?></th>
								<td>
									<select name="empPoste" >
								<?php
									for($i = 0; $i < count($resultFonct); ++$i) {
										if ($resultFonct[$i]["fonct_id"] == $empPoste) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$resultFonct[$i]["fonct_id"]."\" $selected>".utf8_encode($resultFonct[$i]["fonct_nom"])."</option>";
									}
								?>
									</select>
								</td>
								<th class="txtLeft"><?php echo LANG_CAT; ?> 1</th>
								<td>
									<select name="empCat1" >
								<?php
									for($i = 0; $i < count($resultCat1); ++$i) {
										if ($resultCat1[$i]["cat_id"] == $empCat1) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$resultCat1[$i]["cat_id"]."\" $selected>".utf8_encode($resultCat1[$i]["cat_nom"])."</option>";
									}
								?>
									</select>
								</td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_SECT; ?></th>
								<td>
									<select name="empSect" >
								<?php
									for($i = 0; $i < count($resultSect); ++$i) {
										if ($resultSect[$i]["sect_id"] == $empSect) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$resultSect[$i]["sect_id"]."\" $selected>".utf8_encode($resultSect[$i]["sect_nom"])."</option>";
									}
								?>
									</select>
								</td>
								<th class="txtLeft"><?php echo LANG_CAT; ?> 2</th>
								<td>
									<select name="empCat2" >
								<?php
									for($i = 0; $i < count($resultCat2); ++$i) {
										if ($resultCat2[$i]["cat2_id"] == $empCat2) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$resultCat2[$i]["cat2_id"]."\" $selected>".utf8_encode($resultCat2[$i]["cat2_nom"])."</option>";
									}
								?>
									</select>
								</td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_NB_CONGES_COURS; ?></th>
								<td><input name="empCongesCours" class="formInputText" maxlength="3" value="<?php echo $empCongesCours; ?>" type="text" /></td>
								<th class="txtLeft"><?php echo LANG_NB_CONGES_REPORT; ?></th>
								<td><input name="empCongesReport" class="formInputText" maxlength="3" value="<?php echo $empCongesReport; ?>" type="text" /></td>
							</tr>
							<tr>
								<th class="txtLeft"><?php echo LANG_DATE_ARRIVEE; ?></th>
								<td><input name="empArr" class="formInputText" maxlength="10" value="<?php echo $empArr; ?>" type="text" onclick="ds_sh(this);" /></td>
								<th class="txtLeft"><?php echo LANG_DATE_DEPART; ?></th>
								<td><input name="empDep" class="formInputText" maxlength="10" value="<?php echo $empDep; ?>" type="text" onclick="ds_sh(this);" /></td>
							</tr>
						</table>
						<div align="center">
							<span class="txtCentrer gras"><?php echo LANG_ACTIVE; ?></span>
							<select name="empActif" >
							<?php
								if ($empActif == 1) {
							?>
									<option value="1" selected="selected"><?php echo LANG_OUI; ?></option>
									<option value="0"><?php echo LANG_NON; ?></option>
							<?php
								}
								else {
							?>
									<option value="1"><?php echo LANG_OUI; ?></option>
									<option value="0" selected="selected"><?php echo LANG_NON; ?></option>
							<?php
								}
							?>
							</select>
						</div>
						<br/>
						<?php
							if ($message != "") echo "<div class=\"vert petit\" align=\"center\">$message</div>";
							if (isset($_REQUEST["modif"]) || isset($_REQUEST["modifier"])) echo "<input type=\"hidden\" name=\"empID\" value=\"$empID\" />"; 
						?>
						<div class="formbuttons" align="center">
							<input class="formButton" value="<?php echo $bouton1; ?>" type="button" onclick="javascript:checkForm();" />
							<a href="index.php?action=listEmpl" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
						</div>
					</form>
				</div>
				<div class="bottom">
					<div class="left"></div>
					<div class="right"></div>
					<div class="middle"></div>
				</div>

		</div>
		<div class="requirednotice"><?php echo LANG_ASTERIS; ?></div>
	</div>
<?php
	}
	else {	//Il manque des infos afin de creer un employe
		echo "<br/><br/><span class=\"gras\">$messageErreur</span>";
	}
}
else echo "<br/>".LANG_NO_ACCES."<br/><br/>";
?>


