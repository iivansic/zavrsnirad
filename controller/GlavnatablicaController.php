<?php

class GlavnatablicaController extends AdminController
{
    private $viewDir = 'privatno'
    .DIRECTORY_SEPARATOR
    .'glavnatablica'
    .DIRECTORY_SEPARATOR;

    public function index()
    {
        if(isset($_GET['uvjet'])){
            $uvjet='%' . $_GET['uvjet'] . '%';
            $uvjetView=$_GET['uvjet'];
        }else{
            $uvjet='%';
            $uvjetView='';
        }
        if(isset($_GET['stranica'])){
            $stranica=$_GET['stranica'];
        }else{
            $stranica=1;
        }
        if($stranica==1){
            $prethodna=1;
            $prethodnap=1;
            $prethodnapp='';
        }else{
            $prethodna=$stranica - 1;
            $prethodnap=$stranica - 1;
            $prethodnapp=$stranica - 1;
        }

        
        $brojPozicija=Glavnatablica::ukupnoStranica();
        $ukupnoStranica=floor($brojPozicija/11);


        if($stranica==$ukupnoStranica){
            $sljedeca=$ukupnoStranica;
            $sljedecak=$ukupnoStranica;
            $sljedecakk='';
        }else{
            $sljedeca=$stranica + 1;
            $sljedecak=$stranica + 1;
            $sljedecakk=$stranica + 1;
        }

        $this->view->render($this->viewDir . 'index',[
            'glavnatablice'=>Glavnatablica::ucitajSve($stranica,$uvjet),
            'trenutna' => $stranica,
            'prethodna'=> $prethodna,
            'sljedeca' => $sljedeca,
            'ukupnoStranica' => $ukupnoStranica,
            'prethodnap'=> $prethodnap,
            'sljedecak' => $sljedecak,
            'sljedecakk' => $sljedecakk,
            'prethodnapp' => $prethodnapp,
            'uvjet' => $uvjetView
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
    public function promjena()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->promjenaView('Promjenite željene podatke', Glavnatablica::ucitaj($_GET['id']));
            return;
        }
  
        $Glavnatablica=(object)$_POST;
        Glavnatablica::promjena($_POST);
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
    private function promjenaView($poruka,$glavnatablica)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka' => $poruka,
            'glavnatablica' => $glavnatablica,
            'statusi' => Status::ucitajSve(),
          
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