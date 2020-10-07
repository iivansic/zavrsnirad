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
        if(!$this->kontrolaNaziv($glavnatablica,'novoView')){return;};
        if(!$this->kontrolaStanje($glavnatablica,'novoView')){return;};
        if(!$this->kontrolaLokacija($glavnatablica,'novoView')){return;};
        if(!$this->kontrolaStatus($glavnatablica,'novoView')){return;};
        if(!$this->kontrolaTehnologija($glavnatablica,'novoView')){return;};
        if(!$this->kontrolaTakt($glavnatablica,'novoView')){return;};
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
        /* KONTROLE NE RADE AKO UPALIM
        if(!$this->kontrolaPartnumber($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaNaziv($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaStanje($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaLokacija($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaStatus($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaTehnologija($glavnatablica,'promjenaView')){return;};
        if(!$this->kontrolaTakt($glavnatablica,'promjenaView')){return;};
        */ 
        Glavnatablica::promjena($_POST);
        $this->index();
    }

    private function novoView($poruka,$glavnatablica)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka' => $poruka,
            'glavnatablica' => $glavnatablica,
            'statusi' => Status::ucitajSve()
        ]);
    } 
    private function promjenaView($poruka,$glavnatablica)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka' => $poruka,
            'glavnatablica' => $glavnatablica,
            'statusi' => Status::ucitajSve()
          
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
    private function kontrolaNaziv($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->naziv))==0){
            $this->$view('Obavezan unos naziva', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->naziv))>25){
            $this->$view('Dužina naziva prevelika', $glavnatablica);
            return false;
        }
        return true;
    }
    private function kontrolaStanje($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->stanje))==0){
            $this->$view('Obavezan unos stanje', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->stanje))>5){
            $this->$view('Dužina naziva prevelika', $glavnatablica);
            return false;
        }
        return true;
    }
    private function kontrolaLokacija($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->lokacija))==0){
            $this->$view('Obavezan unos lokacije', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->lokacija))>10){
            $this->$view('Dužina lokacije prevelika', $glavnatablica);
            return false;
        }
        return true;
    }
    private function kontrolaStatus($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->status))==0){
            $this->$view('Obavezan odabir statusa', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->status))>9){
            $this->$view('Obavezan odabir statusa', $glavnatablica);
            return false;
        }
        if(($glavnatablica->status)==0){
            $this->$view('Obavezan odabir statusa', $glavnatablica);
            return false;
        }
        return true;
    }
    private function kontrolaTakt($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->takt))==0){
            $this->$view('Obavezan unos takta', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->takt))>8){
            $this->$view('Prevelik unos takta', $glavnatablica);
            return false;
        }
        return true;
    }
    private function kontrolaTehnologija($glavnatablica,$view)
    {
        if(strlen(trim($glavnatablica->tehnologija))==0){
            $this->$view('Obavezan unos tehnologije', $glavnatablica);
            return false;
        }
        if(strlen(trim($glavnatablica->tehnologija))>8){
            $this->$view('prevelik unos tehnologije', $glavnatablica);
            return false;
        }
        return true;
    }






}