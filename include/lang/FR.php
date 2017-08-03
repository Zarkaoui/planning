<?php
/**************************************
 Cree le: 03-03-2011
 Derniere modification: 28-12-2012
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

//Tableau de Mois
$tabMonth = array (1=>"Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t", "Septembre", "Octobre", "Novembre", "D&eacute;cembre");
//Tableau de Jours
$tabDay = array (1=>"Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");

//Attribut TITLE de la page index
define('LANG_TITLE',"Gestion des Cong&eacute;s et Absences");

//Titres Pages
define('TITRE_PAGE_ACCUEIL',"Accueil");
define('TITRE_PAGE_ENTGEN',"Informations g&eacute;n&eacute;rales sur l'entreprise");
define('TITRE_PAGE_LISTEEMP',"Liste des employ&eacute;s");
define('TITRE_PAGE_FICHEEMP',"Fiche Employ&eacute;");
define('TITRE_PAGE_FERIES',"Jours F&eacute;ri&eacute;s");
define('TITRE_PAGE_LISTEABS',"Liste des Absences");
define('TITRE_PAGE_MODIFABS',"Modification d'une Absence");
define('TITRE_PAGE_CALABS',"Calendrier des Absences");
define('TITRE_PAGE_SUCC',"Succursales");
define('TITRE_PAGE_SUCCGEST',"Succursales: Gestion");
define('TITRE_PAGE_POSTES',"Postes");
define('TITRE_PAGE_LISTUTIL',"Liste des Utilisateurs");
define('TITRE_PAGE_ADDUTIL',"Utilisateurs: Ajout");
define('TITRE_PAGE_GESTUTIL',"Utilisateurs: Gestion des droits");
define('TITRE_PAGE_ADDEMP',"Ajout d'employ&eacute;");
define('TITRE_PAGE_MODEMP',"Modification d'employ&eacute;");
define('TITRE_PAGE_AFFABS',"Affectation d'Absence");
define('TITRE_PAGE_TYPEABS',"Type d'absences");
define('TITRE_PAGE_SECTS',"Secteurs");
define('TITRE_PAGE_PERIODICITE',"P&eacute;riodicit&eacute;s");

//Page Accueil
define('LANG_BIENVENUE',"Bienvenue");
define('LANG_MESSAGE_ACCUEIL',"Bienvenue dans l'interface Web simplifi&eacute;e de gestion des Absences.");
define('LANG_ANNIV',"N'oubliez pas de souhaiter un Bon Anniversaire &agrave;");

//Page Login
define('LANG_LOGIN',"Identifiant");
define('LANG_LOGIN_TITLE',"Gestion des Absences v$app_version");
define('LANG_LOGIN_CONNEXION',"Connexion [$connexion]");
define('LANG_LOGIN_MDP',"Mot de passe");
define('LANG_LOGIN_EFFACER',"Effacer");
define('LANG_LOGIN_ACCES_VISIT',"Acc&egrave;s Visiteur");
define('LANG_LOGIN_BADLOG',"Mauvais login ou mot de passe");
define('LANG_LOGIN_UTIL_DESACT',"L'utilisateur entr&eacute; est d&eacute;sactiv&eacute;");
define('LANG_LOGIN_DECO',"D&eacute;connexion effectu&eacute;e");

//Statut Employes
define('LANG_PT',"Plein Temps");
define('LANG_MT',"Mi Temps");
define('LANG_AP',"Apprenti");
define('LANG_ST',"Stagiaire");


//Autres
define('LANG_OUI',"Oui");
define('LANG_NON',"Non");
define('LANG_ENT',"Entreprise");
define('LANG_ENTGEN',"G&eacute;n&eacute;rale");
define('LANG_ENTSUCS',"Succursales");
define('LANG_SUCCS2',"Succursale(s)");
define('LANG_ENTSUC',"Succursale");
define('LANG_POSTES',"Postes");
define('LANG_POSTE',"Poste");
define('LANG_FONCTS',"Fonctions");
define('LANG_FONCT',"Fonction");
define('LANG_CAT',"Cat&eacute;gorie");
define('LANG_UTILS',"Utilisateurs");
define('LANG_UTIL',"Utilisateur");
define('LANG_LIST',"Lister");
define('LANG_ADD',"Ajouter");
define('LANG_SUPPR',"Supprimer");
define('LANG_DROITS',"G&eacute;rer les droits");
define('LANG_EMPS',"Employ&eacute;s");
define('LANG_EMP',"Employ&eacute;");
define('LANG_ABSS',"Absences");
define('LANG_JFERIES',"Jours F&eacute;ri&eacute;s");
define('LANG_FERIE',"F&eacute;ri&eacute;");
define('LANG_ASSIGNABS',"Assigner Absence&nbsp;");
define('LANG_LISTABSS',"Liste des Absences&nbsp;");
define('LANG_CAL',"Calendrier");
define('LANG_FIN_SESSION',"Fin de session");
define('LANG_MODIFS_OK',"Modifications effectu&eacute;es");
define('LANG_MODIFS_NOK',"Modifications annul&eacute;es");
define('LANG_ADD_OK',"Ajout effectu&eacute;");
define('LANG_ADD_NOK',"Ajout annul&eacute;");
define('LANG_SUPPR_OK',"Suppression effectu&eacute;e");
define('LANG_SUPPR_NOK',"Erreur lors de la suppression !");
define('LANG_SUPPR_NOK2',"Erreur partielle lors de la suppression !");
define('LANG_ENT_NOM',"Nom de l'entreprise");
define('LANG_TEL',"T&eacute;l&eacute;phone");
define('LANG_FAX',"Fax");
define('LANG_ADR',"Adresse");
define('LANG_CP',"Code Postal");
define('LANG_VILLE',"Ville");
define('LANG_COMMS',"Commentaires");
define('LANG_COMM',"Commentaire");
define('LANG_DE',"De");
define('LANG_A',"A");
define('LANG_DEBUT',"début");
define('LANG_FIN',"fin");
define('LANG_MODIF',"Modifier");
define('LANG_ANNUL',"Annuler");
define('LANG_NOM',"Nom");
define('LANG_NOM_FAM',"Nom de famille");
define('LANG_PRENOM',"Pr&eacute;nom");
define('LANG_ACTIF',"Actif");
define('LANG_ACTIFS',"Actifs");
define('LANG_ACTIVE',"Activ&eacute;");
define('LANG_EFFECTIF',"Effectif");
define('LANG_NO_SUCC',"Aucune succursale d&eacute;clar&eacute;e");
define('LANG_NO_DONNEES',"Aucune donn&eacute;e");
define('LANG_NO_UTILS',"Aucun utilisateur enregistr&eacute; !!");
define('LANG_NO_EMP',"Aucun Employ&eacute; cr&eacute;&eacute; !!");
define('LANG_AUCUN',"Aucun");
define('LANG_TOUS',"Tous");
define('LANG_TOUTES',"Toutes");
define('LANG_SECT',"Secteur");
define('LANG_SECTS',"Secteurs");
define('LANG_PERIO',"P&eacute;riodicit&eacute;s");
define('LANG_ADMSECT',"Admin. Secteur");
define('LANG_ADMGEN',"Admin. G&eacute;n&eacute;ral");
define('LANG_UTIL_MODIF',"Utilisateur: Modification");
define('LANG_UTIL_ADD',"Utilisateur: Ajouter");
define('LANG_SUCC_MODIF',"Succursales: Modification");
define('LANG_SUCC_ADD',"Succursales: Ajouter");
define('LANG_MDP',"Mot de passe");
define('LANG_MDP_REPET',"Mot de passe (r&eacute;p&eacute;ter)");
define('LANG_ADMIN_SECT',"Administrateur de secteur");
define('LANG_ADMIN_SYST',"Administrateur du Syst&egrave;me");
define('LANG_SOLDE',"Solde");
define('LANG_PRIS',"Pris");
define('LANG_LOCALIS',"Localisation");
define('LANG_SELECT',"S&eacute;lectionner");
define('LANG_EMP_MOD',"Employ&eacute;: Modification");
define('LANG_EMP_ADD',"Employ&eacute;: Ajout");
define('LANG_DATE_NAISS',"Date de naissance");
define('LANG_STATUT',"Statut");
define('LANG_TRAVALE',"Travaille le ");
define('LANG_NB_CONGES_COURS',"Nb cong&eacute;s ann&eacute;e en cours");
define('LANG_NB_CONGES_REPORT',"Nb cong&eacute;s report");
define('LANG_DATE_ARRIVEE',"Date arriv&eacute;e");
define('LANG_DATE_DEPART',"Date d&eacute;part");
define('LANG_DATE_DEBUT',"Date D&eacute;but");
define('LANG_DATE_FIN',"Date Fin");
define('LANG_MATIN',"Matin");
define('LANG_APRESMIDI',"Apr&egrave;s Midi");
define('LANG_DEMI_JOURN',"Demi journ&eacute;");
define('LANG_EMP_NOSAMEDI',"l'employ&eacute; s&eacute;lectionn&eacute; ne travaille pas le samedi");
define('LANG_EMP_NODIMANCHE',"vous avez s&eacute;lectionn&eacute; un dimanche");
define('LANG_SEL_FERIE',"vous avez s&eacute;lectionn&eacute; un jour F&eacute;ri&eacute;");
define('LANG_ABS_PRES',"une absence est d&eacute;j&agrave; pr&eacute;sente pour cette p&eacute;riode");
define('LANG_JOURS',"jours");
define('LANG_JOURNEE',"Journ&eacute;e");
define('LANG_PERIODICITE',"P&eacute;riodicit&eacute;");
define('LANG_TYPE_ABS',"Type d'absence");
define('LANG_TYPE',"Type");
define('LANG_ADD_FONCT',"Ajout de Fonction");
define('LANG_ADD_CAT',"Ajout de Cat&eacute;gorie");
define('LANG_INTITULE',"Intitul&eacute;");
define('LANG_EXPORT_PDF',"Exporter le calendrier au format PDF");
define('LANG_EXPORT_EXCEL',"Exporter le calendrier au format Excel");
define('LANG_MOIS',"Mois");
define('LANG_DATE',"Date");
define('LANG_ANNEE',"Ann&eacute;e");
define('LANG_ANNEES',"Ann&eacute;es");
define('LANG_NO_EMPL_CRITERES',"Aucun employ&eacute; ne correspond aux crit&egrave;res sp&eacute;cifi&eacute;s");
define('LANG_ANCIENNETE',"Anciennet&eacute;");
define('LANG_CHAQUE_ANNEE',"A chaque Ann&eacute;e");
define('LANG_NO_ABS_SEL',"Pas d'absence s&eacute;lectionn&eacute;e !");
define('LANG_ADD_PAR',"Ajout&eacute; par");
define('LANG_ADD_LE',"Ajout&eacute; le");
define('LANG_NO_CONGES',"Aucun cong&eacute;");
define('LANG_FERMER',"Fermer");
define('LANG_ERREUR_DEJA_PRESENT',"Ce jour est d&eacute;j&agrave; pr&eacute;sent dans la liste !");
define('LANG_NO_JOURS_FERIES',"Aucun jour F&eacute;ri&eacute; !!!!!");
define('LANG_COULEUR',"Couleur");
define('LANG_TYPE_SUPPR_IMPOSSIBLE',"Suppression du type de cong&eacute;s impossible car des affectations ont eu lieu.");
define('LANG_NO_TYPES_ABS',"Aucun type d'absence d&eacute;fini !");
define('LANG_PRESENT',"Pr&eacute;sent");
define('LANG_ABS_PARTIELLE',"Absence Partielle");
define('LANG_WEEKEND',"Week End");
define('LANG_NO_SECT',"Aucun secteur d&eacute;fini !");
define('LANG_SECT_SUPPR_IMPOSSIBLE',"Suppression du secteur impossible car des employ&eacute;s sont affect&eacute;s.");
define('LANG_NO_PERIO',"Aucun p&eacute;riodicit&eacute; d&eacute;finie !");
define('LANG_PERIO_SUPPR_IMPOSSIBLE',"Suppression de la periodicite impossible car des employ&eacute;s ont des cong&eacute;s affect&eacute;s.");
define('LANG_ERREUR_CREER_EMPL',"Aucun employ&eacute; ne peut &ecirc;tre cr&eacute;&eacute; car les champs suivants sont vides:<br/>");
define('LANG_CHARGEMENT',"Chargement en cours ...");
define('LANG_AUJOURDHUI',"Aujourd'hui");
define('LANG_OUVRIR_CAL',"Ouvrir le calendrier");
define('LANG_FICHE',"Fiche");

define('LANG_ASTERIS',"Les champs identifi&eacute;s par un ast&eacute;risque <span class=\"required\">*</span> sont obligatoires.");
define('LANG_NO_ACCES',"Acc&egrave;s non autoris&eacute;");

//PDF
define('LANG_PDF_TITRE',"Planning des Congés");
define('LANG_PDF_PERIODE',"Période");
define('LANG_PDF_SECT',"Secteur");
define('LANG_PDF_NO_EMPL_CRITERES',"Aucun employé ne correspond aux critères spécifiés");
define('LANG_PDF_NOM',"Planning_conges");
define('LANG_PDF_PRESENT',"Présent");
define('LANG_PDF_FERIE',"Férié");
define('LANG_PDF_WEEKEND',"Week End");
define('LANG_PDF_MATIN',"Matin");
define('LANG_PDF_APRESMIDI',"Après Midi");
define('LANG_PDF_NO_TYPES_ABS',"Aucun type d'absence défini !");


//Messages Javascript
define('LANG_SAISIR_SOCNOM',"Veuillez saisir un nom de société");
define('LANG_SAISIR_NOM',"Veuillez saisir un nom");
define('LANG_SAISIR_NOMFAM',"Veuillez saisir le nom de famille");
define('LANG_SAISIR_PRENOM',"Veuillez saisir le prénom");
define('LANG_SAISIR_DATE_ARRIV',"Veuillez saisir la date d'arrivée");
define('LANG_SAISIR_MDP',"Saisissez un mot de passe");
define('LANG_ERREUR_MDPS',"Erreur de saisie des mots de passe");
define('LANG_SAISIR_INTITULE',"Veuillez saisir un intitulé");
define('LANG_SAISIR_JOURS',"Veuillez saisir un nombre de jours");
define('LANG_ERREUR_DATES',"Date de Fin inférieure à la date de Début !");
define('LANG_ERREUR_SEL_EMP',"Pas de sélection d'employé");
define('LANG_ERREUR_SEL_ABS',"Pas de sélection de type d'absence");
define('LANG_ERREUR_MOD_ABS',"Pas de sélection d'absence");
define('LANG_ERREUR_SEL_DATE_DEBUT',"Veuillez saisir la date de début");
define('LANG_ERREUR_SEL_DATE_FIN',"Veuillez saisir la date de fin");
define('LANG_ERREUR_SEL_TYPE',"Veuillez sélectionner un type d'absence");
define('LANG_ERREUR_COULEUR',"La couleur entrée est invalide");
define('LANG_ERREUR_SEL_SECT',"Veuillez sélectionner un secteur");
define('LANG_ERREUR_SEL_PERIO',"Veuillez sélectionner une periodicité");

//MUST BE END OF FILE
?>
