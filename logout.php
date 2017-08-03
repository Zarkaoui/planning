<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 17-12-2010
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

session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session s'il existe
if (isset($_COOKIE[session_name("authabsences")])) {
    setcookie(session_name("authabsences"), '', time()-42000, '/');
}

unset($_COOKIE[session_name("authabsences")]);

// Finalement, on détruit la session.
session_unset();
session_destroy();

header("Location: login.php?erreur=logout");

?>
