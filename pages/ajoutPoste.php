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
$posteID = "";
$posteNom = "";

if (isset($_SESSION['login'])) {

if (isset($_REQUEST["posteID"])) $posteID = $_REQUEST["posteID"];
if (isset($_REQUEST["type"])) $type = $_REQUEST["type"];

if ($type == "fonct") {
	$table = "fonction";
	$titre2 = LANG_ADD_FONCT;
	$prefixe = "fonct";	
}
if ($type == "cat") {
	$table = "categorie";
	$titre2 = LANG_ADD_CAT." 1";
	$prefixe = "cat";	
}
if ($type == "cat2") {
	$table = "categorie2";
	$titre2 = LANG_ADD_CAT." 2";
	$prefixe = "cat2";	
}


	/* Formulaire de modification depuis la liste */
	if (isset($_REQUEST["modif"])) {
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";

		$result = $db->query("SELECT * FROM abs_".$table." WHERE ".$prefixe."_id = $posteID");
		if ($db->numRows($result) > 0) $posteNom = utf8_encode($result[0]["".$prefixe."_nom"]);

	}

	/* Modifications dans la base */
	if (isset($_REQUEST["modifier"])) {
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";

		$update = $db->update("abs_".$table."",
					array(
						"".$prefixe."_nom" => utf8_decode($_REQUEST["posteNom"])
					),
					"".$prefixe."_id = $posteID"
				);

		if ($update) $message = LANG_MODIFS_OK;
		else $message = LANG_MODIFS_NOK;
	}

	/* Formulaire d'ajout depuis la liste */
	if (isset($_REQUEST["add"])) {
		$bouton1 = LANG_ADD;
		$action1 = "ajouter";
	}

	/* Ajout dans la base*/
	if (isset($_REQUEST["ajouter"])) {
		$bouton1 = LANG_ADD;
		$action1 = "ajouter";

		$insert = $db->insert("abs_".$table,
					array(
						$prefixe."_nom" => utf8_decode($_REQUEST["posteNom"])
					)
				);

		if ($insert) $message = LANG_ADD_OK;
		else $message = LANG_ADD_NOK;
	}

echo "
<script type=\"text/javascript\">
	function checkForm() {
		
		if (document.formPostes.posteNom.value != \"\") document.formPostes.submit();
		else alert(\"".LANG_SAISIR_INTITULE."\");
	}
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
            		<div class="pageTitle"><h2><?php echo $titre2; ?></h2></div>
				<br/>
				<form name="formPostes" method="post" action="index.php?action=addPostes&amp;type=<?php echo $type; ?>&amp;<?php echo $action1; ?>">
					<table border="0" cellpadding="5" cellspacing="5" class="width100p">
						<tr>
							<th class="txtLeft"><?php echo LANG_INTITULE; ?> <span class="required">*</span></th>
							<td><input name="posteNom" class="formInputText" maxlength="50" value="<?php echo $posteNom; ?>" type="text" /></td>
						</tr>
					</table>
					<?php
						if ($message != "") echo "<div class=\"vert petit\" align=\"center\">$message</div>";
						if (isset($_REQUEST["modif"]) || isset($_REQUEST["modifier"])) echo "<input type=\"hidden\" name=\"posteID\" value=\"$posteID\" />"; 
					?>
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo $bouton1; ?>" type="button" onclick="javascript:checkForm();" />
						<a href="index.php?action=listPostes&amp;<?php echo $prefixe; ?>" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
