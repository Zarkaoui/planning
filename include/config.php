<?php

//Langue
define('LANG', 'FR');

if (phpversion() >= 5.1) {
//Fuseau Horaire
date_default_timezone_set('Europe/Paris');
}

//mode debug
define('DEBUG', FALSE);

//Acces Visiteur
define('ACCES_VISITEUR', TRUE);

//Premiere Annee d'utilisation
define('FIRST_YEAR', '2017');

//Login Administrateur
define('LOGIN_ADMIN','administrateur');

//Export PDF du calendrier
define('EXPORT_PDF', TRUE);

//Export Excel du calendrier
define('EXPORT_EXCEL', TRUE);

?>
