<?php

class Kataforeza
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select a.id, a.prioritet, b.partnumber, b.takt, b.naziv,
        a.stanje, a.minobojat, a.lokacija, a.stiglo, a.otislo from kataforeza a
        inner join glavnatablica b on a.glavnatablica=b.id;
            ');
        $izraz ->execute();
        return $izraz->fetchALL();
    }
    public static function dodajNovi($kataforeza){
        $veza = DB::getInstanca();
        $brojizraz = $veza->prepare('select id from glavnatablica where partnumber = :partnumber;');
        $brojizraz ->execute([
            'partnumber' =>$kataforeza['partnumber']
        ]);
        $broj=$brojizraz ->fetchColumn();
        $izraz = $veza->prepare('insert into kataforeza (glavnatablica,stanje,prioritet,minobojat,lokacija) values (:glavnatablica, :stanje, :prioritet, :minobojat, :lokacija);
        ');
        $izraz -> execute([
            'glavnatablica'=> $broj,
            'stanje'=>$kataforeza['stanje'],
            'prioritet'=>$kataforeza['prioritet'],
            'minobojat'=>$kataforeza['minobojat'],
            'lokacija'=>$kataforeza['lokacija']
        ]);        

    }
    public static function partnumber($partnumber){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id from glavnatablica where partnumber = :partnumber;');
        $izraz -> execute([
            'partnumber'=> $partnumber
        ]);        
            return $izraz->fetchColumn();
    }

}