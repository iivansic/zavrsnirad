select a.id, a.prioritet, b.partnumber, b.takt, b.naziv,
a.stanje, a.minobojat, a.lokacija, a.stiglo, a.otislo from kataforeza a
inner join glavnatablica b on a.glavnatablica=b.id;

select * from glavnatablica;
select * from kataforeza;
select * from povijestkretanjanaloga;
insert into povijestkretanjanaloga (glavnatablica, radnik, kolicina, status, lokacija, stroj, opis) values
(2,2,15,4,'kraj regala','Laser 3', 'Nema škarta'),
(3,3,22,4,'kraj regala','Savijačica 2', 'Nema škarta'),
(4,4,36,5,'kraj regala','Savijačica 5', 'Nema škarta');

insert into kataforeza (prioritet, glavnatablica , lokacija, stanje, stiglo, otislo) values
('1','1','B12',50,50,0),
('2','6','C12',25,25,0),
('3','5','A11',25,25,0);

select id from glavnatablica where partnumber ='16063115';
                select b.id, a.id, a.stanje, a.prioritet, a.minobojat, a.lokacija, a.stiglo, a.otislo, b.partnumber 
                from kataforeza a inner join glavnatablica b on a.glavnatablica=b.id;

select b.partnumber from kataforeza a inner join glavnatablica b on a.glavnatablica=b.id where a.id=1;
select b.partnumber from kataforeza a inner join glavnatablica b on a.glavnatablica=b.id where b.id=4;
#ovo ispod radi al ne mogu ubacit to isto u php :S 
update kataforeza set stanje = stanje - 5, minobojat = minobojat - 5, otislo = otislo + 5 where id=1;

select b.partnumber, concat(c.ime, ' ', c.prezime), a.kolicina, d.naziv, a.lokacija, a.stroj, a.opis, a.datum 
from povijestkretanjanaloga a 
left join glavnatablica b on a.glavnatablica=b.id
left join radnik c on a.radnik=c.id
left join status d on a.status=d.id;