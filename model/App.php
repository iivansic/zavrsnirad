<?php

class App
{
    public static function start()
    {
        $ruta = Request::getRuta();
        echo $ruta;
    }
}