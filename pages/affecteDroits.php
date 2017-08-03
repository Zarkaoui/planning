<?php
/**************************************
 Cree le: 31-01-2011
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

$utilLogin = "";

if (isset($_SESSION['login'])) {
	/* Recuperation login utilisateur */
	if (isset($_REQUEST["util"])) $utilLogin = $_REQUEST["util"];

	/* Ajout dans la base*/
	if (isset($_REQUEST["do"])) {
		//on supprime tous les droits
		$db->delete("abs_droits_ent","","","droits_ent_util = '$utilLogin' AND droits_ent_id != 0");
		$db->delete("abs_droits_sect","","","droits_sect_util = '$utilLogin' AND droits_sect_id != 0");
		//puis on reaffecte en recuperant les valeurs a droite
		$tabVilles = $_POST["entreprise_droite"];
		foreach($tabVilles as $ville) {
			$tabVillesId = explode("-",$ville);
			affecteDroitsVille($db,$utilLogin,$tabVillesId[0]);
		}
		$tabSecteurs = $_POST["secteur_droite"];
		foreach($tabSecteurs as $secteur) { 
			$tabSecteursId = explode("-",$secteur);
			affecteDroitsSecteur($db,$utilLogin,$tabSecteursId[0]);
		}
		$message = LANG_MODIFS_OK;
	}

?>

<script type="text/javascript">
//<![CDATA[
	function moveSelected(from, to) {
	 
		from	= document.getElementById(from);
		to	= document.getElementById(to);
	 
		if (from.type != 'select-multiple' || to.type != 'select-multiple') {
			return false;
		}
	
		len = from.options.length - 1;
	
		for (i = len; i >= 0; i--) {
			if (from.options[i].selected) {		
				to.options[to.options.length] = new Option(from.options[i].text);
				from.options[i] = null;	
			}	
		}
		return true;		
	}

	function postSelect(liste){
		// On compte le nombre d'item de la liste select entreprise
		nbCol = document.forms[liste].elements.entreprise_droite.length;
		// On lance une boucle pour selectionner tous les items
		for(i = 0; i < nbCol; i++){
			document.forms[liste].elements.entreprise_droite.options[i].selected = true;
		}
		document.forms[liste].elements.entreprise_droite.name = "entreprise_droite[]";

		// On compte le nombre d'item de la liste select
		nbCol = document.forms[liste].elements.secteur_droite.length;
		// On lance une boucle pour selectionner tous les items
		for(i = 0; i < nbCol; i++){
			document.forms[liste].elements.secteur_droite.options[i].selected = true;
		}
		document.forms[liste].elements.secteur_droite.name = "secteur_droite[]";

		// On soumet le formulaire
		document.forms[liste].submit();
	} 
//]]>
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
				<form name="formUtil" method="post" onsubmit="postSelect(this.name)" action="index.php?action=droitsUtil&amp;util=<?php echo $utilLogin; ?>&amp;do">
					<table border="0" cellpadding="5" cellspacing="5" class="width100p">
						<tr>
							<th class="txtLeft"><?php echo LANG_UTIL; ?></th>
							<td>
								<select name="util" onchange="window.location.href='index.php?action=droitsUtil&amp;util='+this.options[this.selectedIndex].value">
							<?php
								if ($utilLogin == "") echo "<option value=\"\" selected=\"selected\">- ".LANG_SELECT." -</option>";
								else echo "<option value=\"\" >- ".LANG_SELECT." -</option>";

								$result = $db->query("SELECT * FROM abs_utilisateur WHERE util_admin_general != 1 ORDER BY util_nom,util_prenom");
								if ($db->numRows($result) != 0) {
									for($i = 0; $i < count($result); ++$i) {
										if ($result[$i]["util_login"] == $utilLogin) $selected = "selected=\"selected\"";
										else $selected = "";
										echo "<option value=\"".$result[$i]["util_login"]."\" $selected>".utf8_encode($result[$i]["util_nom"])." ".utf8_encode($result[$i]["util_prenom"])."</option>";
									}
								}
							?>
								</select>
								<br/>
							</td>
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_SECTS; ?>:</th>
							<td>
								
								<select name="secteur_gauche" id="secteur_gauche" class="multipleSelect" ondblclick="javascript:moveSelected('secteur_gauche', 'secteur_droite')" multiple="multiple">
							<?php 
								$requeteSectNOK = $db->query("SELECT * FROM abs_droits_sect,abs_secteur 
												WHERE droits_sect_util = '$utilLogin' AND sect_id != droits_sect_id
												GROUP BY sect_id ORDER BY sect_id");
								if ($db->numRows($requeteSectNOK) != 0) {
									for($i = 0; $i < count($requeteSectNOK); ++$i) {
										echo "  <option value=\"".$requeteSectNOK[$i]["sect_id"]."\">
												".$requeteSectNOK[$i]["sect_id"]."- ".utf8_encode($requeteSectNOK[$i]["sect_nom"])." (".utf8_encode($requeteSectNOK[$i]["sect_intitule"]).")
											</option>";
									}
								}
							?>
								</select>
							</td>
							<td class="separeSelect">
								<input name="secteur_deplacer_droite" value="--&gt;&gt;" onclick="javascript:moveSelected('secteur_gauche', 'secteur_droite')" type="button" />
								<br/><br/>
								<input name="secteur_deplacer_gauche" value="&lt;&lt;--" onclick="javascript:moveSelected('secteur_droite', 'secteur_gauche')" type="button" />
							</td>
							<td>
								<select name="secteur_droite" id="secteur_droite" class="multipleSelect vertClair" ondblclick="javascript:moveSelected('secteur_droite', 'secteur_gauche')" multiple="multiple">
							<?php 
								$requeteSectOK = $db->query("SELECT * FROM abs_droits_sect,abs_secteur 
												WHERE droits_sect_util = '$utilLogin' AND sect_id = droits_sect_id
												ORDER BY sect_id");
								if ($db->numRows($requeteSectOK) != 0) {
									for($i = 0; $i < count($requeteSectOK); ++$i) {
										echo "  <option value=\"".$requeteSectOK[$i]["sect_id"]."\">
												".$requeteSectOK[$i]["sect_id"]."- ".utf8_encode($requeteSectOK[$i]["sect_nom"])." (".utf8_encode($requeteSectOK[$i]["sect_intitule"]).")
											</option>";
									}
								}
							?>
								</select>
							
							</td>							
						</tr>
						<tr>
							<th class="txtLeft"><?php echo LANG_ENTSUCS; ?>:</th>
							<td>				
								<select multiple="multiple" name="ent_gauche" id="ent_gauche" class="multipleSelect" ondblclick="javascript:moveSelected('ent_gauche', 'ent_droite')">
							<?php 
								$requeteEntNOK = $db->query("SELECT * FROM abs_droits_ent,abs_entreprise 
												WHERE droits_ent_util = '$utilLogin' AND ent_id NOT IN (SELECT droits_ent_id FROM abs_droits_ent WHERE droits_ent_util = '$utilLogin')
												GROUP BY ent_id ORDER BY ent_id");
								if ($db->numRows($requeteEntNOK) != 0) {
									for($i = 0; $i < count($requeteEntNOK); ++$i) {
										echo "<option value=\"".$requeteEntNOK[$i]["ent_id"]."\">".$requeteEntNOK[$i]["ent_id"]."- ".utf8_encode($requeteEntNOK[$i]["ent_ville"])."</option>";
									}
								}
							?>
								</select>
							</td>
							<td class="separeSelect">
								<input name="ent_deplacer_droite" value="--&gt;&gt;" onclick="javascript:moveSelected('ent_gauche', 'ent_droite')" type="button" />
								<br/><br/>
								<input name="ent_deplacer_gauche" value="&lt;&lt;--" onclick="javascript:moveSelected('ent_droite', 'ent_gauche')" type="button" />
							</td>
							<td>
								<select multiple="multiple" name="entreprise_droite" id="ent_droite" class="multipleSelect vertClair" ondblclick="javascript:moveSelected('ent_droite', 'ent_gauche')">
							<?php 
								$requeteEntOK = $db->query("SELECT * FROM abs_droits_ent,abs_entreprise 
												WHERE droits_ent_util = '$utilLogin' AND ent_id = droits_ent_id
												ORDER BY ent_id");
								if ($db->numRows($requeteEntOK) != 0) {
									for($i = 0; $i < count($requeteEntOK); ++$i) {
										echo "<option value=\"".$requeteEntOK[$i]["ent_id"]."\">".$requeteEntOK[$i]["ent_id"]."- ".utf8_encode($requeteEntOK[$i]["ent_ville"])."</option>";
									}
								}
							?>
								</select>
							</td>
							
						</tr>
					</table>
					<br/>
					<?php
						if ($message != "") echo "<div class=\"vert petit\" align=\"center\">$message</div>";
					?>
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="submit" />
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
</div>
<?php
}
?>
