<?php
session_start();
define('BP',__DIR__ . DIRECTORY_SEPARATOR);
//echo BP;
$t=implode(PATH_SEPARATOR, 
            [
                BP . 'model',
                BP . 'controller'                
            ]);
//print_r($t);

set_include_path($t);

spl_autoload_register(function($klasa)
{
    $putanje= explode(PATH_SEPARATOR,get_include_path());
    foreach($putanje as $p){
        if(file_exists($p.DIRECTORY_SEPARATOR.$klasa.'.php'))
            include $p.DIRECTORY_SEPARATOR.$klasa.'.php';
            break;
    }
});