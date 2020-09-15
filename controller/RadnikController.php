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
            $radnik=new stdClass();
            $radnik->ime='';
            $radnik->prezime='';
            $radnik->email='@sdfgroup.com';
            $radnik->lozinka='';
            $radnik->komentar='';
            $radnik->radnomjesto='';
            $this->novoView('Unesite tražene podatke',$radnik);
            return;
        }
        // radi se o POST i moram kontrolirati prije unosa u bazu
        // kontroler mora kontrolirat vrijednosti prije nego se ode u bazu
        $radnik=(object)$_POST;
        //kontrole jel dobro ukucano
        if(!$this->kontrolaIme($radnik,'novoView')){return;};
        if(!$this->kontrolaPrezime($radnik,'novoView')){return;};

        Radnik::dodajNovi($_POST);
        // unese i prebaci me na popis radnika
        $this->index();
        //unese i ostavi te s svim podacima na trenutnoj stranici
        //$this->novoView('radnik unesen, nastavite s unosom novih podataka',$_POST);
    }
    public function promjena()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            //print_r(Radnik::ucitaj($_GET['id']));
            $this->promjenaView('Promjenite željene podatke', Radnik::ucitaj($_GET['id']));
            return;
        }
  
        $radnik=(object)$_POST;
        //kontrole jel dobro ukucano
        if(!$this->kontrolaIme($radnik,'promjenaView')){return;};
        if(!$this->kontrolaPrezime($radnik,'promjenaView')){return;};
        Radnik::promjena($_POST);
        $this->index();
    }
    public function brisanje()
    {
        //kontrola dali je id došao
       Radnik::brisanje($_GET['id']);
       $this->index();
    }
    private function novoView($poruka,$radnik)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka' => $poruka,
            'radnik' => $radnik
        ]);
    } 
    private function promjenaView($poruka,$radnik)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka' => $poruka,
            'radnik' => $radnik
        ]);
    }
        //kontrole jel dobro ukucano vidi još gore if ima
    private function kontrolaIme($radnik,$view)
    {
        if(strlen(trim($radnik->ime))===0){
            $this->$view('Obavezno unos imena', $radnik);
            return false;
        }
        if(strlen(trim($radnik->ime))>20){
            $this->$view('Duzina imena prevelika', $radnik);
            return false;
        }
        // na kraju uvijek vrati true
        return true;
    }
    private function kontrolaPrezime($radnik,$view)
    {
        if(strlen(trim($radnik->prezime))===0){
            $this->$view('Obavezno unos prezimena', $radnik);
            return false;
        }
        if(strlen(trim($radnik->prezime))>20){
            $this->$view('Duzina prezimena prevelika', $radnik);
            return false;
        }
        // na kraju uvijek vrati true
        return true;
    }
}

