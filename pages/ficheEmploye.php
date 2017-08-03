<?php
/**************************************
 Cree le: 16-12-2010
 Derniere modification: 124-02-2012
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


/* Formulaire d'affichage depuis la liste */
if (isset($_REQUEST["empID"])) {
	$empID = $_REQUEST["empID"];
	$couleurSolde = "";

	$result = $db->query("SELECT * FROM abs_employe WHERE emp_id = $empID");
	if ($db->numRows($result) != 0) {
		$empNom = utf8_encode($result[0]["emp_nom"]);
		$empPrenom = utf8_encode($result[0]["emp_prenom"]);
		$empNaiss = $result[0]["emp_date_naissance"];
		if ($result[0]["emp_statut"] == "pt") $empStatut = LANG_PT;
		if ($result[0]["emp_statut"] == "mt") $empStatut = LANG_MT;
		if ($result[0]["emp_statut"] == "ap") $empStatut = LANG_AP;
		if ($result[0]["emp_statut"] == "st") $empStatut = LANG_ST;
		$result[0]["emp_samedi"] == 1 ? $empSamedi = LANG_OUI : $empSamedi = LANG_NON;
		$localisation = utf8_encode(getLocalisation($db,$result[0]["emp_ent"]));
		$secteur = getsecteur($db,$result[0]["emp_secteur"]);
		$categorie1 = utf8_encode(getCategorie($db,$result[0]["emp_categorie1"],1));
		$categorie2 = utf8_encode(getCategorie($db,$result[0]["emp_categorie2"],2));
		$fonction = utf8_encode(getFonction($db,$result[0]["emp_fonction"]));
		$empCongesCours = $result[0]["emp_nb_conges_cours"];
		$empCongesReport = $result[0]["emp_nb_conges_report"];
		$empArr = str_replace("/","-",$result[0]["emp_arrivee"]);
		$empDep = str_replace("/","-",$result[0]["emp_depart"]);
		$anciennete = getEcartDates($empArr,$empDep,"annees");
		$result[0]["emp_actif"] == 1 ? $empActif = LANG_OUI : $empActif = LANG_NON;
		$congesPris = getCongesPris($db,$result[0]["emp_id"], date("Y"));
		$soldeConges = $result[0]["emp_nb_conges_cours"] + $result[0]["emp_nb_conges_report"] - $congesPris;
		if ($soldeConges < 0) $couleurSolde = "rouge";
	}
}

	

?>

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
				<table border="0" cellpadding="5" cellspacing="5" class="width100p">
					<tr>
						<th class="txtLeft"><?php echo LANG_NOM_FAM; ?></th>
						<td><?php echo $empNom; ?></td>
						<th class="txtLeft"><?php echo LANG_PRENOM; ?></th>
						<td><?php echo $empPrenom; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_DATE_NAISS; ?></th>
						<td><?php echo $empNaiss; ?></td>
						<th class="txtLeft"><?php echo LANG_STATUT; ?></th>
						<td><?php echo $empStatut; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_TRAVALE.$tabDay["6"]; ?></th>
						<td><?php echo $empSamedi; ?></td>
						<th class="txtLeft"><?php echo LANG_LOCALIS; ?></th>
						<td><?php echo $localisation; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_FONCT; ?></th>
						<td><?php echo $fonction; ?></td>
						<th class="txtLeft"><?php echo LANG_CAT; ?> 1</th>
						<td><?php echo $categorie1; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_SECT; ?></th>
						<td><?php echo $secteur[0]."&nbsp;(".utf8_encode($secteur[1]).")"; ?></td>
						<th class="txtLeft"><?php echo LANG_CAT; ?> 2</th>
						<td><?php echo $categorie2; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_DATE_ARRIVEE; ?></th>
						<td><?php echo $empArr; ?></td>
						<th class="txtLeft"><?php echo LANG_DATE_DEPART; ?></th>
						<td><?php echo $empDep; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_ANCIENNETE." (".LANG_ANNEES.")"; ?></th>
						<td><?php echo $anciennete; ?></td>
						<th class="txtLeft"></th>
						<td></td>
					</tr>
<?php
					//Utilisateur avec statut admin_general
					if (isset($_SESSION['login']) && $_SESSION['admin_general'] == 1) {
?>

					<tr>
						<th class="txtLeft"><?php echo LANG_NB_CONGES_COURS; ?></th>
						<td><?php echo $empCongesCours; ?></td>
						<th class="txtLeft"><?php echo LANG_NB_CONGES_REPORT; ?></th>
						<td><?php echo $empCongesReport; ?></td>
					</tr>
					<tr>
						<th class="txtLeft"><?php echo LANG_PRIS; ?></th>
						<td><?php echo $congesPris; ?></td>
						<th class="txtLeft"><?php echo LANG_SOLDE; ?></th>
						<td class="<?php echo $couleurSolde; ?>"><?php echo $soldeConges; ?></td>
					</tr>
<?php
					}
?>
				</table>
				<div align="center">
					<span class="txtCentrer gras"><?php echo LANG_ACTIVE; ?></span>&nbsp;&nbsp;&nbsp;<?php echo $empActif; ?>
				</div>
				<br/>
		<?php
				if ($_SESSION['admin_secteur'] == 1 || $_SESSION['admin_general'] == 1) {
		?>
				<div class="formbuttons" align="center">
					<a href="index.php?action=addEmpl&modif&empID=<?php echo $empID; ?>" class="noDeco"><input class="formButton" value="<?php echo LANG_MODIF; ?>" type="button"></a>
				</div>
		<?php
				}
		?>

			</div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
	</div>
</div>
