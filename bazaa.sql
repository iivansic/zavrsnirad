#tehnolog lansira nalog u registrator
#programer vadi iz registratora nalog i slaze u program
#program salje na laser operateru da reže
#operater pokrece program i kad ga izreze do kraja prijavi da je pozicija/nalog izrezan te ide  na sljedecu tehnologiju
#napomena nema potrebe skrolat nakon 166 retka samo testiranje :D

drop database if exists bazaa;
create database bazaa;
use bazaa;
#alter database maksimus_pp21 default character set utf8;
create table glavnatablica(
	id int not null primary key auto_increment,
	partnumber varchar(17),
	naziv varchar (250),
	stanje int,
	lokacija varchar(50),
	status int,
	tehnologija varchar(10),
	takt varchar(10),
	opis varchar (250)
) engine=innodb;
create table radnik(
	id int not null primary key auto_increment,
	ime varchar(50) not null,
	prezime varchar(50) not null,
	email varchar(50) not null,
    radnomjesto varchar(50) not null,
    lozinka char(60) not null,
    komentar text,
    datum timestamp
) engine=innodb;
insert into radnik (ime,prezime,email,radnomjesto,lozinka) values
('admin','edunova','admin@edunova.hr','admin','$2y$10$XFN6EAhRcT8dLluR55We5e7tVIRdmpdT6UK3dKC5K5rBu61lZx8wS'),
('ivan','ivansic','ivan.ivansic@sdfgroup.com','inženjer','$2y$10$aNOp6RRDfKdizyx5bJO1qeEqsXVmwNmbWlf6n2nBUWZbgDx9ew8JO'),
('zvonko','bukna','zvonko.bukna@sdfgroup.com','inženjer','$2y$10$aNOp6RRDfKdizyx5bJO1qeEqsXVmwNmbWlf6n2nBUWZbgDx9ew8JO'),
('oper','edunova','oper@edunova.hr','oper','$2y$10$ORTWwUHhw8REC1R.K54MqOg4Qa.8RcCMZOsdPN3FXjZBkCADLmKbO');

create table povijestkretanjanaloga(
	id int not null primary key auto_increment,
	glavnatablica int not null,
	radnik int not null,
	kolicina int not null,
	status int,
	lokacija varchar(50),
	stroj varchar(50),
	opis text,
	datum timestamp
) engine=innodb;
create table kataforeza(
	id int not null primary key auto_increment,
	prioritet int,
	minobojat int,
	glavnatablica int not null,
	lokacija varchar(10),
	stanje int,
	stiglo int,
	otislo int,
	datum timestamp
)engine=innodb;

create table status(
	id int not null primary key auto_increment,
	naziv varchar(50)
) engine=innodb;
insert into status (naziv) values 
('miruje'),('lansirano'),('slozeno'),('izrezano'),('savijeno'),('zavareno'),('obojano'),('zavrsno');
alter table kataforeza add foreign key (glavnatablica) references glavnatablica(id);
alter table glavnatablica add foreign key (status) references status(id);
alter table povijestkretanjanaloga add foreign key (status) references status(id);

alter table povijestkretanjanaloga add foreign key (glavnatablica) references glavnatablica(id);
alter table povijestkretanjanaloga add foreign key (radnik) references radnik(id);

insert into glavnatablica (partnumber, naziv, stanje, lokacija, status, tehnologija, opis, takt) values
('16063115','Letva uvlačnog kanala',10,'C12',2,'LDB','Letva od Bertica', 'T9'),
('16063114','Letva uvlačnog kanala',10,'C12',2,'LDB','Letva od Bertica', 'T9'),
('0.035.1254.3/20','Bracket',10,'C12',2,'LDB','Letva od Bertica', 'T14'),
('06542678/10','Osovina',10,'C12',2,'LDB','Letva od Bertica', 'Kabina'),
('06302030','Ploča',10,'C12',2,'LDB','Letva od Bertica', 'T1'),
('0.015.2217.3','Bracket',10,'C12',2,'LDB','Letva od Bertica', 'T3');

insert into kataforeza (prioritet, glavnatablica , lokacija, stanje, stiglo, otislo, minobojat) values
('1','1','B12',50,50,0,18),
('2','6','C12',25,25,0,0),
('2','2','C12',25,25,0,0),
('1','3','C12',25,25,0,2),
('3','4','C12',25,25,0,0),
('3','5','A11',25,25,0,0);
insert into povijestkretanjanaloga (glavnatablica,radnik,kolicina,status,lokacija,stroj,opis) values
(1,1,10,2,'C11','Laser1','Nema škarta');
select * from radnik;

select a.id, a.ime, a.prezime, a.email, a.radnomjesto, a.lozinka, a.komentar, a.datum, count(b.id) as povijestkretanjanaloga
from radnik a left join povijestkretanjanaloga b on 
a.id=b.radnik group by a.id, a.ime, a.prezime, a.email, a.radnomjesto, a.lozinka, a.komentar, a.datum;

