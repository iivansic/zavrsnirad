<?php
class Glavnatablica
{
    public static function ucitajSve($stranica,$uvjet)
    {
        $od = $stranica * 11 - 11;
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select a.id, a.partnumber, a.naziv, a.stanje, a.lokacija, a.status, a.tehnologija, a.takt, a.opis from glavnatablica a 
        left join status b on a.status=b.id
        where concat(a.partnumber, \' \', ifnull(a.naziv, \' \'), ifnull(a.lokacija, \' \'), 
        ifnull(b.naziv, \' \'), ifnull(a.takt, \' \'), ifnull(a.opis, \' \')) like :uvjet limit :od, 11;
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->bindValue('od',$od,PDO::PARAM_INT);
        $izraz ->execute();
        return $izraz->fetchALL();
    }
    public static function ukupnoStranica()
    {
        
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select count(id) from glavnatablica;
            ');
        $izraz ->execute();
        return $izraz->fetchColumn();
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
    public static function brisanje($id)
    {
        $veza=DB::getInstanca();
        $izraz=$veza->prepare('delete from glavnatablica where id=:id;');
        $izraz->execute(['id'=>$id]);
    }













}