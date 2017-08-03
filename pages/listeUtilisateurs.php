<?php
/**************************************
 Cree le: 20-12-2010
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

if (isset($_SESSION['login'])) {
?>

<div class="width100p">
	<div id="status"></div>
	<div class="outerbox">
		<div class="top">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div>
		<div class="maincontent">
            		<div class="pageTitle"><h2><?php echo $titrePage; ?></h2></div>
				<form name="formUtils" method="post" action="index.php?action=addUtil&amp;modif">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_utilisateur,abs_secteur GROUP BY util_login ORDER BY util_nom");
					
					echo "<table class=\"data-table\" border=\"0\">
						<tr>
							<td class=\"width20\"></td>
							<td>Login</td>
							<td>".LANG_NOM."</td>
							<td>".LANG_PRENOM."</td>
							<td>".LANG_SECT."</td>
							<td>".LANG_SUCCS2."</td>
							<td>".LANG_ADMSECT."</td>
							<td>".LANG_ADMGEN."</td>
						</tr>
					";
					if ($db->numRows($result) > 0) {
						$nb = 0;
						for($j = 0; $j < count($result); ++$j) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";
						
							$admSect = LANG_NON;
							if ($result[$j]["util_admin_secteur"] == 1) $admSect = LANG_OUI;
							$admGen = LANG_NON;
							if ($result[$j]["util_admin_general"] == 1) $admGen = LANG_OUI;

							$tabSecteurs = getListeSecteursUtil($db,$result[$j]["util_login"]);
							$tabVilles = getListeVillesUtil($db,$result[$j]["util_login"]);

							echo "
							<tr class=\"$color\">
								<td class=\"txtCentrer\"><input type=\"radio\" name=\"utilLogin\" value=\"".$result[$j]["util_login"]."\" /></td>
								<td>".$result[$j]["util_login"]."</td>
								<td>".utf8_encode($result[$j]["util_nom"])."</td>
								<td>".utf8_encode($result[$j]["util_prenom"])."</td>
								<td>";
							if ($result[$j]["util_admin_general"] == 1) echo LANG_TOUS;
							else {
								$i = 0;
								while ($i < count($tabSecteurs)) {
									$tabNomSecteur = getSecteur($db,$tabSecteurs[$i]);
									if (isset($tabNomSecteur[0])) echo $tabNomSecteur[0]."&nbsp;";
									$i++;
								}
							}
							echo "	</td>
								<td>";
							if ($result[$j]["util_admin_general"] == 1) echo LANG_TOUTES;
							else {
								$i = 0;
								while ($i < count($tabVilles)) {
									echo utf8_encode(getLocalisation($db,$tabVilles[$i]))."&nbsp;";
									$i++;
								}
							}
							echo "	</td>
								<td>$admSect</td>
								<td>$admGen</td>
							</tr>
							";
						}
					}
					else echo "<tr class=\"beige gras\"><td colspan=\"7\">&nbsp;".LANG_NO_UTILS."</td><tr>";
				?>
					</table>
					<div class="formbuttons" align="center">
						<a href="index.php?action=addUtil&amp;add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="submit" />
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
