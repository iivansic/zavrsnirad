<?php
// singleton pattern

class DB extends PDO
{
    private static $instanca;

    public function __construct($baza)
    {
        $dsn = 'mysql:host=' . $baza['server'] . ';dbname=' . $baza['baza']. ';charset=utf8';

        parent::__construct($dsn,$baza['korisnik'],$baza['lozinka']);

        $this->setAttribue(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->setAttribue(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstanca()
    {
        if(is_null(self::$instanca)){
            self::$instanca= new self(APP::config('baza'));
        }
        return self::$instanca;
    }
}