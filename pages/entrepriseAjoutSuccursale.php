<?php
/**************************************
 Cree le: 14-12-2010
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

$nbEmployes = 0;
$entID = 0;
$message = "";

$entNom = "";
$entAddr1 = "";
$entAddr2 = "";
$entCP = "";
$entVille = "";
$entTel = "";
$entFax = "";

if (isset($_REQUEST["entID"])) $entID = $_REQUEST["entID"];

	/* Formulaire de modification depuis la liste */
	if (isset($_REQUEST["modif"])) {
		$titrePage = LANG_SUCC_MODIF;
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";
		
		$result = $db->query("SELECT * FROM abs_entreprise WHERE ent_id = $entID");
		if ($db->numRows($result) > 0) {
			$entNom = utf8_encode($result[0]["ent_nom"]);
			$entAddr1 = utf8_encode($result[0]["ent_addr1"]);
			$entAddr2 = utf8_encode($result[0]["ent_addr2"]);
			$entCP = $result[0]["ent_cp"];
			$entVille = utf8_encode($result[0]["ent_ville"]);
			$entTel = $result[0]["ent_tel"];
			$entFax = $result[0]["ent_fax"];
			
			$nbEmployes = getNbEmployes($db,$entID);
		}
	}

	/* Modifications dans la base */
	if (isset($_REQUEST["modifier"])) {
		$titrePage = LANG_SUCC_MODIF;
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";

		$update = $db->update("abs_entreprise",
					array(
						"ent_nom" => utf8_decode($_REQUEST["entNom"]),
						"ent_addr1" => utf8_decode($_REQUEST["entAddr1"]),
						"ent_addr2" => utf8_decode($_REQUEST["entAddr2"]),
						"ent_CP" => $_REQUEST["entCP"],
						"ent_ville" => utf8_decode($_REQUEST["entVille"]),
						"ent_tel" => $_REQUEST["entTel"],
						"ent_fax" => $_REQUEST["entFax"]
					),
					"ent_id = $entID");


		if ($update) $message = LANG_MODIFS_OK;
		else $message = LANG_MODIFS_NOK;

		$result = $db->query("SELECT * FROM abs_entreprise WHERE ent_id = $entID");
		if ($db->numRows($result) > 0) {
			$entNom = utf8_encode($result[0]["ent_nom"]);
			$entAddr1 = utf8_encode($result[0]["ent_addr1"]);
			$entAddr2 = utf8_encode($result[0]["ent_addr2"]);
			$entCP = $result[0]["ent_cp"];
			$entVille = utf8_encode($result[0]["ent_ville"]);
			$entTel = $result[0]["ent_tel"];
			$entFax = $result[0]["ent_fax"];
			
			$nbEmployes = getNbEmployes($db,$entID);
		}
	}

	/* Formulaire d'ajout depuis la liste */
	if (isset($_REQUEST["add"])) {
		$titrePage = LANG_SUCC_ADD;
		$bouton1 = LANG_ADD;
		$action1 = "ajouter";
	}

	/* Ajout dans la base*/
	if (isset($_REQUEST["ajouter"])) {
		$titrePage = LANG_SUCC_ADD;
		$bouton1 = LANG_ADD;
		$action1 = "modifier";

		$entNom = utf8_decode($_REQUEST["entNom"]);
		$entAddr1 = utf8_decode($_REQUEST["entAddr1"]);
		$entAddr2 = utf8_decode($_REQUEST["entAddr2"]);
		$entCP = $_REQUEST["entCP"];
		$entVille = utf8_decode($_REQUEST["entVille"]);
		$entTel = $_REQUEST["entTel"];
		$entFax = $_REQUEST["entFax"];

		$result = $db->query("SELECT ent_id FROM abs_entreprise WHERE ent_parent = 0");
		if ($db->numRows($result) > 0) $entParent = $result[0]["ent_id"];
		else $entParent = 1;

		$insert = $db->insert("abs_entreprise",
					array(
						"ent_nom" => $entNom,
						"ent_addr1" => $entAddr1,
						"ent_addr2" => $entAddr2,
						"ent_CP" => $_REQUEST["entCP"],
						"ent_ville" => $entVille,
						"ent_tel" => $_REQUEST["entTel"],
						"ent_fax" => $_REQUEST["entFax"],
						"ent_parent" => $entParent
					)
				);

		if ($insert) $message = LANG_ADD_OK;
		else $message = LANG_ADD_NOK;
	}

echo "
<script type=\"text/javascript\">
	function checkForm() {		
		if (document.formEntSucc.entNom.value != \"\") document.formEntSucc.submit();
		else alert(\"".LANG_SAISIR_SOCNOM."\");
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
				<br/>
				<form name="formEntSucc" method="post" action="index.php?action=addSucc&<?php echo $action1; ?>">
					<table border="0" cellpadding="1" cellspacing="10" class="width100p">
						<tr>
							<th class="txtLeft"><?php echo LANG_NOM; ?> <span class="required">*</span></th>
							<td><input name="entNom" class="formInputText" maxlength="50" value="<?php echo $entNom; ?>" type="text"></td>
							<th class="txtLeft"><?php echo LANG_EMPS; ?></th>
							<td class="txtLeft"><?php echo $nbEmployes; ?></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_TEL; ?></th>
							<td><input name="entTel" class="formInputText" maxlength="20" value="<?php echo $entTel; ?>" type="text"></td>
							<th class="txtLeft"><?php echo LANG_FAX; ?></th>
							<td><input name="entFax" class="formInputText" maxlength="20" value="<?php echo $entFax; ?>" type="text"></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_ADR; ?> 1</th>
							<td><input name="entAddr1" class="formInputText" maxlength="50" value="<?php echo $entAddr1; ?>" type="text"></td>
							<th class="txtLeft"><?php echo LANG_ADR; ?> 2</th>
							<td><input name="entAddr2" class="formInputText" maxlength="50" value="<?php echo $entAddr2; ?>" type="text"></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_CP; ?></th>
							<td><input name="entCP" class="formInputText" maxlength="5" value="<?php echo $entCP; ?>" type="text"></td>
							<th class="txtLeft"><?php echo LANG_VILLE; ?></th>
							<td><input name="entVille" class="formInputText" maxlength="50" value="<?php echo $entVille; ?>" type="text"></td>
						</tr>
					</table>
					<?php
						if ($message != "") echo "<div class=\"vert petit\" align=\"center\">$message</div>";
						if (isset($_REQUEST["modif"]) || isset($_REQUEST["modifier"])) echo "<input type=\"hidden\" name=\"entID\" value=\"$entID\" />"; 
					?>				
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo $bouton1; ?>" type="button" onClick="javascript:checkForm();">
						<a href="index.php?action=entSucc" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button"></a>
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

