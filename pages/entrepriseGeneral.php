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
$message = "";
$create = false;

$entNom = "";
$entAddr1 = "";
$entAddr2 = "";
$entCP = "";
$entVille = "";
$entTel = "";
$entFax = "";
$entCom = "";

if (isset($_SESSION['login'])) {
	//modification ou ajout
	if (isset($_REQUEST["modif"])) {
		//Ajout
		if (isset($_REQUEST["ajout"])) {
			$entNom = $_REQUEST["entNom"];
			$entAddr1 = $_REQUEST["entAddr1"];
			$entAddr2 = $_REQUEST["entAddr2"];
			$entCP = $_REQUEST["entCP"];
			$entVille = $_REQUEST["entVille"];
			$entTel = $_REQUEST["entTel"];
			$entFax = $_REQUEST["entFax"];
			$entCom = $_REQUEST["entComm"];;

			$insert = $db->insert("abs_entreprise",
						array(
							"ent_nom" => utf8_decode($_REQUEST["entNom"]),
							"ent_addr1" => utf8_decode($_REQUEST["entAddr1"]),
							"ent_addr2" => utf8_decode($_REQUEST["entAddr2"]),
							"ent_CP" => $_REQUEST["entCP"],
							"ent_ville" => utf8_decode($_REQUEST["entVille"]),
							"ent_tel" => $_REQUEST["entTel"],
							"ent_fax" => $_REQUEST["entFax"],
							"ent_comm" => utf8_decode($_REQUEST["entComm"]),
							"ent_parent" => 0
						)
					);

			if ($insert) $message = LANG_ADD_OK;
			else $message = LANG_ADD_NOK;
		}
		else {	//Modification 
			$update = $db->update("abs_entreprise",
						array(
							"ent_nom" => utf8_decode($_REQUEST["entNom"]),
							"ent_addr1" => utf8_decode($_REQUEST["entAddr1"]),
							"ent_addr2" => utf8_decode($_REQUEST["entAddr2"]),
							"ent_CP" => $_REQUEST["entCP"],
							"ent_ville" => utf8_decode($_REQUEST["entVille"]),
							"ent_tel" => $_REQUEST["entTel"],
							"ent_fax" => $_REQUEST["entFax"],
							"ent_comm" => utf8_decode($_REQUEST["entComm"])
						),
						"ent_parent = 0");


			if ($update) $message = LANG_MODIFS_OK;
			else $message = LANG_MODIFS_NOK;
		}
	}


	$result = $db->query("SELECT * FROM abs_entreprise WHERE ent_parent = 0");
	if ($db->numRows($result) > 0) {
		$entNom = utf8_encode($result[0]["ent_nom"]);
		$entAddr1 = utf8_encode($result[0]["ent_addr1"]);
		$entAddr2 = utf8_encode($result[0]["ent_addr2"]);
		$entCP = $result[0]["ent_cp"];
		$entVille = utf8_encode($result[0]["ent_ville"]);
		$entTel = $result[0]["ent_tel"];
		$entFax = $result[0]["ent_fax"];
		$entCom = utf8_encode($result[0]["ent_comm"]);
		
		$nbEmployes = getNbEmployes($db,0);
	}
	else {	//pas d'entreprise Generale, on va autoriser la creation
		$create = true;
	}




echo "
<script type=\"text/javascript\">
	function checkForm() {
		
		if(document.formEntGen.entNom.value != \"\") document.formEntGen.submit();
		else alert('".LANG_SAISIR_SOCNOM."');
	}
";
?>
</script>

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
				<form name="formEntGen" method="post" action="index.php?action=entGen&amp;modif">
					<table border="0" cellpadding="1" cellspacing="10" class="width100p">
						<tr>
							<th class="txtLeft"><?php echo LANG_ENT_NOM; ?> <span class="required">*</span></th>
							<td><input name="entNom" class="formInputText" maxlength="50" value="<?php echo $entNom; ?>" type="text" /></td>
							<th class="txtLeft"><?php echo LANG_EMPS; ?></th>
							<td class="txtLeft"><?php echo $nbEmployes; ?></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_TEL; ?></th>
							<td><input name="entTel" class="formInputText" maxlength="20" value="<?php echo $entTel; ?>" type="text" /></td>
							<th class="txtLeft"><?php echo LANG_FAX; ?></th>
							<td><input name="entFax" class="formInputText" maxlength="20" value="<?php echo $entFax; ?>" type="text" /></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_ADR; ?> 1</th>
							<td><input name="entAddr1" class="formInputText" maxlength="50" value="<?php echo $entAddr1; ?>" type="text" /></td>
							<th class="txtLeft"><?php echo LANG_ADR; ?> 2</th>
							<td><input name="entAddr2" class="formInputText" maxlength="50" value="<?php echo $entAddr2; ?>" type="text" /></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_CP; ?></th>
							<td><input name="entCP" class="formInputText" maxlength="5" value="<?php echo $entCP; ?>" type="text" /></td>
							<th class="txtLeft"><?php echo LANG_VILLE; ?></th>
							<td><input name="entVille" class="formInputText" maxlength="50" value="<?php echo $entVille; ?>" type="text" /></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_COMMS; ?></th>
							<td colspan="3"><textarea name="entComm" class="formTextArea" rows="3" cols="60" <?php if ($entCom != "") echo "value=\"$entCom\""; ?>></textarea></td>
						</tr>
					</table>
					<?php
						if ($message != "") echo "<div class=\"vert petit\" align=\"center\">$message</div>";
						if ($create) echo "<input type=\"hidden\" name=\"ajout\" value=\"1\" />";
					?>				
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="button" onclick="javascript:checkForm();" />
						<a href="index.php?action=entGen" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
?>
