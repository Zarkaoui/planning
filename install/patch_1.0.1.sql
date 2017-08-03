
ALTER TABLE `abs_conges` ADD `conges_periodicite_debut` VARCHAR( 10 ) NOT NULL AFTER `conges_periodicite`;
ALTER TABLE `abs_conges` ADD `conges_periodicite_fin` VARCHAR( 10 ) NOT NULL AFTER `conges_periodicite_debut`;

UPDATE `abs_conges` SET `conges_periodicite_debut`= `conges_date` WHERE `conges_periodicite` != 0;
UPDATE `abs_conges` SET `conges_periodicite_fin`= '31-12-2010' WHERE `conges_periodicite` != 0 AND `conges_date` LIKE '%-2010';
UPDATE `abs_conges` SET `conges_periodicite_fin`= '31-12-2011' WHERE `conges_periodicite` != 0 AND `conges_date` LIKE '%-2011';
UPDATE `abs_conges` SET `conges_periodicite_fin`= '31-12-2012' WHERE `conges_periodicite` != 0 AND `conges_date` LIKE '%-2012';
