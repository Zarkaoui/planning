<?php
/**************************************
 Cree le: 07-03-2011
 Derniere modification: 06-03-2012
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
$typeNom = "";
$typeCouleur = "#FFFFFF";
$typeComm = "";

if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {

if (isset($_REQUEST["add"])) {	//Formulaire d'ajout
	$bouton = LANG_ADD;
	$action = "ajouter";
	if (isset($_REQUEST["modif"])) {	//ou de modification
		$typeID = $_REQUEST["t"];
		$result = $db->query("SELECT * FROM abs_type WHERE type_id = $typeID");
		if ($db->numRows($result) != 0) {
			$typeNom = utf8_decode($result[0]["type_nom"]);
			$typeCouleur = $result[0]["type_couleur"];
			$typeComm = utf8_decode($result[0]["type_commentaire"]);
		}
		$bouton = LANG_MODIF;
		$action = "modifier";
	}

echo "
<script type=\"text/javascript\">
/* <![CDATA[ */
	function checkCouleur(val) {
		var colors = '^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$';

		if (val.match(colors)) return true;

		return false;
	}
	
	function getCouleur(val) {
		
		if (checkCouleur(val)) document.getElementById(\"affCouleur\").style.backgroundColor = val;
		else document.getElementById(\"affCouleur\").style.backgroundColor = '#FFFFFF';
	}

	function check() {

		if (checkCouleur(document.getElementById(\"typeCouleur\").value)) document.formType.submit();
		else alert(\"".utf8_decode(LANG_ERREUR_COULEUR)."\");
	}
/* ]]> */
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
				<form name="formType" method="post" action="index.php?action=typeAbs&amp;<?php echo $action; ?>&amp;liste">
					<br/>
					<table class="width95p" border="0">
						<tr>
							<td>&nbsp;<?php echo LANG_NOM; ?></td>
							<td>&nbsp;<?php echo LANG_COULEUR; ?> (HTML)</td>
							<td>&nbsp;<?php echo LANG_COULEUR; ?></td>
							<td>&nbsp;<?php echo LANG_COMM; ?></td>
						</tr>
						<tr>
							<td><input type="text" name="typeNom" value="<?php echo $typeNom; ?>" /></td>
							<td><input type="text" name="typeCouleur" id="typeCouleur" value="<?php echo $typeCouleur; ?>" onchange="getCouleur(this.value)" oninput="getCouleur(this.value)" /></td>
							<td id="affCouleur" class="width15p" style="background-color: <?php echo $typeCouleur; ?>;">&nbsp;&nbsp;&nbsp;</td>
							<td>
		<?php						
								if ($typeComm == 1) {
									echo "	<input type=\"radio\" name=\"typeComm\" value=\"1\" checked=\"checked\" />".LANG_OUI."
										<input type=\"radio\" name=\"typeComm\" value=\"0\" />".LANG_NON;
								}
								else {
									echo "	<input type=\"radio\" name=\"typeComm\" value=\"1\" />".LANG_OUI."
										<input type=\"radio\" name=\"typeComm\" value=\"0\" checked=\"checked\" />".LANG_NON;
								}
		?>
							</td>
						</tr>
					</table>
					<div class="formbuttons" align="center">
		<?php
					if ($action == "modifier") {
						echo "<input type=\"hidden\" name=\"typeID\" value=\"$typeID\" />";
					}
		?>
						<input class="formButton" value="<?php echo $bouton; ?>" type="button" onclick="check();" />
						<a href="index.php?action=typeAbs&amp;liste" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
	$insert = $db->insert("abs_type",
				array(
					"type_nom" => utf8_decode($_REQUEST["typeNom"]),
					"type_couleur" => $_REQUEST["typeCouleur"],
					"type_commentaire" => utf8_decode($_REQUEST["typeComm"])
				)
			);

	if ($insert) $message = LANG_ADD_OK;
	else {
		$message = LANG_ADD_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["modifier"])) {	//Modifier
	$update = $db->update("abs_type",
				array(
					"type_nom" => utf8_decode($_REQUEST["typeNom"]),
					"type_couleur" => $_REQUEST["typeCouleur"],
					"type_commentaire" => utf8_decode($_REQUEST["typeComm"])
				),
				"type_id=".$_REQUEST["typeID"]
			);

	if ($update) $message = LANG_MODIFS_OK;
	else {
		$message = LANG_MODIFS_NOK;
		$couleur = "rouge";
	}
}
elseif (isset($_REQUEST["suppr"])) {
	//Suppression
	// On verifie avant qu'aucun conge ne correspond a ce type, sinon suppression impossible
	if (!checkPresenceCongesType($db,$_REQUEST["typeID"])) {
		$delete = $db->delete("abs_type","","","type_id = ".$_REQUEST["typeID"]);
		if ($delete) $message = LANG_SUPPR_OK;
	}
	else {
		$message = LANG_TYPE_SUPPR_IMPOSSIBLE;
		$couleur = "rouge";
	}
}


if (isset($_REQUEST["liste"])) {	//liste des types de conges

echo "
<script type=\"text/javascript\">
/* <![CDATA[ */
	function modifier() {
		
		var ok = false;
		var val = 0;
		for(i = 0; i < document.formType.typeID.length; i++){
			if(document.formType.typeID[i].checked) {
				val = document.formType.typeID[i].value;
				ok = true;
			}
		}
		
		if (!ok) alert(\"".utf8_decode(LANG_ERREUR_SEL_TYPE)."\"); 
		else document.location.replace('index.php?action=typeAbs&add&modif&t='+val);
	}
/* ]]> */
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
				<form name="formType" method="post" action="index.php?action=typeAbs&amp;suppr&amp;liste">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_type ORDER BY type_id");
					if ($db->numRows($result) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							echo "  <td class=\"width20\"></td>";
						}
						echo "		<td>&nbsp;".LANG_NOM."</td>
								<td>&nbsp;".LANG_COULEUR." (HTML)</td>
								<td>&nbsp;".LANG_COULEUR."</td>
								<td>&nbsp;".LANG_COMM."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";

							if ($result[$i]["type_commentaire"] == 1) $typeComm = LANG_OUI;
							else $typeComm = LANG_NON;
							
							echo "	<tr class=\"$color\">";
							if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
								echo "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"typeID\" value=\"".$result[$i]["type_id"]."\" /></td>";
							}
							echo "		<td>&nbsp;".utf8_encode($result[$i]["type_nom"])."</td>
									<td>&nbsp;".$result[$i]["type_couleur"]."</td>
									<td style=\"background-color:".$result[$i]["type_couleur"].";\" class=\"width15p\" >&nbsp;&nbsp;&nbsp;</td>
									<td>&nbsp;".utf8_encode($typeComm)."</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NO_TYPES_ABS."<br/></div>";
				?>
					<br/>
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=typeAbs&amp;add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
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

