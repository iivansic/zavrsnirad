<?php
$dev=$_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false;
if($dev){
    $baza=[
        'server' => 'localhost',
        'baza' => 'bazaa',
        'korisnik' => 'root',
        'lozinka' => ''
    ];
}else{
    $baza=[
        'server' => 'localhost',
        'baza' => 'maksimus_pp21',
        'korisnik' => 'maksimus_edunova',
        'lozinka' => 'edunova'
    ];
}

return [
    'ip' => $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false,
    'dev' => true,
    'nazivAPP' => 'Edunova APP',
    'url' => 'http://polaznik04.edunova.hr/',
    'baza' => $baza
]; 