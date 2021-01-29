/*
SQLyog Ultimate v10.42 
MySQL - 5.7.26 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `equipes` (
	`id` int (11),
	`idchef` int (11),
	`nom` text ,
	`active` tinyint (4)
); 
insert into `equipes` (`id`, `idchef`, `nom`, `active`) values('1',NULL,'Société01','1');
