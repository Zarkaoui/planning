<?
/**************************************
 Cree le: 02-07-2012
 Derniere modification: 24-12-2012
 Cree par: JC Prin thanks to Andreas Woll
 Source: http://sourceforge.net/projects/planningabsence/forums/forum/1696414/topic/5397582
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
along with this program.  If not, see &lt;<a href="http://www.gnu.org/licenses/&gt">http://www.gnu.org/licenses/&gt</a>;.

******************************************************************************/

//Months Array
$tabMonth = array (1=>"Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "October", "November", "Dezember");
//Days Array
$tabDay = array (1=>"Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");

//TITLE attribute for index page
define('LANG_TITLE',"Abwesenheiten- und Urlaubsverwaltung");

//Pages Titles
define('TITRE_PAGE_ACCUEIL',"Hauptmen&uuml;");
define('TITRE_PAGE_ENTGEN',"Generelle Firmeninformationen");
define('TITRE_PAGE_LISTEEMP',"Liste der Angestellten");
define('TITRE_PAGE_FICHEEMP',"Angestelltenkarte");
define('TITRE_PAGE_FERIES',"Feiertage");
define('TITRE_PAGE_LISTEABS',"Abwesenheiten");
define('TITRE_PAGE_MODIFABS',"Abwesenheit &auml;ndern");
define('TITRE_PAGE_CALABS',"Abwesenheitenkalender");
define('TITRE_PAGE_SUCC',"Zweigstellen");
define('TITRE_PAGE_SUCCGEST',"Zweigstellen: Verwaltung");
define('TITRE_PAGE_POSTES',"Jobs");
define('TITRE_PAGE_LISTUTIL',"Nutzerliste");
define('TITRE_PAGE_ADDUTIL',"Benutzer: Hinzuf&uuml;gen");
define('TITRE_PAGE_GESTUTIL',"Benutzer: Rechte");
define('TITRE_PAGE_ADDEMP',"Mitarbeiter hinzuf&uuml;gen");
define('TITRE_PAGE_MODEMP',"Mitarbeiter &auml;ndern");
define('TITRE_PAGE_AFFABS',"Abwesenheit(en) eintragen");
define('TITRE_PAGE_TYPEABS',"Abwesenheiten - Arten");
define('TITRE_PAGE_SECTS',"Bereiche");
define('TITRE_PAGE_PERIODICITE',"Frequenzen");

//Home Page
define('LANG_BIENVENUE',"Willkommen");
define('LANG_MESSAGE_ACCUEIL',"Willkommen am Webinterface der Abwesenheiten- und Urlaubsverwaltung.");
define('LANG_ANNIV',"Falls Geburtstage eingepflegt sind, vergesst nicht zu gratulieren ");

//Page Login
define('LANG_LOGIN',"Login");
define('LANG_LOGIN_TITLE',"Abwesenheiten- und Urlaubsverwaltung");
define('LANG_LOGIN_CONNEXION',"Login");
define('LANG_LOGIN_MDP',"Passwort");
define('LANG_LOGIN_EFFACER',"L&ouml;schen");
define('LANG_LOGIN_ACCES_VISIT',"Besucherzugang");
define('LANG_LOGIN_BADLOG',"unbekannter Nutzername oder falsches Passwort");
define('LANG_LOGIN_UTIL_DESACT',"Dieser Benutzer ist gesperrt");
define('LANG_LOGIN_DECO',"Logout OK");

//Statut Employes
define('LANG_PT',"Vollzeit");
define('LANG_MT',"Teilzeit");
define('LANG_AP',"Azubi");
define('LANG_ST',"Intern");


//Autres
define('LANG_OUI',"Ja");
define('LANG_NON',"Nein");
define('LANG_ENT',"Firma");
define('LANG_ENTGEN',"Generell");
define('LANG_ENTSUCS',"Zweigstellen");
define('LANG_SUCCS2',"Zweigstelle(n)");
define('LANG_ENTSUC',"Branche");
define('LANG_POSTES',"Jobs");
define('LANG_POSTE',"Job");
define('LANG_FONCTS',"Funktionen");
define('LANG_FONCT',"Funktion");
define('LANG_CAT',"Kategorie");
define('LANG_UTILS',"Benutzer");
define('LANG_UTIL',"Benutzer");
define('LANG_LIST',"Liste");
define('LANG_ADD',"Hinzuf&uuml;gen");
define('LANG_SUPPR',"L&ouml;schen");
define('LANG_DROITS',"Rechteverwaltung");
define('LANG_EMPS',"Angestellte");
define('LANG_EMP',"Angestellte/r");
define('LANG_ABSS',"Abwesenheiten");
define('LANG_JFERIES',"Feiertage");
define('LANG_FERIE',"Feiertag");
define('LANG_ASSIGNABS',"Abwesenheitsplanung");
define('LANG_LISTABSS',"Abwesenheitsliste&nbsp;");
define('LANG_CAL',"Kalender");
define('LANG_FIN_SESSION',"Logout");
define('LANG_MODIFS_OK',"&auml;nderungen durchgef&uuml;hrt");
define('LANG_MODIFS_NOK',"&auml;nderungen verworfen");
define('LANG_ADD_OK',"Hinzugef&uuml;gt");
define('LANG_ADD_NOK',"Hinzuf&uuml;gen verworfen");
define('LANG_SUPPR_OK',"Gel&ouml;scht!");
define('LANG_SUPPR_NOK',"L&ouml;schen Fehler !");
define('LANG_SUPPR_NOK2',"Teilfehler beim L&ouml;schen !");
define('LANG_ENT_NOM',"Firmenname");
define('LANG_TEL',"Telefonnummer");
define('LANG_FAX',"Fax");
define('LANG_ADR',"Adresse");
define('LANG_CP',"PLZ");
define('LANG_VILLE',"Stadt");
define('LANG_COMMS',"Bemerkungen");
define('LANG_COMM',"Bemerkung");
define('LANG_DE',"von");
define('LANG_A',"bis");
define('LANG_DEBUT',"anfang");
define('LANG_FIN',"ende");
define('LANG_MODIF',"&Auml;ndern");
define('LANG_ANNUL',"Abbrechen");
define('LANG_NOM',"Name");
define('LANG_NOM_FAM',"Nachname");
define('LANG_PRENOM',"Vorname");
define('LANG_ACTIF',"Aktiv");
define('LANG_ACTIFS',"Aktiv");
define('LANG_ACTIVE',"Aktiv");
define('LANG_EFFECTIF',"Personal");
define('LANG_NO_SUCC',"Keine Zweigstelle angelegt");
define('LANG_NO_DONNEES',"Keine Daten");
define('LANG_NO_UTILS',"Keine Benutzer !!");
define('LANG_NO_EMP',"Kein Angestellter !!");
define('LANG_AUCUN',"Nichts");
define('LANG_TOUS',"Alles");
define('LANG_TOUTES',"Alles");
define('LANG_SECT',"Bereich");
define('LANG_SECTS',"Bereiche");
define('LANG_PERIO',"Frequenzen");
define('LANG_ADMSECT',"Admin. Bereich");
define('LANG_ADMGEN',"Admin. Generell");
define('LANG_UTIL_MODIF',"Benutzer: &auml;ndern");
define('LANG_UTIL_ADD',"Benutzer: hinzuf&uuml;gen");
define('LANG_SUCC_MODIF',"Branches: Changing");
define('LANG_SUCC_ADD',"Zweigstellen: hinzuf&uuml;gen");
define('LANG_MDP',"Passwort");
define('LANG_MDP_REPET',"Password (wiederholen)");
define('LANG_ADMIN_SECT',"Bereichsleiter");
define('LANG_ADMIN_SYST',"Systembetreuer");
define('LANG_SOLDE',"Ausgleich");
define('LANG_PRIS',"genommen");
define('LANG_LOCALIS',"Ort");
define('LANG_SELECT',"Ausw&auml;hlen");
define('LANG_EMP_MOD',"Angestellter: &auml;ndern");
define('LANG_EMP_ADD',"Angestellter;: hinzuf&uuml;gen");
define('LANG_DATE_NAISS',"Geburtsdatum");
define('LANG_STATUT',"Status");
define('LANG_TRAVALE',"Arbeitet an ");
define('LANG_NB_CONGES_COURS',"Urlaub f&uuml;r das laufende Jahr");
define('LANG_NB_CONGES_REPORT',"Nb deferal holidays");
define('LANG_DATE_ARRIVEE',"Einstellungsdatum");
define('LANG_DATE_DEPART',"ausgeschieden am:");
define('LANG_DATE_DEBUT',"Startdatum");
define('LANG_DATE_FIN',"Enddatum");
define('LANG_MATIN',"Morgen");
define('LANG_APRESMIDI',"Mittag");
define('LANG_DEMI_JOURN',"Halbtag");
define('LANG_EMP_NOSAMEDI',"Der ausgew&auml;hlte Mitarbeiter arbeitet Samstags nicht.");
define('LANG_EMP_NODIMANCHE',"Sie haben Sonntag ausgew&auml;hlt");
define('LANG_SEL_FERIE',"Sie haben einen Feiertag ausgew&auml;hlt");
define('LANG_ABS_PRES',"Abwesenheit in dieser Periode bereits vorhanden.");
define('LANG_JOURS',"Tage");
define('LANG_JOURNEE',"Tag");
define('LANG_PERIODICITE',"Frequenz");
define('LANG_TYPE_ABS',"Abwesenheitstypen");
define('LANG_TYPE',"Art");
define('LANG_ADD_FONCT',"Funktion hinzuf&uuml;gen");
define('LANG_ADD_CAT',"Kategorie hinzuf&uuml;gen");
define('LANG_INTITULE',"Titel");
define('LANG_EXPORT_PDF',"Kalender in PDF-Datei exportieren");
define('LANG_EXPORT_EXCEL',"Kalender in Excel-Datei exportieren");
define('LANG_MOIS',"Monat");
define('LANG_DATE',"Datum");
define('LANG_ANNEE',"Jahr");
define('LANG_ANNEES',"Jahre");
define('LANG_NO_EMPL_CRITERES',"Auf keinen Arbeitnehmer passen die gew&auml;hlten Kriterien");
define('LANG_ANCIENNETE',"Dienstalter");
define('LANG_CHAQUE_ANNEE',"Jedes Jahr");
define('LANG_NO_ABS_SEL',"Kein Abwesenheitseintrag ausgew&auml;hlt !");
define('LANG_ADD_PAR',"Hinzugef&uuml;gt von:");
define('LANG_ADD_LE',"Hinzuf&uuml;gen an:");
define('LANG_NO_CONGES',"Kein Urlaub");
define('LANG_FERMER',"Schliessen");
define('LANG_ERREUR_DEJA_PRESENT',"Dieser Tag ist bereits in der Liste !");
define('LANG_NO_JOURS_FERIES',"Keine Feiertage !!!!!");
define('LANG_COULEUR',"Farbe");
define('LANG_TYPE_SUPPR_IMPOSSIBLE',"Eintrag kann nicht (mehr) gel&ouml;scht werden. Es gibt Zuweisungen.");
define('LANG_NO_TYPES_ABS',"Keine Abwesenheitsart definiert !");
define('LANG_PRESENT',"Anwesend");
define('LANG_ABS_PARTIELLE',"halbtags abwesend");
define('LANG_WEEKEND',"Wochenende");
define('LANG_NO_SECT',"Kein Bereich definiert !");
define('LANG_SECT_SUPPR_IMPOSSIBLE',"Bereichseintrag kann nicht gel&ouml;scht werden. Mitarbeitereintr&auml;ge w&auml;ren betroffen.");
define('LANG_NO_PERIO',"Kein Frequenzeintrag definiert !");
define('LANG_PERIO_SUPPR_IMPOSSIBLE',"Frequenzeintrag kann nicht gel&ouml;scht werden. Miarbeitereintr&auml;ge w&auml;ren betroffen.");
define('LANG_ERREUR_CREER_EMPL',"Kann Mitarbeiterstammdaten nicht anlegen. Bitte geben Sie Werte ein f&uuml;r:&lt;br/>");
define('LANG_CHARGEMENT',"Laden ...");
define('LANG_AUJOURDHUI',"Heute");
define('LANG_OUVRIR_CAL',"Kalender &ouml;ffnen");
define('LANG_FICHE',"Karte");

define('LANG_ASTERIS',"Felder mit einem Stern &lt;span class=\"required\">*&lt;/span> markiert sind sind zwingend erforderlich.");
define('LANG_NO_ACCES',"Beschr&auml;nkter Bereich");

//PDF
define('LANG_PDF_TITRE',"Ferienplan");
define('LANG_PDF_PERIODE',"Periode");
define('LANG_PDF_SECT',"Bereich");
define('LANG_PDF_NO_EMPL_CRITERES',"Kein Mitarbeiter passt auf die Auswahl");
define('LANG_PDF_NOM',"Planen");
define('LANG_PDF_PRESENT',"Anwesend");
define('LANG_PDF_FERIE',"Feiertage");
define('LANG_PDF_WEEKEND',"Wochenende");
define('LANG_PDF_MATIN',"Morgen");
define('LANG_PDF_APRESMIDI',"Mittag");
define('LANG_PDF_NO_TYPES_ABS',"Art der Abwesenheit nicht definiert !");


//Messages Javascript
define('LANG_SAISIR_SOCNOM',"Bitte geben Sie einen Firmennamen an");
define('LANG_SAISIR_NOM',"Bitte geben Sie einen Namen an");
define('LANG_SAISIR_NOMFAM',"Bitte geben Sie einen Familiennamen an");
define('LANG_SAISIR_PRENOM',"Bitte geben Sie einen Vornamen an");
define('LANG_SAISIR_DATE_ARRIV',"Bitte geben Sie ein Einstellungsdatum an");
define('LANG_SAISIR_MDP',"Bitte geben Sie ein Passwort ein");
define('LANG_ERREUR_MDPS',"schlechte Passw&ouml;rter");
define('LANG_SAISIR_INTITULE',"Bitte geben Sie einen Titel ein");
define('LANG_SAISIR_JOURS',"Bitte geben Sie die Anzahl der Tage ein");
define('LANG_ERREUR_DATES',"Enddatum kleiner als Startdatum !");
define('LANG_ERREUR_SEL_EMP',"Keine Mitarbeiterauswahl getroffen");
define('LANG_ERREUR_SEL_ABS',"Keine Auswahl des Abwesenheitstyps getroffen");
define('LANG_ERREUR_MOD_ABS',"Keine Abwesenheit ausgew&auml;hlt");
define('LANG_ERREUR_SEL_DATE_DEBUT',"Bitte geben Sie ein Startdatum ein");
define('LANG_ERREUR_SEL_DATE_FIN',"Bitte geben Sie ein Enddatum ein");
define('LANG_ERREUR_SEL_TYPE',"Bitte w&auml;hlen Sie einen Abwesenheitstyp");
define('LANG_ERREUR_COULEUR',"Farbeintrag nicht g&uuml;ltig");
define('LANG_ERREUR_SEL_SECT',"Bitte w&auml;hlen Sie einen Bereich aus");
define('LANG_ERREUR_SEL_PERIO',"Bitte w&auml;hlen Sie eine Frequenz");

//MUST BE END OF FILE
?>
