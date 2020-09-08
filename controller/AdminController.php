<?php

class AdminController extends AutorizacijaController
{
    public function __construct()
    {
       parent::__construct();
       if(($_SESSION['autoriziran']->radnomjesto!=='admin')){
           unset($_SESSION['autoriziran']);
           session_destroy();
        $this->view->render('login',[
            'email' => '',
            'poruka' => 'Prvo se autorizirajte userom koji ima veće ovlasti'
        ]);
        exit;
       }
    }
}

