/*
SQLyog Ultimate v10.42 
MySQL - 5.7.26 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `utilisateurs` (
	`id` int (11),
	`parrainage_id` varchar (24),
	`admin` int (11),
	`active` int (11),
	`register_stamp` int (11),
	`fisrt_stamp` int (11),
	`stamp` int (11),
	`login` text ,
	`pass` text ,
	`commercial` tinyint (4),
	`telepro` tinyint (4),
	`assistant` tinyint (4),
	`rc` tinyint (4),
	`rt` tinyint (4),
	`nom` text ,
	`prenom` text ,
	`email` text ,
	`tel` text ,
	`rdv` tinyint (4),
	`contrat` tinyint (4),
	`rdv_creer` tinyint (4),
	`contrat_creer` tinyint (4),
	`rdv_suppr` tinyint (4),
	`contrat_suppr` tinyint (4),
	`rdv_tous` tinyint (4),
	`sms` tinyint (4),
	`couleur` varchar (750),
	`export_csv_client` tinyint (4),
	`export_csv_rdv` tinyint (4),
	`export_kml_client` tinyint (4),
	`export_kml_rdv` tinyint (4),
	`sav_creer` tinyint (4),
	`idequipe` int (11),
	`sav` tinyint (4),
	`installation` tinyint (4),
	`installation_suppr_doc` tinyint (4),
	`compte` tinyint (4),
	`lettre_type` tinyint (4),
	`sms_type` tinyint (4),
	`email_type` tinyint (4),
	`import_rdv` tinyint (4)
); 
insert into `utilisateurs` (`id`, `parrainage_id`, `admin`, `active`, `register_stamp`, `fisrt_stamp`, `stamp`, `login`, `pass`, `commercial`, `telepro`, `assistant`, `rc`, `rt`, `nom`, `prenom`, `email`, `tel`, `rdv`, `contrat`, `rdv_creer`, `contrat_creer`, `rdv_suppr`, `contrat_suppr`, `rdv_tous`, `sms`, `couleur`, `export_csv_client`, `export_csv_rdv`, `export_kml_client`, `export_kml_rdv`, `sav_creer`, `idequipe`, `sav`, `installation`, `installation_suppr_doc`, `compte`, `lettre_type`, `sms_type`, `email_type`, `import_rdv`) values('1',NULL,'0','1',NULL,NULL,'1611478975','calvyn','Lebo','1','0','0','0','0','Lebo','Lebo','calvyn@gmail.com','03431028939','0','0','1','0','0','0','0','0','\'0,0,0\'','0','0','0','0','0','1','0','0','0','0','0','0','0','0');
insert into `utilisateurs` (`id`, `parrainage_id`, `admin`, `active`, `register_stamp`, `fisrt_stamp`, `stamp`, `login`, `pass`, `commercial`, `telepro`, `assistant`, `rc`, `rt`, `nom`, `prenom`, `email`, `tel`, `rdv`, `contrat`, `rdv_creer`, `contrat_creer`, `rdv_suppr`, `contrat_suppr`, `rdv_tous`, `sms`, `couleur`, `export_csv_client`, `export_csv_rdv`, `export_kml_client`, `export_kml_rdv`, `sav_creer`, `idequipe`, `sav`, `installation`, `installation_suppr_doc`, `compte`, `lettre_type`, `sms_type`, `email_type`, `import_rdv`) values('2',NULL,'0','1',NULL,NULL,'141441414','Sakaiza','Wilder','1','0','0','0','0','Sakaiza','Wilder','sakaiza@gmail.com','0343120839','0','0','1','0','0','0','0','0','\'0,0,0\'','0','0','0','0','0','1','0','0','0','0','0','0','0','0');
insert into `utilisateurs` (`id`, `parrainage_id`, `admin`, `active`, `register_stamp`, `fisrt_stamp`, `stamp`, `login`, `pass`, `commercial`, `telepro`, `assistant`, `rc`, `rt`, `nom`, `prenom`, `email`, `tel`, `rdv`, `contrat`, `rdv_creer`, `contrat_creer`, `rdv_suppr`, `contrat_suppr`, `rdv_tous`, `sms`, `couleur`, `export_csv_client`, `export_csv_rdv`, `export_kml_client`, `export_kml_rdv`, `sav_creer`, `idequipe`, `sav`, `installation`, `installation_suppr_doc`, `compte`, `lettre_type`, `sms_type`, `email_type`, `import_rdv`) values('3',NULL,'0','1',NULL,NULL,'42124','RAKOTO','Franc','0','1','0','0','0','RAKOTO','Franc','ratoako.franc@gmail.com','0355722041','0','0','2','0','0','0','0','0','\'0,0,0\'','0','0','0','0','0','1','0','0','0','0','0','0','0','0');
insert into `utilisateurs` (`id`, `parrainage_id`, `admin`, `active`, `register_stamp`, `fisrt_stamp`, `stamp`, `login`, `pass`, `commercial`, `telepro`, `assistant`, `rc`, `rt`, `nom`, `prenom`, `email`, `tel`, `rdv`, `contrat`, `rdv_creer`, `contrat_creer`, `rdv_suppr`, `contrat_suppr`, `rdv_tous`, `sms`, `couleur`, `export_csv_client`, `export_csv_rdv`, `export_kml_client`, `export_kml_rdv`, `sav_creer`, `idequipe`, `sav`, `installation`, `installation_suppr_doc`, `compte`, `lettre_type`, `sms_type`, `email_type`, `import_rdv`) values('4',NULL,'0','1',NULL,NULL,'1114','TestNom','testPre','1','0','0','0','0','testNom','TestPrenom','test@gmail.com','248701144','0','0','12','0','0','0','0','0','\'0,0,0\'','0','0','0','0','0','1','0','0','0','0','0','0','0','0');
