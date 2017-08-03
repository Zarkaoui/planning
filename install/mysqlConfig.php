<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 03-03-2011
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

?>
<script type="text/javascript">
	function checkSubmit() {

		var ok = true;
		if (document.formMysqlConfig.dbHostName.value == "") {
			alert("Entrez un nom d'hote");
			ok = false;
		}
		if (document.formMysqlConfig.dbName.value == "" && ok) {
			alert("Entrez un nom de base");
			ok = false;
		}
		if (document.formMysqlConfig.dbUserName.value == "" && ok) {
			alert("Entrez un nom d'utilisateur avec privilèges");
			ok = false;
		}
		if (document.formMysqlConfig.dbPassword.value == "" && ok) {
			alert("Saisissez un mot de passe utilisateur");
			ok = false;
		}
		if (document.formMysqlConfig.dbPlanningUserName.value == "" && ok) {
			alert("Entrez un nom d'utilisateur pour la base");
			ok = false;
		}
		if ( document.formMysqlConfig.dbPlanningPassword.value == "" && ok) {
			alert("Saisissez un mot de passe");
			ok = false;
		}
		if (document.formMysqlConfig.dbPlanningPassword.value != document.formMysqlConfig.dbPlanningPassword2.value && ok) {
			alert("Erreur de saisie des mots de passe" );
			ok = false;
		}
		
		if (ok) document.formMysqlConfig.submit();
	}
</script>

<?php
	$filename = "../include/db.config.php";
	if (!is_writable($filename)) {
		echo "<br/>Veillez &agrave; bien donner les droits en &eacute;criture au fichier 'include/db.conf.php' !!! <br/><br/>
			<input type=\"button\" onclick=\"location.reload();\" value=\"C'est Fait !\" /><br/><br/>
		";
	}
	else {
?>
<form name="formMysqlConfig" method="post" action="setup.php">

	 <table cellpadding="0" cellspacing="0" border="0" class="table">
		<tr>
			<th colspan="3" >Configuration</th>                
		</tr>
		<tr>
			<td class="tdComponent">Nom d'h&ocirc;te</td>
			<td class="tdValues"><input type="text" name="dbHostName" value="<?php echo  isset($_SESSION['dbInfo']['dbHostName']) ? $_SESSION['dbInfo']['dbHostName'] : 'localhost'?>" tabindex="1" ></td>
		</tr>
		<tr>
			<td class="tdComponent">Nom de la base</td>
			<td class="tdValues"><input type="text" name="dbName" value="<?php echo  isset($_SESSION['dbInfo']['dbName']) ? $_SESSION['dbInfo']['dbName'] : 'db_planning'?>" tabindex="3"></td>
		</tr>
		<tr>
		<?php
			$selectYes = "";
			$selectNo = "";
			
			if (isset($_SESSION['dbInfo']['dbIsCreated'])) {
				if ($_SESSION['dbInfo']['dbIsCreated'] == 1) $selectYes = "checked";
				else $selectNo = "checked";
			}
			else $selectNo = "checked";

		?>
			<td class="tdComponent">La base est d&eacute;j&agrave; cr&eacute;&eacute;e</td>
			<td class="tdValues">Oui <input type="radio" name="dbIsCreated" value="1" tabindex="9" <?php echo $selectYes; ?>> &nbsp;&nbsp;&nbsp;Non <input type="radio" name="dbIsCreated" value="0" tabindex="9" <?php echo $selectNo; ?>></td>
		</tr>
		<tr>
			<td class="tdComponent">Utilisateur avec privil&egrave;ges</td>
			<td class="tdValues"><input type="text" name="dbUserName" value="<?php echo  isset($_SESSION['dbInfo']['dbUserName']) ? $_SESSION['dbInfo']['dbUserName'] : 'root'?>" tabindex="4"> <span class="rouge">*</span></td>
		</tr>
		<tr>
			<td class="tdComponent">Mot de passe de l'utilisateur avec privil&egrave;ges</td>
			<td class="tdValues"><input type="password" name="dbPassword" value="<?php echo  isset($_SESSION['dbInfo']['dbPassword']) ? $_SESSION['dbInfo']['dbPassword'] : ''?>" tabindex="5" > <span class="rouge">*</span></td>
		</tr>
		<tr>
			<td class="tdComponent">Utilisateur de la base du Planning Absences</td>
			<td class="tdValues"><input type="text" name="dbPlanningUserName" value="<?php echo  isset($_SESSION['dbInfo']['dbPlanningUserName']) ? $_SESSION['dbInfo']['dbPlanningUserName'] : 'planninguser'?>" tabindex="7"> </td>
		</tr>
		<tr>
			<td class="tdComponent">Mot de passe de l'utilisateur</td>
			<td class="tdValues"><input type="password" name="dbPlanningPassword" value="<?php echo  isset($_SESSION['dbInfo']['dbPlanningPassword']) ? $_SESSION['dbInfo']['dbPlanningPassword'] : ''?>" tabindex="8"> </td>
		</tr>
		<tr>
			<td class="tdComponent">Mot de passe de l'utilisateur (r&eacute;p&eacute;ter)</td>
			<td class="tdValues"><input type="password" name="dbPlanningPassword2" value="<?php echo  isset($_SESSION['dbInfo']['dbPlanningPassword']) ? $_SESSION['dbInfo']['dbPlanningPassword'] : ''?>" tabindex="8"> </td>
		</tr>
	</table>
	<br/>

	<input type="hidden" name="mysqlConfig" />
	<input type="hidden" name="numEtape" value="3" />
	<input type="button" value="Retour" onclick="back();" tabindex="11"/>
	<input type="button" value="Suivant" onclick="checkSubmit()" tabindex="10"/>

	<br/><br/>
	<font size="1"><span class="rouge">*</span> L'utilisateur avec privil&egrave;ges doit avoir les droits de cr&eacute;er des bases, des tables et des utilisateurs, ainsi que d'ins&eacute;rer des donn&eacute;es dans des tables.</font>

</form>
<?php
}
?>

