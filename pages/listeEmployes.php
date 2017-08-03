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

$page = "";

$selLocalisation = "all";
$selSecteur = "all";
$selCategorie1 = "all";
$selCategorie2 = "all";
$selFonction = "all";
$selSamedi = "all";
$empActifs = 1;
$where = "";

/** Tri **/
if (isset($_REQUEST["lo"]) && $_REQUEST["lo"] != "all") {
	$selLocalisation = $_REQUEST["lo"];
	$where .= " AND emp_ent = $selLocalisation";
}

if (isset($_REQUEST["se"]) && $_REQUEST["se"] != "all") {
	$selSecteur = $_REQUEST["se"];
	$where .= " AND emp_secteur = $selSecteur";
}

if (isset($_REQUEST["ca1"]) && $_REQUEST["ca1"] != "all") {
	$selCategorie1 = $_REQUEST["ca1"];
	$where .= " AND emp_categorie1 = $selCategorie1";
}

if (isset($_REQUEST["ca2"]) && $_REQUEST["ca2"] != "all") {
	$selCategorie2 = $_REQUEST["ca2"];
	$where .= " AND emp_categorie2 = $selCategorie2";
}


if (isset($_REQUEST["fo"]) && $_REQUEST["fo"] != "all") {
	$selFonction = $_REQUEST["fo"];
	$where .= " AND emp_fonction = $selFonction";
}

if (isset($_REQUEST["sa"]) && $_REQUEST["sa"] != "all") {
	$selSamedi = $_REQUEST["sa"];
	$where .= " AND emp_samedi = $selSamedi";
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] != "all") {
	$empActifs = $_REQUEST["act"];
}

$lien = "index.php?action=listEmpl";
//$lien = "index.php?action=listEmpl&lo=$selLocalisation&se=$selSecteur&ca1=$selCategorie1&ca2=$selCategorie2&fo=$selFonction&sa=$selSamedi";
?>
<script type="text/javascript">
/* <![CDATA[ */
	/** Javascript pour info bulle a l'affichage du calendrier **/
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
				<form name="formEntSucc" method="post" action="index.php?action=addEmpl&amp;modif">
					<br/>
					<table class="data-table" border="0">
						<tr>

				<?php
					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
						$page .= "	<td class=\"width20\"></td>";
					}
						$page .= "	<td>".LANG_NOM."</td>
							<td>".LANG_PRENOM."</td>
							<td>
								<ul class=\"menuTab\">
									<li>
										<a href=\"$lien&amp;lo=all&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l1_link\">".LANG_LOCALIS."</a>
										<ul class=\"sousMenu\">
						";
						$requeteVille = $db->query("SELECT ent_id, ent_ville FROM abs_entreprise ORDER BY ent_ville");
						if ($db->numRows($requeteVille) != 0) {
							for($i = 0; $i < count($requeteVille); ++$i) {
								$page .= "
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=".$requeteVille[$i]["ent_id"]."&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l2_link\">
													".utf8_encode($requeteVille[$i]["ent_ville"])."
												</a>
											</li>
								";
							}
						}
					$page .= "
										</ul>
									</li>
								</ul>
							</td>
							<td>
								<ul class=\"menuTab\">
									<li>
										<a href=\"$lien&amp;lo=$selLocalisation&amp;se=all&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l1_link\">".LANG_SECT."</a>
										<ul class=\"sousMenu\">
						";

						$requeteSect = $db->query("SELECT sect_id, sect_nom FROM abs_secteur ORDER BY sect_nom");
						if ($db->numRows($requeteSect) != 0) {
							for($i = 0; $i < count($requeteSect); ++$i) {
								$page .= "
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=".$requeteSect[$i]["sect_id"]."&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l2_link\">
													".utf8_encode($requeteSect[$i]["sect_nom"])."
												</a>
											</li>
								";
							}
						}
					$page .= "
										</ul>
									</li>
								</ul>
							</td>
							<td>
								<ul class=\"menuTab\">
									<li class=\"width150 grand\">
										<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=all&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l1_link\">".LANG_CAT." 1</a>
										<ul class=\"sousMenu\">
						";

						$requeteCat = $db->query("SELECT cat_id, cat_nom FROM abs_categorie ORDER BY cat_nom");
						if ($db->numRows($requeteCat) != 0) {
							for($i = 0; $i < count($requeteCat); ++$i) {
								$page .= "
											<li class=\"drop width150\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=".$requeteCat[$i]["cat_id"]."&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l2_link\">
													".utf8_encode($requeteCat[$i]["cat_nom"])."
												</a>
											</li>
								";
							}
						}
					$page .= "
										</ul>
									</li>
								</ul>
							</td>
							<td>
								<ul class=\"menuTab\">
									<li>
										<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=all&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l1_link\">".LANG_CAT." 2</a>
										<ul class=\"sousMenu\">
						";

						$requeteCat2 = $db->query("SELECT cat2_id, cat2_nom FROM abs_categorie2 ORDER BY cat2_nom");
						if ($db->numRows($requeteCat2) != 0) {
							for($i = 0; $i < count($requeteCat2); ++$i) {
								$page .= "

											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=".$requeteCat2[$i]["cat2_id"]."&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=$empActifs\" class=\"l2_link\">
													".utf8_encode($requeteCat2[$i]["cat2_nom"])."
												</a>
											</li>
								";
							}
						}
					$page .= "
										</ul>
									</li>
								</ul>
							</td>
							<td>".LANG_FONCT."</td>
					";
					//Utilisateur avec statut admin_general
					if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {
						$page .= "
							<td class=\"width50\">".LANG_PRIS."</td>
							<td class=\"width50\">".LANG_SOLDE."</td>
						";
					}
					$page .= "
							<td>Type</td>
							<td>
								<ul class=\"menuTab\">
									<li>
										<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=all\" class=\"l1_link\">".$tabDay[6]."</a>
										<ul class=\"sousMenu\">
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=1&amp;act=$empActifs\" class=\"l2_link\">
													".LANG_OUI."
												</a>
											</li>
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=0&amp;act=$empActifs\" class=\"l2_link\">
													".LANG_NON."
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</td>
					";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {

					$page .= "		<td>
								<ul class=\"menuTab\">
									<li>
										<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=all\" class=\"l1_link\">".LANG_ACTIFS."</a>
										<ul class=\"sousMenu\">
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=1\" class=\"l2_link\">
													".LANG_OUI."
												</a>
											</li>
											<li class=\"drop\">
												<a href=\"$lien&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;ca1=$selCategorie1&amp;ca2=$selCategorie2&amp;fo=$selFonction&amp;sa=$selSamedi&amp;act=0\" class=\"l2_link\">
													".LANG_NON."
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</td>
					";
						}
					$page .= "
							<td class=\"width20\"></td>
						</tr>
					";

				$requeteEmp = $db->query("SELECT * FROM abs_employe WHERE emp_actif = ".$empActifs.$where." ORDER BY emp_nom,emp_prenom ASC");
				if ($db->numRows($requeteEmp) != 0) {
					$nb = 0;
					for($i = 0; $i < count($requeteEmp); ++$i) {
						
						if ($nb%2 == 0) $color = "beige";
						else $color = "orangeClair";
						$couleurSolde = "";

						$localisation = utf8_encode(getLocalisation($db,$requeteEmp[$i]["emp_ent"]));
						$secteur = getsecteur($db,$requeteEmp[$i]["emp_secteur"]);
						$categorie1 = utf8_encode(getCategorie($db,$requeteEmp[$i]["emp_categorie1"],1));
						$categorie2 = utf8_encode(getCategorie($db,$requeteEmp[$i]["emp_categorie2"],2));
						$fonction = utf8_encode(getFonction($db,$requeteEmp[$i]["emp_fonction"]));
						$congesPris = getCongesPris($db,$requeteEmp[$i]["emp_id"], date("Y"));
						$soldeConges = $requeteEmp[$i]["emp_nb_conges_cours"] + $requeteEmp[$i]["emp_nb_conges_report"] - $congesPris;
						if ($soldeConges < 0) $couleurSolde = "rouge";

						if ($requeteEmp[$i]["emp_statut"] == "pt") $bulleStatut = LANG_PT;
						if ($requeteEmp[$i]["emp_statut"] == "mt") $bulleStatut = LANG_MT;
						if ($requeteEmp[$i]["emp_statut"] == "ap") $bulleStatut = LANG_AP;
						if ($requeteEmp[$i]["emp_statut"] == "st") $bulleStatut = LANG_ST;

						if ($requeteEmp[$i]["emp_samedi"] == 0) $samedi = LANG_NON;
						else $samedi = LANG_OUI;
						
						if ($empActifs == 0) $actif = LANG_NON;
						else $actif = LANG_OUI;
						
						$page .= "	<tr class=\"$color\">
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							$page .= "	<td class=\"txtCentrer\"><input type=\"radio\" name=\"empID\" value=\"".$requeteEmp[$i]["emp_id"]."\"></td>";
						}
						$page .= "		<td>&nbsp;".utf8_encode($requeteEmp[$i]["emp_nom"])."</td>
								<td>&nbsp;".utf8_encode($requeteEmp[$i]["emp_prenom"])."</td>
								<td>&nbsp;$localisation</td>
								<td onmouseover=\"montre('".utf8_encode($secteur[1])."');\" onmouseout=\"cache();\">&nbsp;".$secteur[0]."</td>
								<td>&nbsp;$categorie1</td>
								<td>&nbsp;$categorie2</td>
								<td>&nbsp;$fonction</td>
						";
						//Utilisateur avec statut admin_general
						if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {
							$page .= "
								<td class=\"txtCentrer\">$congesPris</td>
								<td class=\"txtCentrer $couleurSolde\">$soldeConges</td>
							";
						}
						
						$page .= "
								<td onmouseover=\"montre('$bulleStatut');\" onmouseout=\"cache();\">&nbsp;".strtoupper($requeteEmp[$i]["emp_statut"])."</td>
								<td>&nbsp;$samedi</td>
						";
						if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
							$page .= "	<td>&nbsp;$actif</td>	";
						}
						$page .= "		<td class=\"txtCentrer\" onmouseover=\"montre('".LANG_FICHE."');\" onmouseout=\"cache();\">
									<a href=\"index.php?action=fichEmpl&amp;empID=".$requeteEmp[$i]["emp_id"]."\" ><img src=\"images/menu/icons/ficheEmpl.png\" class=\"txtCentrer\" alt=\"Fiche\" /></a>
								</td>
							</tr>
						";
						$nb++;								
					}
				}
				else $page .= "<tr class=\"beige gras\"><td colspan=\"12\">&nbsp;".LANG_NO_EMP."</td><tr>";

				$page .= "</table>";

				echo "<div align=\"center\">$nb ".LANG_EMPS."</div><br/>";
				
				echo $page;

					if (isset($_SESSION['login']) && ($_SESSION['admin_general'] == 1)) {
				?>
					<div class="formbuttons" align="center">
						<a href="index.php?action=addEmpl&amp;add" class="noDeco"><input class="formButton" value="<?php echo LANG_ADD; ?>" type="button"></a>
						<input class="formButton" value="<?php echo LANG_MODIF; ?>" type="submit">
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

