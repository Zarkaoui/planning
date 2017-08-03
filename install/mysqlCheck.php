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


$checkDB = checkDB($_SESSION["dbInfo"]["dbHostName"],$_SESSION["dbInfo"]["dbName"],$_SESSION["dbInfo"]["dbIsCreated"],$_SESSION["dbInfo"]["dbUserName"],$_SESSION["dbInfo"]["dbPassword"],$_SESSION["dbInfo"]["dbPlanningUserName"],$_SESSION["dbInfo"]["dbPlanningPassword"]);

$checkUser = checkUser($_SESSION["dbInfo"]["dbHostName"],$_SESSION["dbInfo"]["dbName"],$_SESSION["dbInfo"]["dbUserName"],$_SESSION["dbInfo"]["dbPassword"],$_SESSION["dbInfo"]["dbPlanningUserName"],$_SESSION["dbInfo"]["dbPlanningPassword"]);

if (!$checkDB || !$checkUser) {
?>
	<h3>ERREUR</h3>
	<br/>
<?php	echo $_SESSION['error'];	?>
	<br/>
	<input type="button" value="Retour" onclick="back();"/>
<?php
}
else {
	if(writeDBConfFile($_SESSION["dbInfo"]["dbHostName"],$_SESSION["dbInfo"]["dbName"],$_SESSION["dbInfo"]["dbPlanningUserName"],$_SESSION["dbInfo"]["dbPlanningPassword"])) {

		if ($_SESSION["dbInfo"]["dbIsCreated"] == 1) $action = "s&eacute;lectionn&eacute;e";
		else $action = "cr&eacute;&eacute;e";
?>
		<h3>OK</h3>
		<br/>

		Base '<?php echo $_SESSION["dbInfo"]["dbName"]."' ".$action ?>.

		<br/><br/>
		<form name="formMysqlCheck" method="post" action="setup.php">
			<input type="hidden" name="numEtape" value="4" />
			<input type="submit" value="Continuer" />
		</form>
<?php
	}
	else {
?>
		<h3>ERREUR</h3>
		<br/>
		Erreur lors de l'&eacute;criture dans le fichier 'db.conf.php'. <br/>
<?php
	}
}
?>

