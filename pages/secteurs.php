<?php
/**************************************
 Cree le: 07-03-2011
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
$couleur = "vert";
$sectNom = "";
$sectIntitule = "";

if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {

if (isset($_REQUEST["add"])) {	//Formulaire d'ajout
	$bouton = LANG_ADD;
	$action = "ajouter";
	if (isset($_REQUEST["modif"])) {	//ou de modification
		$sectID = $_REQUEST["t"];
		$result = $db->query("SELECT * FROM abs_secteur WHERE sect_id = $sectID");
		if ($db->numRows($result) != 0) {
			$sectNom = utf8_encode($result[0]["sect_nom"]);
			$sectIntitule = utf8_encode($result[0]["sect_intitule"]);	
		}
		$bouton = LANG_MODIF;
		$action = "modifier";
	}

echo "
<script type=\"text/javascript\">

	function checkForm() {
		
		var ok = true;
		if (document.formSect.sectNom.value == \"\" && ok) {
			ok = false;
			alert(\"".LANG_SAISIR_NOM."\");
		}

		if (document.formSect.sectIntitule.value == \"\" && ok) {
			ok = false;
			alert(\"".LANG_SAISIR_INTITULE."\");
		}

		if (ok) document.formSect.submit();
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
				<form name="formSect" method="post" action="index.php?action=sect&amp;<?php echo $action; ?>&amp;liste">
					<br/>
					<table class="width95p" border="0">
						<tr>
							<th>&nbsp;<?php echo LANG_NOM; ?></th>
							<td><input type="text" name="sectNom" class="formInputText" value="<?php echo $sectNom; ?>" /></td>
							<th>&nbsp;<?php echo LANG_INTITULE; ?></th>
							<td><input type="text" name="sectIntitule" class="formInputText" value="<?php echo $sectIntitule; ?>" /></td>
						</tr>
					</table>
					<div class="formbuttons" align="center">
		<?php
					if ($action == "modifier") {
						echo "<input type=\"hidden\" name=\"sectID\" value=\"$sectID\" />";
					}
		?>
						<input class="formButton" value="<?php echo $bouton; ?>" type="button" onclick="checkForm();" />
						<a href="index.php?action=sect&amp;liste" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
	$insert = $db->insert("abs_secteur",
				array(
					"sect_nom" => utf8_decode($_REQUEST["sectNom"]),
					"sect_intitule" => utf8_decode($_REQUEST["sectIntitule"]),
				)
			);

	if ($insert) $message = LANG_ADD_OK;
	else {
		$message = LANG_ADD_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["modifier"])) {	//Modifier
	$update = $db->update("abs_secteur",
				array(
					"sect_nom" => utf8_decode($_REQUEST["sectNom"]),
					"type_intitule" => utf8_decode($_REQUEST["sectIntitule"]),
				),
				"sect_id=".$_REQUEST["sectID"]
			);

	if ($update) $message = LANG_MODIFS_OK;
	else {
		$message = LANG_MODIFS_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["suppr"])) {
	//Suppression
	// On verifie avant qu'aucun employe n'est dans ce secteur, sinon suppression impossible
	if (!checkPresenceSecteur($db,$_REQUEST["sectID"])) {
		$delete = $db->delete("abs_secteur","","","sect_id = ".$_REQUEST["sectID"]);
		if ($delete) $message = LANG_SUPPR_OK;
	}
	else {
		$message = LANG_SECT_SUPPR_IMPOSSIBLE;
		$couleur = "rouge";
	}
}


if (isset($_REQUEST["liste"])) {	//liste des secteurs

echo "
<script type=\"text/javascript\">
//<![CDATA[
	function modifier() {
		
		var ok = false;
		var val = 0;
		for(i = 0; i < document.formSect.sectID.length; i++){
			if(document.formSect.sectID[i].checked) {
				val = document.formSect.sectID[i].value;
				ok = true;
			}
		}
		
		if (!ok) alert(\"".LANG_ERREUR_SEL_SECT."\"); 
		else document.location.replace('index.php?action=sect&add&modif&t='+val);
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
				<form name="formSect" method="post" action="index.php?action=sect&amp;suppr&amp;liste">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_secteur ORDER BY sect_id");
					if ($db->numRows($result) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							echo "  <td class=\"width20\"></td>";
						}
						echo "		<td>&nbsp;".LANG_NOM."</td>
								<td>&nbsp;".LANG_INTITULE."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";
							
							echo "	<tr class=\"$color\">";
							if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
								echo "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"sectID\" value=\"".$result[$i]["sect_id"]."\" /></td>";
							}
							echo "		<td>&nbsp;".utf8_encode($result[$i]["sect_nom"])."</td>
									<td>&nbsp;".utf8_encode($result[$i]["sect_intitule"])."</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NO_SECT."<br/></div>";
				?>
					<br/>
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=sect&add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="button" onclick="modifier();" />
						<input class="formButton" value="<?php echo LANG_SUPPR; ?>" type="submit" />
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

