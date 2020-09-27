<?php
class Status
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from status;');
        $izraz->execute();
        return $izraz->fetchALL();
    }
}