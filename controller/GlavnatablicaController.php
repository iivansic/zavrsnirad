<?php

class GlavnatablicaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
    .DIRECTORY_SEPARATOR
    .'glavnatablica'
    .DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'glavnatablice'=>Glavnatablica::ucitajSve()
        ]);
    }

    public function brisanje()
    {
        //kontrola dali je id došao
       Glavnatablica::brisanje($_GET['id']);
       $this->index();
    }
    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $glavnatablica=new stdClass();
            $glavnatablica->partnumber='';
            $glavnatablica->naziv='';
            $glavnatablica->stanje='';
            $glavnatablica->lokacija='';
            $glavnatablica->status=0;
            $glavnatablica->tehnologija='';
            $glavnatablica->takt='';
            $glavnatablica->opis='';
            $this->novoView('Unesite tražene podatke',$glavnatablica,Status::ucitajSve());
            return;
        }

        $glavnatablica=(object)$_POST;

        if(!$this->kontrolaPartnumber($glavnatablica,'novoView')){return;};
        Glavnatablica::dodajNovi($_POST);
        $this->index();

    }
    private function novoView($poruka,$glavnatablica,$statusi)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka' => $poruka,
            'glavnatablica' => $glavnatablica,
            'statusi' => $statusi
        ]);
    } 
    private function promjenaView($poruka,$radnik,$statusi)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka' => $poruka,
            'glavnatablica' => $glavnatablica
        ]);
    }
    private function kontrolaPartnumber($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->partnumber))===0){
            $this->$view('Obavezno unos kataloškog broja', $glavnatablica);
            return false;
        }
        if(strlen( trim($glavnatablica->partnumber))>20){
            $this->$view('Duzina kataloškog broja prevelika', $glavnatablica);
            return false;
        }
        // na kraju uvijek vrati true
        return true;
    }






}