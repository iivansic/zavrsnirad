<?php

class Radnik
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select a.id, a.ime, a.prezime, a.email, a.radnomjesto, a.lozinka, 
                a.komentar, a.datum, count(b.id) as povijestkretanjanaloga
                from radnik a left join povijestkretanjanaloga b on 
                a.id=b.radnik group by a.id, a.ime, a.prezime, a.email, 
                a.radnomjesto, a.lozinka, a.komentar, a.datum;
            ');
        $izraz ->execute();
        return $izraz->fetchALL();
    }
    public static function ucitaj($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select * from radnik where id=:id;
            ');
        $izraz ->execute(['id'=>$id]);
        return $izraz->fetch();
    }
    public static function dodajNovi($radnik)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into radnik (ime,prezime,radnomjesto,email,lozinka,komentar) values (:ime,:prezime,:radnomjesto,:email,:lozinka,:komentar);');
        $izraz->execute($radnik);
        
    }
    public static function promjena($radnik)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update radnik set 
        ime=:ime,
        prezime=:prezime,
        radnomjesto=:radnomjesto,
        email=:email,
        lozinka=:lozinka,
        komentar=:komentar
        where id=:id;');
        $izraz->execute($radnik);
        
    }
    public static function brisanje($id)
    {
        $veza=DB::getInstanca();
        $izraz=$veza->prepare('delete from radnik where id=:id;');
        $izraz->execute(['id'=>$id]);
    }


}