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
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select * from kataforeza where id=:id;
            ');
        $izraz ->execute(['id'=>$id]);
        return $izraz->fetch();
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
    public static function brisanje($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from kataforeza where id=:id;');
        $izraz->execute(['id'=>$id]);
    }
    public static function promjena($kataforeza)
    {


        //ovaj dio ne radi prilikom promjene želim da mi ispiše na indexu od promjene $broj varijablu kako ???
         $veza = DB::getInstanca();
         $brojizraz = $veza->prepare('select partnumber from glavnatablica where id=:glavnatablica;');
         $brojizraz ->execute(['glavnatablica'=>$kataforeza['id']]);
         $broj = $brojizraz->fetchALL();
        // $broj=$brojizraz->fetchColumn();
        // dovdje,
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update kataforeza set
        stanje=:stanje,
        lokacija=:lokacija,
        prioritet=:prioritet,
        minobojat=:minobojat,
        stiglo=:stiglo,
        otislo=:otislo
        where id=:id;');
        $izraz->execute($kataforeza);
    }
    public static function obojano()
    {
        // kako odradit transakciju da prilikom prijave ID rasknjizi bazu kataforeza
        // ovo dolje je kako ja to zamišljam vjerovatno sam nikad necu natjerat da radi
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select minobojat from kataforeza where id=:id;
        ');
        $izraz ->execute(['id'=>$id]);
        $provjera=$izraz->fetch();
        if ($provjera>0){
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            update kataforeza set 
            stanje = stanje - :stanje,
            minobojat = minobojat - :stanje,
            otislo = otislo + :stanje 
            where id=:id;');
            $izraz ->execute([
                'stanje'=>$kataforeza['stanje'],
                'minobojat'=>$kataforeza['minobojat'],
                'otislo'=>$kataforeza['otislo']
            ]);
          
        }else{
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            update kataforeza set 
            stanje = stanje - :stanje,
            otislo = otislo + :stanje 
            where id=:id;');
            $izraz ->execute([
               'stanje'=>$obojano['stanje'],
               'otislo'=>$obojano['otislo']
            ]);
        }


    }
    public static function odprofesoraprimjer($entitet){
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
        select osoba from predavac where sifra=:sifra ;
        ');
        $izraz->execute(['sifra'=>$entitet['sifra']]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('update osoba set
                    ime=:ime,
                    prezime=:prezime,
                    oib=:oib,
                    email=:email
                    where sifra=:sifra');
        $izraz->execute([
            'ime'=>$entitet['ime'],
            'prezime'=>$entitet['prezime'],
            'oib'=>$entitet['oib'],
            'email'=>$entitet['email'],
            'sifra'=>$sifraOsoba
        ]);
        
        $izraz = $veza->prepare('update predavac set
                        iban=:iban
                        where sifra=:sifra');
        $izraz->execute([
            'sifra'=>$entitet['sifra'],
            'iban'=>$entitet['iban']
        ]);
        $veza->commit();
    }








}