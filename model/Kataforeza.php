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

}