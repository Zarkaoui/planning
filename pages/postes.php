<?php
/**************************************
 Cree le: 15-12-2010
 Derniere modification: 08-11-2012
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


$table = "";
$prefixe = "";


if (isset($_SESSION['login'])) {

	if (isset($_REQUEST["fonct"])) {
		$table = "fonction";
		$prefixe = "fonct";
		$titrePage = LANG_FONCTS;	
	}
	if (isset($_REQUEST["cat"])) {
		$table = "categorie";
		$prefixe = "cat";
		$titrePage = LANG_CAT." 1";	
	}
	if (isset($_REQUEST["cat2"])) {
		$table = "categorie2";
		$prefixe = "cat2";
		$titrePage = LANG_CAT." 2";	
	}


	if (isset($_REQUEST["suppr"])) {	//Suppression
		$message = "Suppression";
		// On verifie avant qu'aucun employe n'appartient a ce poste ou categorie
		if (!checkPresencePoste($db,$table,$_REQUEST["t"])) {
			$delete = $db->delete("abs_".$table,"","",$prefixe."_id = ".$_REQUEST["t"]);
			if ($delete) $message = LANG_SUPPR_OK;
		}
		else {
			$message = LANG_POSTE_SUPPR_IMPOSSIBLE;
			$couleur = "rouge";
		}
	}



echo "
<script type=\"text/javascript\">
//<![CDATA[
	function supprimer() {
		
		var ok = false;
		var val = 0;
		for(i = 0; i < document.formPoste.posteID.length; i++){
			if(document.formPoste.posteID[i].checked) {
				val = document.formPoste.posteID[i].value;
				ok = true;
			}
		}
		
		if (!ok) alert(\"".LANG_ERREUR_SEL_PERIO."\"); 
		else document.location.replace('index.php?action=listPostes&suppr&".$prefixe."&t='+val);
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
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
				?>
				<form name="formPoste" method="post" action="index.php?action=addPostes&amp;modif&amp;type=<?php echo $prefixe; ?>">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_".$table." ORDER BY ".$prefixe."_nom");
					if ($db->numRows($result) > 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
								<td></td>
								<td>".LANG_NOM."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";
							
							echo "	<tr class=\"$color\">
									<td class=\"txtCentrer width20\"><input type=\"radio\" name=\"posteID\" value=\"".$result[$i][$prefixe."_id"]."\" /></td>
									<td>&nbsp;".utf8_encode($result[$i][$prefixe."_nom"])."</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NO_DONNEES."<br/></div>";
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=addPostes&amp;add&amp;type=<?php echo $prefixe; ?>" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="submit" />
				<?php
					if ($db->numRows($result) != 1) {	//MUST have one at least
				?>
						<input class="formButton" value="<?php echo LANG_SUPPR; ?>"  type="button" onclick="supprimer();" />
				<?php
					}
				?>
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
