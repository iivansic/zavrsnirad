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
    public static function ucitaj($id)
    {
        // ovdje inner join ide ovo je prije bilo: select * from kataforeza where id=:id; ovdje me zafrkava ID
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

            select a.id, a.glavnatablica, a.prioritet, b.partnumber, b.takt, b.naziv,
            a.stanje, a.minobojat, a.lokacija, a.stiglo, a.otislo from kataforeza a
            inner join glavnatablica b on a.glavnatablica=b.id where a.id=:id;      
               
            ');
        $izraz ->execute(['id'=>$id]);
        return $izraz->fetch();
    }
    public static function dodajNovi($kataforeza){
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $brojizraz = $veza->prepare('select id from glavnatablica where partnumber = :partnumber;');
        $brojizraz ->execute([
            'partnumber' =>$kataforeza['partnumber']
        ]);
        $broj=$brojizraz ->fetchColumn();
        $izraz = $veza->prepare('insert into kataforeza (glavnatablica,stanje,prioritet,minobojat,lokacija,stiglo,otislo)
            values (:glavnatablica, :stanje, :prioritet, :minobojat, :lokacija,:stiglo,:otislo);
        ');
        $izraz -> execute([
            'glavnatablica'=> $broj,
            'stanje'=>$kataforeza['stanje'],
            'prioritet'=>$kataforeza['prioritet'],
            'minobojat'=>$kataforeza['minobojat'],
            'lokacija'=>$kataforeza['lokacija'],
            'stiglo' => $kataforeza['stanje'],
            'otislo' => 0
        ]); 
            // povjest kretanja naloga
        $izraz = $veza->prepare('
            insert into povijestkretanjanaloga(glavnatablica, radnik, kolicina,status,lokacija, stroj,opis,datum)
                values (:glavnatablica, :radnik, :kolicina, :status, :lokacija, :stroj, :opis, now())');
        $izraz ->execute([
           'glavnatablica' =>$broj,
           'radnik' =>1,
           'status' =>6,
           'kolicina'=>$kataforeza['stanje'],
           'lokacija'=>$kataforeza['lokacija'],
            'stroj' =>'Zavarivanje',
            'opis' =>'Poslano na bojanje'
        ]);
        $veza->commit();
    }
    public static function partnumber($partnumber)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id from glavnatablica where partnumber = :partnumber;');
        $izraz -> execute([
            'partnumber'=> $partnumber
        ]);        
            return $izraz->fetchColumn();
    }
    // ovo ne radi 
    public static function stanje($stanje)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select stanje from kataforeza where id = :id;');
        $izraz -> execute([
            'stanje'=> $stanje
        ]);        
            return $izraz->fetchColumn();
    }
    public static function id($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id from kataforeza where id=:id;');
        $izraz -> execute([
            'id'=>$id
        ]);
        return $izraz->fetchColumn();
    }
    public static function brisanje($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from kataforeza where id=:id;');
        $izraz->execute(['id'=>$id]);
    }
    public static function promjena($kataforeza)
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update kataforeza set
        glavnatablica=:glavnatablica,
        stanje=:stanje,
        lokacija=:lokacija,
        prioritet=:prioritet,
        minobojat=:minobojat,
        stiglo=:stiglo,
        otislo=:otislo
        where id=:id;');
        $izraz->execute($kataforeza);


    }
    public static function obojano($kataforeza)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $bizraz = $veza->prepare('select * from kataforeza where id=:id;
        ');
        $bizraz ->execute(['id'=>$kataforeza['id']]);
        $kobj=$bizraz->fetch();
        if ($kobj->minobojat>=$kataforeza['stanje']){
            $izraz = $veza->prepare('
            update kataforeza set 
            stanje = stanje - :stanje,
            minobojat = minobojat - :stanje,
            otislo = otislo + :stanje 
            where id=:id;');
            $izraz ->execute([
                'id'=> $kataforeza['id'],
                'stanje'=>$kataforeza['stanje']
            ]);
        }else{
            $izraz = $veza->prepare('
            update kataforeza set 
            minobojat = 0,
            prioritet = 3,
            stanje = stanje - :stanje,
            otislo = otislo + :stanje 
            where id=:id;');
            $izraz ->execute([
               'stanje'=>$kataforeza['stanje'],
               'id'=>$kataforeza['id']
            ]);
        }
       
        $cizraz = $veza->prepare('select * from kataforeza where id=:id;');
        $cizraz ->execute(['id'=>$kataforeza['id']]);
        $aobj=$cizraz->fetch();
        // provjera jel minobojat 0 da makne prioritet ako ima
        if ($aobj->minobojat <= 0){
            $izraz = $veza->prepare('update kataforeza set prioritet = 3 where id=:id;');
            $izraz->execute(['id'=>$kataforeza['id']]);
        }
        //brisanje pozicije ako je stanje nula
        if ($aobj->stanje <= 0){
            $izraz = $veza->prepare('delete from kataforeza where id=:id;');
            $izraz->execute(['id'=>$kataforeza['id']]);
        }
        $izraz = $veza->prepare('
        insert into povijestkretanjanaloga(glavnatablica, radnik, kolicina,status,lokacija, stroj,opis,datum)
        values (:glavnatablica, :radnik, :kolicina, :status, :lokacija, :stroj, :opis, now())');
        $izraz ->execute([
           'glavnatablica' =>$kobj->glavnatablica,
           'radnik' =>1,
           'status' =>1,
           'kolicina'=>$kataforeza['stanje'],
           'lokacija'=>'Montaža',
            'stroj' => 'Kataforeza',
            'opis' => 'Obojano i poslano na montažu.'
        ]);
        $veza->commit();
    }

    public static function dijagramPrioritet()
    {
    $veza = DB::getInstanca();
    $izraz = $veza->prepare('select concat(\'Prioritet \', prioritet) as name, 
    sum(minobojat) as y from kataforeza where prioritet=1;');
    $izraz->execute();
    return json_encode($izraz->fetchAll(),JSON_NUMERIC_CHECK);
    }
    public static function dijagramUkupno()
    {
    $veza = DB::getInstanca();
    $izraz = $veza->prepare('
    select sum(stanje) as ukupno from kataforeza
    union
    select sum(minobojat) as ukupno from kataforeza;');
    $izraz->execute();
    return $izraz->fetchAll();
    }
}