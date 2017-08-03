<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 24-12-2012
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

//Months Array
$tabMonth = array (1=>"January", "February", "March", "April", "May", "June", "July", "	August", "September", "October", "November", "December");
//Days Array
$tabDay = array (1=>"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

//TITLE attribute for index page
define('LANG_TITLE',"Absences and Holidays Management");

//Pages Titles
define('TITRE_PAGE_ACCUEIL',"Home");
define('TITRE_PAGE_ENTGEN',"General informations about the company");
define('TITRE_PAGE_LISTEEMP',"List of employees");
define('TITRE_PAGE_FICHEEMP',"Employee card");
define('TITRE_PAGE_FERIES',"Public holidays");
define('TITRE_PAGE_LISTEABS',"Absences list");
define('TITRE_PAGE_MODIFABS',"Absences modification");
define('TITRE_PAGE_CALABS',"Absences calendar");
define('TITRE_PAGE_SUCC',"Branches");
define('TITRE_PAGE_SUCCGEST',"Branches: Management");
define('TITRE_PAGE_POSTES',"Jobs");
define('TITRE_PAGE_LISTUTIL',"List of users");
define('TITRE_PAGE_ADDUTIL',"Users: Add");
define('TITRE_PAGE_GESTUTIL',"Users: Rights Management");
define('TITRE_PAGE_ADDEMP',"Adding employee");
define('TITRE_PAGE_MODEMP',"Employee's modification");
define('TITRE_PAGE_AFFABS',"Absence Assignment");
define('TITRE_PAGE_TYPEABS',"Type of absence");
define('TITRE_PAGE_SECTS',"Sectors");
define('TITRE_PAGE_PERIODICITE',"Frequencies");

//Home Page
define('LANG_BIENVENUE',"Welcome");
define('LANG_MESSAGE_ACCUEIL',"Welcome to the web interface of Absence Management system.");
define('LANG_ANNIV',"Do not forget to wish a Happy Birthday to: ");

//Page Login
define('LANG_LOGIN',"Login");
define('LANG_LOGIN_TITLE',"Absence Management");
define('LANG_LOGIN_CONNEXION',"Login");
define('LANG_LOGIN_MDP',"Password");
define('LANG_LOGIN_EFFACER',"Erase");
define('LANG_LOGIN_ACCES_VISIT',"Visitor Access");
define('LANG_LOGIN_BADLOG',"Bad login or password");
define('LANG_LOGIN_UTIL_DESACT',"This user is disabled");
define('LANG_LOGIN_DECO',"Logout OK");

//Statut Employes
define('LANG_PT',"Full Time");
define('LANG_MT',"Partial time");
define('LANG_AP',"Apprentice");
define('LANG_ST',"Intern");


//Autres
define('LANG_OUI',"Yes");
define('LANG_NON',"No");
define('LANG_ENT',"Company");
define('LANG_ENTGEN',"General");
define('LANG_ENTSUCS',"Branches");
define('LANG_SUCCS2',"Branche(s)");
define('LANG_ENTSUC',"Branche");
define('LANG_POSTES',"Jobs");
define('LANG_POSTE',"Job");
define('LANG_FONCTS',"Functions");
define('LANG_FONCT',"Function");
define('LANG_CAT',"Category");
define('LANG_UTILS',"Users");
define('LANG_UTIL',"User");
define('LANG_LIST',"List");
define('LANG_ADD',"Add");
define('LANG_SUPPR',"Delete");
define('LANG_DROITS',"Managing rights");
define('LANG_EMPS',"Employees");
define('LANG_EMP',"Employee");
define('LANG_ABSS',"Absences");
define('LANG_JFERIES',"Public holidays");
define('LANG_FERIE',"Public holiday");
define('LANG_ASSIGNABS',"Absence assignment");
define('LANG_LISTABSS',"List Absences&nbsp;");
define('LANG_CAL',"Calendar");
define('LANG_FIN_SESSION',"Logout");
define('LANG_MODIFS_OK',"Changes performed");
define('LANG_MODIFS_NOK',"Changes canceled");
define('LANG_ADD_OK',"Added performed");
define('LANG_ADD_NOK',"Added canceled");
define('LANG_SUPPR_OK',"Deletion carried");
define('LANG_SUPPR_NOK',"Error when deleting !");
define('LANG_SUPPR_NOK2',"Partial error when deleting !");
define('LANG_ENT_NOM',"Company Name");
define('LANG_TEL',"Phone number");
define('LANG_FAX',"Fax");
define('LANG_ADR',"Address");
define('LANG_CP',"Zip Code");
define('LANG_VILLE',"City");
define('LANG_COMMS',"Comments");
define('LANG_COMM',"Comment");
define('LANG_DE',"From");
define('LANG_A',"To");
define('LANG_DEBUT',"start");
define('LANG_FIN',"end");
define('LANG_MODIF',"Change");
define('LANG_ANNUL',"Cancel");
define('LANG_NOM',"Name");
define('LANG_NOM_FAM',"Surname");
define('LANG_PRENOM',"First name");
define('LANG_ACTIF',"Active");
define('LANG_ACTIFS',"Active");
define('LANG_ACTIVE',"Active");
define('LANG_EFFECTIF',"Staff");
define('LANG_NO_SUCC',"No branch declared");
define('LANG_NO_DONNEES',"No data");
define('LANG_NO_UTILS',"No users !!");
define('LANG_NO_EMP',"No employee !!");
define('LANG_AUCUN',"None");
define('LANG_TOUS',"All");
define('LANG_TOUTES',"All");
define('LANG_SECT',"Sector");
define('LANG_SECTS',"Sectors");
define('LANG_PERIO',"Frequencies");
define('LANG_ADMSECT',"Admin. Sector");
define('LANG_ADMGEN',"Admin. General");
define('LANG_UTIL_MODIF',"User: Changing");
define('LANG_UTIL_ADD',"User: Add");
define('LANG_SUCC_MODIF',"Branches: Changing");
define('LANG_SUCC_ADD',"Branches: Add");
define('LANG_MDP',"Password");
define('LANG_MDP_REPET',"Password (repeat)");
define('LANG_ADMIN_SECT',"Sector Manager");
define('LANG_ADMIN_SYST',"system Manager");
define('LANG_SOLDE',"Balance");
define('LANG_PRIS',"Taken");
define('LANG_LOCALIS',"Location");
define('LANG_SELECT',"Select");
define('LANG_EMP_MOD',"Employee: Changing");
define('LANG_EMP_ADD',"Employee;: Add");
define('LANG_DATE_NAISS',"Date of Birth");
define('LANG_STATUT',"Statut");
define('LANG_TRAVALE',"Works on ");
define('LANG_NB_CONGES_COURS',"Nb holidays for the year");
define('LANG_NB_CONGES_REPORT',"Nb deferal holidays");
define('LANG_DATE_ARRIVEE',"Arrival date");
define('LANG_DATE_DEPART',"Departure date");
define('LANG_DATE_DEBUT',"Start Date");
define('LANG_DATE_FIN',"End Date");
define('LANG_MATIN',"Morning");
define('LANG_APRESMIDI',"Afternoon");
define('LANG_DEMI_JOURN',"Half day");
define('LANG_EMP_NOSAMEDI',"the selected employee does not work on Saturday");
define('LANG_EMP_NODIMANCHE',"you have selected a Sunday");
define('LANG_SEL_FERIE',"you have selected a public holiday");
define('LANG_ABS_PRES',"absence is already present for this period");
define('LANG_JOURS',"days");
define('LANG_JOURNEE',"Day");
define('LANG_PERIODICITE',"Frequency");
define('LANG_TYPE_ABS',"Type of absence");
define('LANG_TYPE',"Type");
define('LANG_ADD_FONCT',"Add Function");
define('LANG_ADD_CAT',"Add Category");
define('LANG_INTITULE',"Title");
define('LANG_EXPORT_PDF',"Export the calendar in PDF file");
define('LANG_EXPORT_EXCEL',"Export the calendar in Excel file");
define('LANG_MOIS',"Month");
define('LANG_DATE',"Date");
define('LANG_ANNEE',"Year");
define('LANG_ANNEES',"Years");
define('LANG_NO_EMPL_CRITERES',"No employee meets the criteria specified");
define('LANG_ANCIENNETE',"Seniority");
define('LANG_CHAQUE_ANNEE',"Every Year");
define('LANG_NO_ABS_SEL',"No absence selected !");
define('LANG_ADD_PAR',"Add by");
define('LANG_ADD_LE',"Add on");
define('LANG_NO_CONGES',"No leave");
define('LANG_FERMER',"Close");
define('LANG_ERREUR_DEJA_PRESENT',"This day is already present in the list !");
define('LANG_NO_JOURS_FERIES',"No public Holiday !!!!!");
define('LANG_COULEUR',"Color");
define('LANG_TYPE_SUPPR_IMPOSSIBLE',"Type of leave cannot be deleted: there is some assignments.");
define('LANG_NO_TYPES_ABS',"No type of absence defined !");
define('LANG_PRESENT',"Present");
define('LANG_ABS_PARTIELLE',"Partial absence");
define('LANG_WEEKEND',"Week-end");
define('LANG_NO_SECT',"No sector defined !");
define('LANG_SECT_SUPPR_IMPOSSIBLE',"Sector cannot be deleted: employees are affected.");
define('LANG_NO_PERIO',"No frequency defined !");
define('LANG_PERIO_SUPPR_IMPOSSIBLE',"Frequency cannot be deleted: employees are affected.");
define('LANG_ERREUR_CREER_EMPL',"Can't create employee, please enter values for:<br/>");
define('LANG_CHARGEMENT',"Loading ...");
define('LANG_AUJOURDHUI',"Today");
define('LANG_OUVRIR_CAL',"Open calendar");
define('LANG_FICHE',"Card");

define('LANG_ASTERIS',"Fields marked with an asterisk <span class=\"required\">*</span> are required.");
define('LANG_NO_ACCES',"Restricted area");

//PDF
define('LANG_PDF_TITRE',"Holiday schedule");
define('LANG_PDF_PERIODE',"Period");
define('LANG_PDF_SECT',"Sector");
define('LANG_PDF_NO_EMPL_CRITERES',"No employee meets the criteria specified");
define('LANG_PDF_NOM',"Planning");
define('LANG_PDF_PRESENT',"Present");
define('LANG_PDF_FERIE',"Public Holiday");
define('LANG_PDF_WEEKEND',"Week End");
define('LANG_PDF_MATIN',"Morning");
define('LANG_PDF_APRESMIDI',"Afternoon");
define('LANG_PDF_NO_TYPES_ABS',"No type of absence defined !");


//Messages Javascript
define('LANG_SAISIR_SOCNOM',"Please enter a company name");
define('LANG_SAISIR_NOM',"Please enter a name");
define('LANG_SAISIR_NOMFAM',"Please enter the name");
define('LANG_SAISIR_PRENOM',"Please enter the first name");
define('LANG_SAISIR_DATE_ARRIV',"Please enter arrival date");
define('LANG_SAISIR_MDP',"Please enter password");
define('LANG_ERREUR_MDPS',"Bad passwords");
define('LANG_SAISIR_INTITULE',"Please enter a title");
define('LANG_SAISIR_JOURS',"Please enter a number for days");
define('LANG_ERREUR_DATES',"End Date less than the Start date !");
define('LANG_ERREUR_SEL_EMP',"No selection of Employee");
define('LANG_ERREUR_SEL_ABS',"No selection of type of absence");
define('LANG_ERREUR_MOD_ABS',"No absence selected");
define('LANG_ERREUR_SEL_DATE_DEBUT',"Please enter the start date");
define('LANG_ERREUR_SEL_DATE_FIN',"Please enter the end date");
define('LANG_ERREUR_SEL_TYPE',"Please select a type of absence");
define('LANG_ERREUR_COULEUR',"Color entry is invalid");
define('LANG_ERREUR_SEL_SECT',"Please select a sector");
define('LANG_ERREUR_SEL_PERIO',"Please select frequency");

//MUST BE END OF FILE
?>
