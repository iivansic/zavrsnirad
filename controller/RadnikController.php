<?php

class RadnikController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'radnik' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $radnici= Radnik::ucitajSve();
        foreach($radnici as $radnik){
             if(strlen($radnik->lozinka)>20){
                $radnik->lozinka= substr($radnik->lozinka,0,20) . '...';
            }
            if(strlen($radnik->komentar)===0){
                $radnik->komentar= 'Nema komentar';
            }
             if(strlen($radnik->komentar)>20){
                $radnik->komentar=substr($radnik->komentar,0,20) . '...';
            }

        }
        $this->view->render($this->viewDir . 'index',[
            'radnici'=>$radnici
        ]);
        
    }
}