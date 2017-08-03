<?php
/**************************************
 Cree le: 17-12-2010
 Derniere modification: 24-02-2012
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

$utilLogin = "";
$utilNom = "";
$utilPrenom = "";
$utilAdmSect = 0;
$utilAdmGen = 0;
$utilActif = 1;

if (isset($_SESSION['login'])) {

	$utilLogin = $_REQUEST["utilLogin"];

	/* Formulaire de modification depuis la liste */
	if (isset($_REQUEST["modif"])) {
		$titrePage = LANG_UTIL_MODIF;
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";		

		$result = $db->query("SELECT * FROM abs_utilisateur WHERE util_login = '$utilLogin'");
		if ($db->numRows($result) != 0) {
			$utilNom = utf8_encode($result[0]["util_nom"]);
			$utilPrenom = utf8_encode($result[0]["util_prenom"]);
			$utilAdmSect = $result[0]["util_admin_secteur"];
			$utilAdmGen =  $result[0]["util_admin_general"];
			$utilActif =  $result[0]["util_actif"];
		}
	}

	/* Modifications dans la base */
	if (isset($_REQUEST["modifier"])) {
		$titrePage = LANG_UTIL_MODIF;
		$bouton1 = LANG_MODIF;
		$action1 = "modifier";

		//on crypte le mdp
		$utilPassword = sha1($_REQUEST["utilPassword1"]);

		if ($_REQUEST["utilPassword1"] == "") {
			$update = $db->update("abs_utilisateur",
						array(
							"util_nom" => utf8_decode($_REQUEST["utilNom"]),
							"util_prenom" => utf8_decode($_REQUEST["utilPrenom"]),
							"util_admin_secteur" => $_REQUEST["utilAdmSect"],
							"util_admin_general" => $_REQUEST["utilAdmGen"]
						),
						"util_login = '$utilLogin'");
		}
		else {
			$update = $db->update("abs_utilisateur",
						array(
							"util_password" => $utilPassword,
							"util_nom" => utf8_decode($_REQUEST["utilNom"]),
							"util_prenom" => utf8_decode($_REQUEST["utilPrenom"]),
							"util_admin_secteur" => $_REQUEST["utilAdmSect"],
							"util_admin_general" => $_REQUEST["utilAdmGen"]
						),
						"util_login = '$utilLogin'");

		}

		if ($update) $message = LANG_MODIFS_OK;
		else $message = LANG_MODIFS_NOK;

		$result = $db->query("SELECT * FROM abs_utilisateur WHERE util_login = '$utilLogin'");
		if ($db->numRows($result) != 0) {
			$utilNom = utf8_encode($result[0]["util_nom"]);
			$utilPrenom = utf8_encode($result[0]["util_prenom"]);
			$utilAdmSect = $result[0]["util_admin_secteur"];
			$utilAdmGen =  $result[0]["util_admin_general"];
			$utilActif =  $result[0]["util_actif"];
		}
	}

	/* Formulaire d'ajout depuis la liste */
	if (isset($_REQUEST["add"])) {
		$titrePage = LANG_UTIL_ADD;
		$bouton1 = LANG_ADD;
		$action1 = "ajouter";
	}

	/* Ajout dans la base*/
	if (isset($_REQUEST["ajouter"])) {
		$titrePage = LANG_UTIL_ADD;
		$bouton1 = LANG_ADD;
		$action1 = "ajouter";

		//on crypte le mdp
		$utilPassword = sha1($_REQUEST["utilPassword1"]);

		$insert = $db->insert("abs_utilisateur",
					array(
						"util_login" => $utilLogin,
						"util_password" => $utilPassword,
						"util_nom" => utf8_decode($_REQUEST["utilNom"]),
						"util_prenom" => utf8_decode($_REQUEST["utilPrenom"]),
						"util_admin_secteur" => $_REQUEST["utilAdmSect"],
						"util_admin_general" => $_REQUEST["utilAdmGen"],
						"util_actif" => $_REQUEST["utilActif"]
					)
				);

		if ($insert) {
			//on ajoute une ligne dans les tables droits pour reconnaitre l'utilisateur
			$insert = $db->insert("abs_droits_ent",
						array(
							"droits_ent_util" => $utilLogin,
							"droits_ent_id" => 0
						)
					);
			$insert = $db->insert("abs_droits_sect",
						array(
							"droits_sect_util" => $utilLogin,
							"droits_sect_id" => 0
						)
					);
			$message = LANG_ADD_OK;
		}

		$utilLogin = "";
	}


echo "
<script type=\"text/javascript\">
	function checkForm() {
		
		var ok = true;
		if (document.formUtil.utilNom.value == \"\") {
			alert(\"".LANG_SAISIR_NOMFAM."\");
			ok = false;
		}
		if (document.formUtil.utilPrenom.value == \"\") {
			alert(\"".LANG_SAISIR_PRENOM."\");
			ok = false;
		}
		if ( document.formUtil.utilPassword1.value == \"\") {
			alert(\"".LANG_SAISIR_MDP."\");
			ok = false;
		}
		if (document.formUtil.utilPassword1.value != document.formUtil.utilPassword2.value) {
			alert(\"".LANG_ERREUR_MDPS."\");
			ok = false;
		}
		
		if (ok) document.formUtil.submit();
	}
";
?>
</script>

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
				<form name="formUtil" method="post" action="index.php?action=addUtil&amp;<?php echo $action1; ?>">
					<table border="0" cellpadding="5" cellspacing="5" class="width100p">
						<tr>
							<th class="txtLeft">Login <span class="required">*</span></th>
							<td><input name="utilLogin" class="formInputText" maxlength="20" value="<?php echo $utilLogin; ?>" type="text" <?php if($utilLogin != "") echo "disabled=\"disabled\""; ?> /></td>
							<th>&nbsp;</th><td>&nbsp;</td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_MDP; ?> <span class="required">*</span></th>
							<td><input name="utilPassword1" class="formInputText" maxlength="20" value="" type="password" /></td>
							<th class="txtLeft"><?php echo LANG_MDP_REPET; ?> <span class="required">*</span></th>
							<td><input name="utilPassword2" class="formInputText" maxlength="20" value="" type="password" /></td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_NOM_FAM; ?> <span class="required">*</span></th>
							<td><input name="utilNom" class="formInputText" maxlength="30" value="<?php echo $utilNom; ?>" type="text" /></td>
							<th class="txtLeft"><?php echo LANG_PRENOM; ?> <span class="required">*</span></th>
							<td><input name="utilPrenom" class="formInputText" maxlength="30" value="<?php echo $utilPrenom; ?>" type="text" /></td>
						</tr>

						<tr>
							<th class="txtLeft"><?php echo LANG_ADMIN_SECT; ?></th>
							<td>
								<select name="utilAdmSect" >
							<?php
								if ($utilAdmSect == 0) {
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
							<th class="txtLeft"><?php echo LANG_ADMIN_SYST; ?></th>
							<td>
								<select name="utilAdmGen" >
							<?php
								if ($utilAdmGen == 0) {
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
						</tr>
					</table>
					<br/>
					<div align="center">
						<span class="txtCentrer gras"><?php echo LANG_ACTIVE; ?></span>
						<select name="utilActif" >
						<?php
							if ($utilActif == 1) {
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
						if (isset($_REQUEST["modif"]) || isset($_REQUEST["modifier"])) echo "<input type=\"hidden\" name=\"utilLogin\" value=\"$utilLogin\" />"; 
					?>
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo $bouton1; ?>" type="button" onclick="javascript:checkForm();" />
						<a href="index.php?action=listUtil" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button" /></a>
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
