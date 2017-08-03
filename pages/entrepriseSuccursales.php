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
            		<div class="pageTitle"><h2><?php echo LANG_ENTSUC; ?></h2></div>
				<form name="formEntSucc" method="post" action="index.php?action=addSucc&amp;modif">
					<br/>
				<?php
					$result = $db->query("SELECT * FROM abs_entreprise");
					if ($db->numRows($result) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
								<td></td>
								<td>".LANG_NOM."</td>
								<td>".LANG_ADR." 1</td>
								<td>".LANG_ADR." 2</td>
								<td>".LANG_CP."</td>
								<td>".LANG_VILLE."</td>
								<td>".LANG_TEL."</td>
								<td>".LANG_FAX."</td>
								<td>".LANG_EFFECTIF."</td>
							</tr>
						";
						$nb = 0;
						for($i = 0; $i < count($result); ++$i) {
							
							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";

							$nbEmployes = getNbEmployes($db,$result[$i]["ent_id"]);
							
							echo "	<tr class=\"$color\">
							";

							if ($result[$i]["ent_parent"] == 0) echo "<td></td>";
							else echo " 	<td class=\"txtCentrer\"><input type=\"radio\" name=\"entID\" value=\"".$result[$i]["ent_id"]."\" /></td>";
							echo "
									<td>&nbsp;".utf8_encode($result[$i]["ent_nom"])."</td>
									<td>&nbsp;".utf8_encode($result[$i]["ent_addr1"])."</td>
									<td>&nbsp;".utf8_encode($result[$i]["ent_addr2"])."</td>
									<td>&nbsp;".$result[$i]["ent_cp"]."</td>
									<td>&nbsp;".utf8_encode($result[$i]["ent_ville"])."</td>
									<td>&nbsp;".$result[$i]["ent_tel"]."</td>
									<td>&nbsp;".$result[$i]["ent_fax"]."</td>
									<td>&nbsp;$nbEmployes</td>
								</tr>
							";
							$nb++;								
						}
						echo "</table>";
					}
					else echo "<div>&nbsp;".LANG_NOSUCC."<br/></div>";
				?>
					
					<div class="formbuttons" align="center">
						<a href="index.php?action=addSucc&amp;add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
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
