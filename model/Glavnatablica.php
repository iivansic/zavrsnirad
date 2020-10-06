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
        //left join povijestkretanjanaloga c on a.id=c.glavnatablica  to moram nekako uglavit gore da ne vidim brisanje s ključem 
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
    public static function dodajNovi($glavnatablica)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into glavnatablica (partnumber,naziv,stanje,lokacija,status,tehnologija,takt,opis)
            values (:partnumber, :naziv, :stanje, :lokacija, :status,:tehnologija,:takt,:opis);
        ');
        $izraz -> execute([
            'partnumber'=> $glavnatablica['partnumber'],
            'naziv'=>$glavnatablica['naziv'],
            'stanje'=>$glavnatablica['stanje'],
            'lokacija'=>$glavnatablica['lokacija'],
            'status'=>$glavnatablica['status'],
            'tehnologija'=>$glavnatablica['tehnologija'],
            'takt' => $glavnatablica['takt'],
            'opis' => $glavnatablica['opis']
        ]); 
    }
    public static function promjena($glavnatablica)
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update glavnatablica set
        partnumber=:partnumber,
        naziv=:naziv,
        stanje=:stanje,
        lokacija=:lokacija,
        status=:status,
        tehnologija=:tehnologija,
        takt=:takt,
        opis=:opis
        where id=:id;');
        $izraz->execute($glavnatablica);


    }









}