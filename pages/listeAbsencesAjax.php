<?php
/**************************************
 Cree le: 25-05-2011
 Derniere modification: 26-05-2011
 Cree par: JC Prin
**************************************

Copyright (C) 2010-2011  PRIN Jean-Charles

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
require ("../include/config.php");
require ("../include/db.config.php");
require ("../include/db.class.php");

//connexion a la base
$db = new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

//autocompletion
if (isset($_REQUEST["champ_util"])) {
	
	$selLocalisation = $_REQUEST["lo"];
	$selSecteur = $_REQUEST["se"];
	$selAnnee = $_REQUEST["an"];
	$selMois = $_REQUEST["mo"];

	$util = $_REQUEST["champ_util"];

	$requeteUtil = $db->query("SELECT emp_id,emp_nom,emp_prenom FROM abs_employe								
					WHERE emp_actif = 1 AND (emp_nom LIKE '%$util%' OR emp_prenom LIKE '%$util%')
					ORDER BY emp_nom ASC");
	if ($db->numRows($requeteUtil) != 0) {	
		$nombreTotal = 0;
		echo '<table border="0" id="listeUtil">';
		for ($n = 0 ; $n < count($requeteUtil); $n++){
			echo "
			<tr id=\"miniFicheUtil\" onclick=\"document.location.replace('index.php?action=listAbs&amp;lo=$selLocalisation&amp;se=$selSecteur&amp;mo=$selMois&amp;an=$selAnnee&amp;utilid=".$requeteUtil[$n]["emp_id"]."');\" >
				<td class=\"left \">&nbsp;".utf8_encode($requeteUtil[$n]["emp_nom"])." ".utf8_encode($requeteUtil[$n]["emp_prenom"])."</td>
			</tr>
			";
			// on s'arrête si il y en a trop
			if (++$nombreTotal >= 10)
				die('<tr><td>...</td></tr>');
		}
		echo '</table>';
	}
}
