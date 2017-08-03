<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 07-06-2011
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
<br/><br/>
<div align="center">
	<div class="width800" >
		<div id="status"></div>
		<div class="outerbox">
			<div class="top">
				<div class="left"></div>
				<div class="right"></div>
				<div class="middle"></div>
			</div>
			<div class="maincontent">
		    		<div class="pageTitleLogin"><h2><?php echo LANG_BIENVENUE; ?></h2></div>
					<br/>
						<?php echo LANG_MESSAGE_ACCUEIL; ?><br/>
					<br/>
		<?php
					//Verification d'anniversaire
					$birthday = array();
					$birthday = checkBirthday($db);
					if (sizeof($birthday) != 0) {
						echo "<br/><br/><div align=\"center\"><img src=\"images/birthday.jpeg\"><br/><br/>".LANG_ANNIV." : <br/>";
						foreach($birthday as $valeur) echo utf8_encode($valeur)."<br/>";
						echo "</div><br/><br/>";
					}		
		?>
				<div class="bottom">
					<div class="left"></div>
					<div class="right"></div>
					<div class="middle"></div>
				</div>
			</div>
		</div>
	</div>
</div>
			
