<?php
class Glavnatablica
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select * from glavnatablica;
            ');
        $izraz ->execute();
        return $izraz->fetchALL();
    }

    public static function ucitaj($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select * from glavnatablica where id=:id;
            ');
        $izraz ->execute(['id'=>$id]);
        return $izraz->fetch();
    }
 













}