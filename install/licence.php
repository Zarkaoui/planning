<?php
/**************************************
 Code provenant de: 
 Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 Derniere modification: 03-03-2011

**************************************

Modifie par PRIN Jean-Charles

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

$licenseFilePath = "../LICENCE/gpl-3.0.txt";

$fh = fopen( $licenseFilePath, 'r' ) or die( "File not found !" );
$licenseFile = fread($fh,filesize($licenseFilePath));
fclose( $fh );
?>

<script language="JavaScript">
function licenseAccept() {
	document.formLicence.submit();
}
</script>
<form name="formLicence" method="post" action="setup.php">
	<p>Veuillez accepter la licence ci-dessous afin de proc&eacute;der &agrave; l'installation </p>
    	<textarea cols="80" rows="20" readonly tabindex="1"><?php echo $licenseFile?></textarea><br /><br />

	<input type="hidden" name="licenceok" value="ok" />
    	<input class="button" type="button" value="Annuler" onclick="cancel();" >
	<input type="button" onClick='licenseAccept();' value="Accepter" >
</form>

