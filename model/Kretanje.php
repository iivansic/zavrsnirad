<?php

class Kretanje
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.id, b.partnumber, concat(c.ime, \' \', c.prezime) as radnik, a.kolicina, d.naziv, a.lokacija, a.stroj, a.opis, a.datum 
        from povijestkretanjanaloga a 
        left join glavnatablica b on a.glavnatablica=b.id
        left join radnik c on a.radnik=c.id
        left join status d on a.status=d.id;
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ucitaj($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select * from povijestkretanjanaloga where id=:id;
            ');
        $izraz ->execute(['id'=>$id]);
        return $izraz->fetch();
    }

    public static function dodajNovi($kretanje)
    {
       
    }

    public static function promjena($kretanje)
    {
        
    }

    public static function brisanje($id)
    {
        $veza=DB::getInstanca();
        $izraz=$veza->prepare('delete from povijestkretanjanaloga where id=:id;');
        $izraz->execute(['id'=>$id]);
    }
}