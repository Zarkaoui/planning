<?php
/**************************************
 Cree le: 05-03-2012
 Derniere modification: 08-11-2012
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
$couleur = "vert";
$periodiciteIntitule = "";
$periodiciteJours = "";

if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {

if (isset($_REQUEST["add"])) {	//Formulaire d'ajout
	$bouton = LANG_ADD;
	$action = "ajouter";
	if (isset($_REQUEST["modif"])) {	//ou de modification
		$periodiciteID = $_REQUEST["t"];
		$result = $db->query("SELECT * FROM abs_periodicite WHERE periodicite_id = $periodiciteID");
		if ($db->numRows($result) != 0) {
			$periodiciteIntitule = utf8_encode($result[0]["periodicite_libelle"]);
			$periodiciteJours = $result[0]["periodicite_jours"];	
		}
		$bouton = LANG_MODIF;
		$action = "modifier";
	}

echo "
<script type=\"text/javascript\">

	function checkForm() {
		
		var ok = true;
		if (document.formPerio.periodiciteIntitule.value == \"\" && ok) {
			ok = false;
			alert(\"".LANG_SAISIR_NOM."\");
		}

		if (document.formPerio.periodiciteJours.value == \"\" && ok) {
			ok = false;
			alert(\"".LANG_SAISIR_JOURS."\");
		}

		if (ok) document.formPerio.submit();
	}
</script>
";
?>
<div class="width700">
	<div id="status"></div>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
            		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
				<form name="formPerio" method="post" action="index.php?action=periodicite&amp;<?php echo $action; ?>&amp;liste">
					<br/>
					<table class="width95p" border="0">
						<tr>
							<th>&nbsp;<?php echo LANG_NOM; ?></th>
							<td><input type="text" name="periodiciteIntitule" class="formInputText" value="<?php echo $periodiciteIntitule; ?>" /></td>
							<th>&nbsp;<?php echo ucfirst(LANG_JOURS); ?></th>
							<td><input type="text" name="periodiciteJours" class="formInputText" value="<?php echo $periodiciteJours; ?>" /></td>
						</tr>
					</table>
					<div class="formbuttons" align="center">
		<?php
					if ($action == "modifier") {
						echo "<input type=\"hidden\" name=\"periodiciteID\" value=\"$periodiciteID\" />";
					}
		?>
						<input class="formButton" value="<?php echo $bouton; ?>" type="button" onclick="checkForm();" />
						<a href="index.php?action=periodicite&amp;liste" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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

<?php
}
elseif (isset($_REQUEST["ajouter"])) {	//Ajout
	$insert = $db->insert("abs_periodicite",
				array(
					"periodicite_libelle" => utf8_decode($_REQUEST["periodiciteIntitule"]),
					"periodicite_jours" => $_REQUEST["periodiciteJours"],
				)
			);

	if ($insert) $message = LANG_ADD_OK;
	else {
		$message = LANG_ADD_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["modifier"])) {	//Modifier
	$update = $db->update("abs_periodicite",
				array(
					"periodicite_libelle" => utf8_decode($_REQUEST["periodiciteIntitule"]),
					"periodicite_jours" => $_REQUEST["periodiciteJours"],
				),
				"periodicite_id=".$_REQUEST["periodiciteID"]
			);

	if ($update) $message = LANG_MODIFS_OK;
	else {
		$message = LANG_MODIFS_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["suppr"])) {//Suppression
	// On verifie avant qu'aucun employe n'a de conges dans cette periodicite, sinon suppression impossible
	if (!checkPresencePeriodicite($db,$_REQUEST["periodiciteID"])) {
		$delete = $db->delete("abs_periodicite","","","periodicite_id = ".$_REQUEST["periodiciteID"]);
		if ($delete) $message = LANG_SUPPR_OK;
	}
	else {
		$message = LANG_PERIO_SUPPR_IMPOSSIBLE;
		$couleur = "rouge";
	}
}


if (isset($_REQUEST["liste"])) {	//liste des periodicites

echo "
<script type=\"text/javascript\">
//<![CDATA[
	function modifier() {
		
		var ok = false;
		var val = 0;
		for(i = 0; i < document.formPerio.periodiciteID.length; i++){
			if(document.formPerio.periodiciteID[i].checked) {
				val = document.formPerio.periodiciteID[i].value;
				ok = true;
			}
		}
		
		if (!ok) alert(\"".LANG_ERREUR_SEL_PERIO."\"); 
		else document.location.replace('index.php?action=periodicite&add&modif&t='+val);
	}
//]]>
</script>
";

?>

<div class="width700">
	<div id="status"></div>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
            		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
				<form name="formPerio" method="post" action="index.php?action=periodicite&amp;suppr&amp;liste">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_periodicite ORDER BY periodicite_id");
					if ($db->numRows($result) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							echo "  <td class=\"width20\"></td>";
						}
						echo "		<td>&nbsp;".LANG_NOM."</td>
								<td>&nbsp;".ucfirst(LANG_JOURS)."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";
							
							echo "	<tr class=\"$color\">";
							if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
								echo "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"periodiciteID\" value=\"".$result[$i]["periodicite_id"]."\" /></td>";
							}
							echo "		<td>&nbsp;".utf8_encode($result[$i]["periodicite_libelle"])."</td>
									<td>&nbsp;".$result[$i]["periodicite_jours"]."</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NO_PERIO."<br/></div>";
				?>
					<br/>
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=periodicite&add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="button" onclick="modifier();" />
				<?php
					if ($db->numRows($result) != 1) {	//MUST have one at least
				?>
						<input class="formButton" value="<?php echo LANG_SUPPR; ?>" type="submit" />
				<?php
					}
				?>
					</div>
				<?php
					}
				?>
				</form>
			</div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
	</div>
</div>
<?php
	}	
}
else echo "<br/>".LANG_NO_ACCES."<br/><br/>";
?>

