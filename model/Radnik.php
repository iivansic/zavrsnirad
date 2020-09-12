<?php

class Radnik
{
    public static function ucitajSve(){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from radnik');
        $izraz -> execute();
        return $izraz->fetchALL();
    }
}