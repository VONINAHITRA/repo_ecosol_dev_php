/*
SQLyog Ultimate v10.42 
MySQL - 5.7.26 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `rdv` (
	`id` int (11),
	`idclient` int (11),
	`dateheure` datetime ,
	`stamp` int (11),
	`idutilisateur` int (11),
	`active` tinyint (4),
	`rapport` char (51),
	`parrain_id` varchar (45),
	`idcommercial` int (11),
	`idtelepro` int (11),
	`source` char (75),
	`utm_source` varchar (765),
	`utm_medium` varchar (765),
	`utm_content` varchar (765),
	`detail` text ,
	`commentaire` text ,
	`confirme` tinyint (4)
); 
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('1','10','2021-01-27 13:59:21','12','1','1','EN COURS',NULL,'0','0','radiateurs-gratuits',NULL,NULL,NULL,NULL,' v v v v v v','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('2','12','2021-01-27 17:00:28','15','1','1','SIGNE',NULL,'0','0','2B Digital',NULL,NULL,NULL,NULL,'1010101','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('3','15','2021-01-27 17:16:45','18','2','1','EN ATTENTE',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,'teretere','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('5','12','2021-01-27 18:18:54','54','2','1','EN COURS',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,'n,n,n,','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('6','50','2021-01-27 18:20:30','14','1','1','R2',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,'rezézzaz','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('7','45','2021-01-27 18:22:16','47','3','1','EN COURS',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,'tytytyt','0');
insert into `rdv` (`id`, `idclient`, `dateheure`, `stamp`, `idutilisateur`, `active`, `rapport`, `parrain_id`, `idcommercial`, `idtelepro`, `source`, `utm_source`, `utm_medium`, `utm_content`, `detail`, `commentaire`, `confirme`) values('8','44','2021-01-27 20:31:00','77','4','1','EN COURS',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,'coms','0');
