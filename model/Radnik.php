<?php

class Radnik
{
    public static function ucitajSve(){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from radnik;');
        $izraz -> execute();
        return $izraz->fetchALL();
    }
    public static function dodajNovi($radnik){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into radnik (ime,prezime,radnomjesto,email,lozinka,komentar) values (:ime,:prezime,:radnomjesto,:email,:lozinka,:komentar);');
        $izraz->execute($radnik);
        
    }



}