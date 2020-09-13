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
    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->novoView('Unesite tražene podatke',[
                'ime' => '',
                'prezime' => '',
                'radnomjesto' =>'',
                'email'=>'@.hr',
                'lozinka'=>'',
                'komentar' => ''
            ]);
            return;
        }
        // radi se o POST i moram kontrolirati prije unosa u bazu
        // kontroler mora kontrolirat vrijednosti prije nego se ode u bazu
        $radnik=$_POST;

        if (strlen(trim($radnik['ime']))===0){
            $this->novoView('Obavezno unos imena');
            return;
        }
        Radnik::dodajNovi($_POST);
        // unese i prebaci me na popis radnika
        $this->index();
        //unese i ostavi te s svim podacima na trenutnoj stranici
        //$this->novoView('radnik unesen, nastavite s unosom novih podataka',$_POST);
    }
    public function promjena()
    {
        $this->view->render($this->viewDir . 'promjena');
    }
    public function brisanje()
    {
        $this->view->render($this->viewDir . 'brisanje');
    }
    private function novoView($poruka,$radnik)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka' => $poruka,
            'radnik' => $radnik
        ]);
    } 
}

