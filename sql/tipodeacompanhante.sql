/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.1.40-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `tipodeacompanhante` (
	`id` tinyint (4),
	`descricao` varchar (90)
); 
insert into `tipodeacompanhante` (`id`, `descricao`) values('0','Sem Acompanhante');
insert into `tipodeacompanhante` (`id`, `descricao`) values('1','MÃ£e/Pai');
insert into `tipodeacompanhante` (`id`, `descricao`) values('2','IrmÃ£(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('3','Tia(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('4','AvÃ³(Ã´)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('5','Filha(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('6','Sobrinha(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('7','Vizinha(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('8','Amiga(o)');
insert into `tipodeacompanhante` (`id`, `descricao`) values('9','Outro');
