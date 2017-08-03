<?php
/**************************************
 Cree le: 15-12-2010
 Derniere modification: 22-10-2012
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

if (isset($_REQUEST["add"])) {	//Formulaire d'ajout
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
				<form name="formFeries" method="post" action="index.php?action=affFeries&amp;ajouter&amp;liste">
					<br/>
					<table class="width95p" border="0">
						<tr>
							<td>&nbsp;<?php echo LANG_NOM; ?></td>
							<td>&nbsp;<?php echo LANG_DATE; ?></td>
							<td>&nbsp;<?php echo LANG_CHAQUE_ANNEE; ?></td>
						</tr>
						<tr>
							<td><input class="formInputText" type="text" name="ferieNom" maxlength="50" /></td>
							<td><input class="formInputText" type="text" name="ferieDate" maxlength="10" onclick="ds_sh(this);" /></td>
							<td>
								<select name="ferieFixe"">
									<option value="0"><?php echo LANG_NON; ?></option>
									<option value="1"><?php echo LANG_OUI; ?></option>
								</select>
							</td>
						</tr>					
					</table>
					<div class="formbuttons" align="center">
						<input class="formButton" value="<?php echo LANG_ADD; ?>" type="submit">
						<a href="index.php?action=affFeries&amp;liste" class="noDeco"><input class="formButton" value="<?php echo LANG_ANNUL; ?>" type="button"></a>
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
elseif (isset($_REQUEST["ajouter"])) {	//Ajout du jour
	$ferieDate = str_replace("/","-",$_REQUEST["ferieDate"]);
	//On verifie la presence
	list($jour,$mois,$annee) = explode("-",$ferieDate);
	if (checkFerie($db,$jour,$mois,$annee)) {
		$message = LANG_ERREUR_DEJA_PRESENT;
		$couleur = "rouge";
	}
	else {
		//on ajoute
		$insert = $db->insert("abs_feries",
					array(
						"feries_nom" => utf8_decode($_REQUEST["ferieNom"]),
						"feries_date" => $ferieDate,
						"feries_fixe" => $_REQUEST["ferieFixe"]
					)
				);

		if ($insert) $message = LANG_ADD_OK;
		else $message = LANG_ADD_NOK;
	}
}
elseif (isset($_REQUEST["suppr"])) {
	//Suppression du jour
	$delete = $db->delete("abs_feries","","","feries_id = ".$_REQUEST["ferieID"]);
	
	if ($delete) $message = LANG_SUPPR_OK;
}

if (isset($_REQUEST["liste"])) {	//liste des jours feries
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
				<form name="formFeries" method="post" action="index.php?action=affFeries&amp;suppr&amp;liste">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_feries ORDER BY feries_id");
					if ($db->numRows($result) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							echo "  <td class=\"width20\"></td>";
						}
						echo "		<td>&nbsp;".LANG_NOM."</td>
								<td>&nbsp;".LANG_DATE."</td>
								<td>&nbsp;".LANG_CHAQUE_ANNEE."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";
							
							$feriesJour = substr($result[$i]["feries_date"],0,-8);
							$feriesMois = getNomMois($tabMonth,substr($result[$i]["feries_date"],3,-5));
							$feriesDate = $feriesJour." ".$feriesMois;

							if ($result[$i]["feries_fixe"] == 0) {
								$feriesFixe = LANG_NON;									
								$feriesDate .= " ".substr($result[$i]["feries_date"],6);	//on rajoute l'annee
							}
							else $feriesFixe = LANG_OUI;								
							
							echo "	<tr class=\"$color\">";
							if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
								echo "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"ferieID\" value=\"".$result[$i]["feries_id"]."\" /></td>";
							}
							echo "		<td>&nbsp;".utf8_encode($result[$i]["feries_nom"])."</td>
									<td>&nbsp;$feriesDate</td>
									<td>&nbsp;$feriesFixe</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NO_JOURS_FERIES."<br/></div>";
				?>
					<br/>
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=affFeries&amp;add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
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
?>

