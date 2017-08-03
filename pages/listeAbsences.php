<?php
/**************************************
 Cree le: 20-12-2010
 Derniere modification: 26-04-2012
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
$where = "";
$selLocalisation = "all";
$selSecteur = "all";

$lien = "index.php?action=listAbs";

/** Tri **/
//Localisation
if (isset($_REQUEST["lo"]) && $_REQUEST["lo"] != "all" && $_REQUEST["lo"] != "") {
	$selLocalisation = $_REQUEST["lo"];
	$where .= " AND emp_ent = $selLocalisation";
}
//Secteur
if (isset($_REQUEST["se"]) && $_REQUEST["se"] != "all" && $_REQUEST["se"] != "") {
	$selSecteur = $_REQUEST["se"];
	$where .= " AND emp_secteur = $selSecteur";
}

if (isset($_REQUEST["an"])) $selAnnee = $_REQUEST["an"];
else $selAnnee = date("Y");
if (isset($_REQUEST["mo"])) $selMois = $_REQUEST["mo"];
else $selMois = date("n");
//Annee
if ($selAnnee != "all" && $selMois == "all") $where .= " AND conges_date LIKE '%-%-$selAnnee'";
//Mois
if ($selMois != "all") {
	if ($selMois < 10 && strlen($selMois) == 1) $selMois = "0".$selMois;
	$where .= " AND conges_date LIKE '%-$selMois-$selAnnee'";
}

if (isset($_REQUEST["utilid"])) {
	$utilID = $_REQUEST["utilid"];
	$where .= "AND emp_id = $utilID";		
}


//debug
if(DEBUG) echo "WHERE: $where <br/>";


//**** Suppression
if (isset($_REQUEST["suppr"])) {
	if (isset($_REQUEST["absID"])) {
		//on supprime les 'fils'
		$deleteF = $db->delete("abs_conges","","","conges_debut = ".$_REQUEST["absID"]);
		if ($deleteF) {
			//on supprime le 'pere'
			$deleteP = $db->delete("abs_conges","","","conges_id = ".$_REQUEST["absID"]);
			if ($deleteP) $message = LANG_SUPPR_OK;
			else {
				$message = LANG_SUPPR_NOK2;
				$couleur = "rouge";
			}
		}
		else {
			$message = LANG_SUPPR_NOK;
			$couleur = "rouge";
		}
	}
	else {
		$message = LANG_NO_ABS_SEL;
		$couleur = "rouge";
	}
}


?>


<script type="text/javascript">
/* <![CDATA[ */
	/** Javascript pour info bulle **/
	sfHover = function() {
		var sfEls = document.getElementById("menu").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+="sfhover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp("sfhover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);



	function GetId(id) {
		return document.getElementById(id);
	}

	var i=false;

	function move(e) {
		if(i) {
			if (navigator.appName!="Microsoft Internet Explorer") {
				GetId("curseur").style.left=e.pageX + 5+"px";
				GetId("curseur").style.top=e.pageY + 10+"px";
			}
			else {
				if(document.documentElement.clientWidth>0) {
					GetId("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
					GetId("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
				}
				else {
					GetId("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
					GetId("curseur").style.top=10+event.y+document.body.scrollTop+"px";
				}
			}
		}
	}

	function montre(text) {
		if(i==false) {
			GetId("curseur").style.visibility="visible";
			GetId("curseur").innerHTML = text;
			i=true;
		}
	}

	function cache() {
		if(i==true) {
			GetId("curseur").style.visibility="hidden";
			i=false;
		}
	}
	document.onmousemove=move;
	/** FIN infobulle **/
/* ]]> */ 
</script>
<!-- Info Bulle -->
<div id="curseur" class="infobulle"></div>
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
				<form name="formAbs" method="post" action="index.php?action=listAbs&amp;suppr&amp;lo=<?php echo $selLocalisation; ?>&amp;se=<?php echo $selSecteur; ?>&amp;an=<?php echo $selAnnee; ?>&amp;mo=<?php echo $selMois; ?>">
					<br/>
					<div align="center">
						<?php echo LANG_MOIS; ?> :
				<?php
						echo "<select name=\"mois\" onchange=\"window.location.href='$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;an=$selAnnee&amp;mo='+this.options[this.selectedIndex].value\">
							<option value=\"all\">".LANG_TOUS."</option>";
				
						foreach ($tabMonth as $key => $val) {
							if ($key == $selMois) echo "\t<option value=\"$key\" selected=\"selected\">$val</option>";
							else echo "\t<option value=\"$key\" >$val</option>";
						}
				?>
						</select>

						<?php echo LANG_ANNEE; ?> : 

				<?php		
						echo "<select name=\"annee\" onchange=\"window.location.href='$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;mo=$selMois&amp;an='+this.options[this.selectedIndex].value\">
							<option value=\"all\">".LANG_TOUS."</option>";
						//on cale le debut a la premiere annee d'activite
						$i = FIRST_YEAR;
						//on cale la fin l'annee courante+1
						$anneeFin = date("Y") + 1;						
						while ($i <= $anneeFin) {
							if ($i == $selAnnee) echo "\t<option value=\"$i\" selected=\"selected\">$i</option>";
							else echo "\t<option value=\"$i\" >$i</option>";
							$i++;
						}
				?>
						</select>
					</div>
					<br/>
				<?php
					// ORANGE - Edgar FERNANDES
					//$requeteEmp = $db->query("SELECT conges_date,emp_id,conges_id,conges_demijournee,emp_secteur,emp_ent,emp_nom,emp_prenom,ent_ville,sect_nom,sect_intitule,type_nom,periodicite_libelle,
					//				conges_login_saisie,conges_date_saisie,STR_TO_DATE(REPLACE(conges_date,'-','.'),GET_FORMAT(DATE,'EUR')) AS date_format
					//				FROM abs_employe,abs_conges,abs_type,abs_entreprise,abs_secteur,abs_periodicite									
					//				WHERE emp_actif = 1 AND conges_employe = emp_id AND conges_type = type_id AND ent_id = emp_ent 
					//				AND sect_id = emp_secteur AND conges_debut = 0 AND conges_periodicite = periodicite_id".$where."
					//				ORDER BY date_format ASC, emp_nom ASC");

					$requeteEmp = $db->query("SELECT conges_date,emp_id,conges_id,conges_demijournee,emp_secteur,emp_ent,emp_nom,emp_prenom,ent_ville,sect_nom,sect_intitule,type_nom,
                                                                        conges_login_saisie,conges_date_saisie,STR_TO_DATE(REPLACE(conges_date,'-','.'),GET_FORMAT(DATE,'EUR')) AS date_format
                                                                        FROM abs_employe,abs_conges,abs_type,abs_entreprise,abs_secteur
                                                                        WHERE emp_actif = 1 AND conges_employe = emp_id AND conges_type = type_id AND ent_id = emp_ent
                                                                        AND sect_id = emp_secteur AND conges_debut = 0 ".$where."
                                                                        ORDER BY date_format ASC, emp_nom ASC");

					if ($db->numRows($requeteEmp) != 0) {
						echo "<table class=\"data-table\" border=\"0\">
							<tr>
								<td class=\"width15\"></td>
								<td>
									<input autocomplete=\"off\" id=\"champ_util\" name=\"champ_util\" type=\"text\" class=\"autocompleteInput\" value=\"".LANG_EMP."\" onclick=\"this.value='';\"/>
									<div class=\"update\" id=\"util_update\"></div>
								</td>
								<td>
									<ul class=\"menuTab\">
										<li>
											<a href=\"$lien&amp;lo=all&amp;se=$selSecteur\" class=\"l1_link\">".LANG_LOCALIS."</a>
											<ul class=\"sousMenu\">
									";

									$requeteVille = $db->query("SELECT ent_id, ent_ville FROM abs_entreprise ORDER BY ent_ville");
									if ($db->numRows($requeteVille) != 0) {
										for($j = 0; $j < count($requeteVille); ++$j) {
											echo "
												<li class=\"drop\">
													<a href=\"$lien&amp;lo=".$requeteVille[$j]["ent_id"]."&amp;se=$selSecteur\" class=\"l2_link\">
														".utf8_encode($requeteVille[$j]["ent_ville"])."
													</a>
												</li>
											";
										}
									}
						echo "
											</ul>
										</li>
									</ul>
								</td>
								<td>
									<ul class=\"menuTab\">
										<li>
											<a href=\"$lien&amp;lo=$selLocalisation&amp;se=all\" class=\"l1_link\">".LANG_SECT."</a>
											<ul class=\"sousMenu\">
								";

								$requeteSect = $db->query("SELECT * FROM abs_secteur ORDER BY sect_nom");
								if ($db->numRows($requeteSect) != 0) {
									for($k = 0; $k < count($requeteSect); ++$k) {
										echo "
												<li class=\"drop\">
													<a href=\"$lien&amp;lo=$selLocalisation&amp;se=".$requeteSect[$k]["sect_id"]."\" class=\"l2_link\">
														".utf8_encode($requeteSect[$k]["sect_nom"])."
													</a>
												</li>
										";
									}
								}
							echo "
											</ul>
										</li>
									</ul>
								</td>
								<td>".LANG_DATE_DEBUT."</td>
								<td>".LANG_DATE_FIN."</td>
								<td>".LANG_DEMI_JOURN."</td>
								<td>".LANG_TYPE."</td>
						";
								//Si admin general ou secteur , affichage du login utilisateur qui a ajoute l'absence
								if ($_SESSION['admin_secteur'] == 1 || $_SESSION['admin_general'] == 1) {
									echo "  <td>".LANG_ADD_PAR."</td>
										<td>".LANG_ADD_LE."</td>";
								}
						//echo "		<td class=\"width50\">".LANG_MODIF."</td>";
						echo "	</tr>";

						$nb = 0;
						for($i = 0; $i < count($requeteEmp); ++$i) {
							//on recupere les date debut/fin de la periode de conges
							$tabDates = getCongesPeriode($db,$requeteEmp[$i]["conges_id"]);

							if ($nb%2 == 0) $color = "beige";
							else $color = "orangeClair";

							if ($requeteEmp[$i]["conges_demijournee"] == "0") $demiJournee = LANG_NON;
							if ($requeteEmp[$i]["conges_demijournee"] == "m") $demiJournee = LANG_MATIN;
							if ($requeteEmp[$i]["conges_demijournee"] == "a") $demiJournee = LANG_APRESMIDI;
						
							echo "<tr class=\"$color\">";
							//l'admin secteur ne peut modifier que les conges des employes de son secteur
							if (isset($_SESSION['login']) && $_SESSION['admin_secteur'] == 1 && checkDroitsSecteur($db,$_SESSION['login'],$requeteEmp[$i]["emp_secteur"]) && checkDroitsVille($db,$_SESSION['login'],$requeteEmp[$i]["emp_ent"])) {
								echo "<td class=\"txtCentrer\"><input type=\"radio\" name=\"absID\" value=\"".$requeteEmp[$i]["conges_id"]."\" /></td>";
							}
							else {	//l'admin general peut tout modifier
								if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {
									echo "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"absID\" value=\"".$requeteEmp[$i]["conges_id"]."\" /></td>";
								} //le visiteur ne modifie rien
								else echo "<td></td>";
							}
							echo "	<td>&nbsp;".utf8_encode($requeteEmp[$i]["emp_nom"])." ".utf8_encode($requeteEmp[$i]["emp_prenom"])."</td>
								<td>&nbsp;".utf8_encode($requeteEmp[$i]["ent_ville"])."</td>
								<td>&nbsp;".utf8_encode($requeteEmp[$i]["sect_nom"])." (".utf8_encode($requeteEmp[$i]["sect_intitule"]).")</td>
								<td>&nbsp;".$tabDates[0]."</td>
								<td>&nbsp;".$tabDates[1]."</td>
								<td>&nbsp;$demiJournee</td>
								<td>&nbsp;".utf8_encode($requeteEmp[$i]["type_nom"])."</td>
							";
							
							//Si admin general ou secteur, affichage du login utilisateur qui a ajoute l'absence
							if ($_SESSION['admin_secteur'] == 1 || $_SESSION['login'] == LOGIN_ADMIN) {
								echo "  <td>&nbsp;".$requeteEmp[$i]["conges_login_saisie"]."</td>
									<td>&nbsp;".$requeteEmp[$i]["conges_date_saisie"]."</td>";
								//Modification
								echo "	<td class=\"txtCentrer\" onmouseover=\"montre('".LANG_MODIF."');\" onmouseout=\"cache();\">
										<a href=\"index.php?action=modAbs&amp;absID=".$requeteEmp[$i]["conges_id"]."\" >
											<img src=\"images/menu/icons/defemprep.gif\" title=\"".LANG_MODIF."\" >
										</a>
									</td>";
							}
							echo "</tr>";
							$nb++;
						}
					
						echo "</table>";
					}
					else echo "<tr class=\"beige gras\"><td colspan=\"8\">".LANG_NO_CONGES."</td></tr>"
				?>
					<br/>
				<?php
					if ($message != "") echo "<div class=\"$couleur petit\" align=\"center\">$message</div>";
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1 || $_SESSION['admin_secteur'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=doAbs" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button" /></a>
						<input class="formButton" value="<?php echo LANG_SUPPR; ?>" type="submit" />
					</div>
				<?php
					}
				echo "
				</form>
				<script type=\"text/javascript\">
					// <![CDATA[
					new Ajax.Autocompleter ('champ_util',
						'util_update',
						'pages/listeAbsencesAjax.php?lo=$selLocalisation&se=$selSecteur&mo=$selMois&an=$selAnnee',
						{
							method: 'post',
							paramName: 'champ_util',
							minChars: 2
						});
					//]]>
				</script>
				";
				?>
			</div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
	</div>
</div>
