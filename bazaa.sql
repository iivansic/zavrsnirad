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
	mbstatus varchar(50),
	partnumber varchar(17),
	stanje int,
	lokacija varchar(50),
	status int,
	uizradi int,
	potrebadokraja int,
	tehnologija varchar(10),
	naziv varchar (250),
	opis varchar (250),
	kombajn varchar(50)
) engine=innodb;
create table radnik(
	id int not null primary key auto_increment,
	ime varchar(50),
	prezime varchar(50),
    radnomjesto varchar(50),
    slika varchar(200),
    komentar text,
    datum timestamp
) engine=innodb;
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
create table status(
	id int not null primary key auto_increment,
	naziv varchar(50)
) engine=innodb;

alter table glavnatablica add foreign key (status) references status(id);
alter table povijestkretanjanaloga add foreign key (status) references status(id);

alter table povijestkretanjanaloga add foreign key (glavnatablica) references glavnatablica(id);
alter table povijestkretanjanaloga add foreign key (radnik) references radnik(id);
#zavarivannje bojanje dolje.... osmislit kako.
#ubacivanje sklopova očeva s sinovima
create table sastavnica(
	lvl int,
	partnumber varchar(50),
	description varchar(50),
	changed varchar(50),
	quantity varchar(50),
	um varchar(50),
	mb varchar(50),
	adminc varchar(50)
);

create table stanje(
	partnumber varchar(50),
	stanje int,
	potreba int
);
create table dug(
	partnumber varchar(50),
	dug int,
	razlika int
);
create table p1(
	partnumber varchar(50),
	p1 int,
	razlika int
);
create table p2(
	partnumber varchar(50),
	p2 int,
	razlika int
);
create table p3(
	partnumber varchar(50),
	p3 int,
	razlika int
);

# baza podataka stanje te reduciranje stanja prilikom zavarivanja
#popuna baze podataka

