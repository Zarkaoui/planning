<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 12-07-2011
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

$dateDebut = date("Y");

if ($numEtape == 5) {
	$filename = "../include/config.php";
	if (!is_writable($filename)) {
		echo "<br/>Veillez &agrave; bien donner les droits en &eacute;criture au fichier 'include/config.php' !!! <br/><br/>
			<input type=\"button\" onclick=\"location.reload();\" value=\"C'est Fait !\" /><br/><br/>
		";
	}
	else {
?>
<script type="text/javascript">
	function checkSubmit() {

		var ok = true;

		if (document.formAdminOptions.adminLogin.value == "" && ok) {
			alert("Entrez un nom d'administrateur");
			ok = false;
		}
		if (document.formAdminOptions.adminPassword.value == "" && ok) {
			alert("Saisissez un mot de passe administrateur");
			ok = false;
		}
		if (document.formAdminOptions.adminPassword.value != document.formAdminOptions.adminPassword2.value && ok) {
			alert("Erreur de saisie des mots de passe" );
			ok = false;
		}
		date = document.formAdminOptions.dateDebut.value;
		if (date == "" && ok) {
			alert("Entrez une date de début");
			ok = false;
		}
		else {
			if(date.length != 4 || isNaN(date)) {
				alert("Entrez une date sur 4 chiffres");
				ok = false;	
			}
		}

		if (document.formAdminOptions.timezone.value == "" && ok) {
			alert("Entrez un timezone");
			ok = false;
		}

		if (ok) document.formAdminOptions.submit();
	}
</script>
<form name="formAdminOptions" method="post" action="setup.php">

	 <table cellpadding="0" cellspacing="0" border="0" class="table">
		<tr>
			<th colspan="3" >Compte administrateur</th>                
		</tr>
		<tr>
			<td class="tdComponent">Login</td>
			<td class="tdValues"><input type="text" name="adminLogin" value="<?php echo  isset($_SESSION['confInfo']['adminLogin']) ? $_SESSION['confInfo']['adminLogin'] : 'administrateur'?>" tabindex="7"> </td>
		</tr>
		<tr>
			<td class="tdComponent">Mot de passe de l'utilisateur</td>
			<td class="tdValues"><input type="password" name="adminPassword" value="<?php echo  isset($_SESSION['confInfo']['adminPassword']) ? $_SESSION['confInfo']['adminPassword'] : ''?>" tabindex="8"> </td>
		</tr>
		<tr>
			<td class="tdComponent">Mot de passe de l'utilisateur (r&eacute;p&eacute;ter)</td>
			<td class="tdValues"><input type="password" name="adminPassword2" value="<?php echo  isset($_SESSION['confInfo']['adminPassword']) ? $_SESSION['confInfo']['adminPassword'] : ''?>" tabindex="8"> </td>
		</tr>
		<tr><td><br/><br/></td></tr>
		<tr>
			<th colspan="3" >Options g&eacute;n&eacute;rales</th>                
		</tr>
		<tr>
			<td class="tdComponent">Ann&eacute;e de d&eacute;but du planning</td>
			<td class="tdValues"><input type="text" name="dateDebut" value="<?php echo  isset($_SESSION['confInfo']['dateDebut']) ? $_SESSION['confInfo']['dateDebut'] : $dateDebut?>" tabindex="7"> </td>
		</tr>
		<tr>
		<?php
			$selectYes = "";
			$selectNo = "";
			
			if (isset($_SESSION['confInfo']['accesVisiteur'])) {
				if ($_SESSION['confInfo']['accesVisiteur'] == 1) $selectYes = "checked";
				else $selectNo = "checked";
			}
			else $selectYes = "checked";

		?>
			<td class="tdComponent">Acc&egrave;s Visiteur (calendrier + liste des absences uniquement)</td>
			<td class="tdValues">Oui <input type="radio" name="accesVisiteur" value="1" tabindex="9" <?php echo $selectYes; ?>> &nbsp;&nbsp;&nbsp;Non <input type="radio" name="accesVisiteur" value="0" tabindex="9" <?php echo $selectNo; ?>></td>
		</tr>
		<tr>
		<?php
			$selectYes = "";
			$selectNo = "";
			
			if (isset($_SESSION['confInfo']['exportPDF'])) {
				if ($_SESSION['confInfo']['exportPDF'] == 1) $selectYes = "checked";
				else $selectNo = "checked";
			}
			else $selectYes = "checked";

		?>
			<td class="tdComponent">Export du calendrier au format PDF</td>
			<td class="tdValues">Oui <input type="radio" name="exportPDF" value="1" tabindex="9" <?php echo $selectYes; ?>> &nbsp;&nbsp;&nbsp;Non <input type="radio" name="exportPDF" value="0" tabindex="9" <?php echo $selectNo; ?>></td>
		</tr>
		<tr>
		<?php
			$selectFR = "";
			$selectEN = "";
			$selectGE = "";

			if (isset($_SESSION['confInfo']['lang'])) {
				if ($_SESSION['confInfo']['lang'] == "FR") $selectFR = "checked";
				elseif ($_SESSION['confInfo']['lang'] == "EN") $selectEN = "checked";
				elseif ($_SESSION['confInfo']['lang'] == "GE") $selectGE = "checked";
			}
			else $selectFR = "checked";

		?>
			<td class="tdComponent">Langue</td>
			<td class="tdValues">Fran&ccedil;ais <input type="radio" name="lang" value="FR" tabindex="9" <?php echo $selectFR; ?>> &nbsp;&nbsp;&nbsp;English <input type="radio" name="lang" value="EN" tabindex="9" <?php echo $selectEN; ?>> &nbsp;&nbsp;&nbsp;German <input type="radio" name="lang" value="GE" tabindex="9" <?php echo $selectGE; ?>></td>
		</tr>
		<tr>
			<td class="tdComponent">Timezone</td>
			<td class="tdValues"><input type="text" name="timezone" value="<?php echo  isset($_SESSION['confInfo']['timezone']) ? $_SESSION['confInfo']['timezone'] : 'Europe/Paris'?>" tabindex="7"> <span class="rouge">*</span></td>
		</tr>
	</table>
	<br/>

	<input type="hidden" name="endSetup" />
	<input type="hidden" name="numEtape" value="6" />
	<input type="button" value="Suivant" onclick="checkSubmit()"/>

	<br/><br/><br/>
	<font size="1"><span class="rouge">*</span> S&eacute;lectionnez le Timezone correspondant ici: <a href="http://www.php.net/manual/en/timezones.php" target="_blank">PHP Manual: Timezone</a>.</font>
</form>
<?php
	}
}
elseif ($numEtape == 6) {
	if (insertAdmin($_SESSION["dbInfo"]["dbHostName"],$_SESSION["dbInfo"]["dbName"],$_SESSION["dbInfo"]["dbUserName"],$_SESSION["dbInfo"]["dbPassword"],$_SESSION['confInfo']['adminLogin'],$_SESSION['confInfo']['adminPassword'])) {
?>
		Compte Administrateur cr&eacute;&eacute;.
<?php
	}
	else echo $_SESSION['error'];
?>
	<br/><br/>
<?php
	if(writeOptConfFile($_SESSION["confInfo"]["adminLogin"],$_SESSION["confInfo"]["dateDebut"],$_SESSION["confInfo"]["accesVisiteur"],$_SESSION["confInfo"]["exportPDF"],$_SESSION["confInfo"]["lang"],$_SESSION["confInfo"]["timezone"])) {
	$_SESSION["dbInfo"] = array();
	$_SESSION["confInfo"] = array();
?>
		Fichier d'options cr&eacute;&eacute;.
		<br/><br/><br/><br/>
		Si vous voulez modifier le logo &agrave; gauche, modifiez le fichier '/images/companyLogo.png'.
		<br/><br/>
		<input type="button" value="Acc&eacute;der au site" onclick="window.location.href='../index.php'" />
<?php
	}
	else echo $_SESSION['error'];
}
?>

