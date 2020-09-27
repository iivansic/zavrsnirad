<?php

class KataforezaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
    .DIRECTORY_SEPARATOR
    .'kataforeza'
    .DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'kataforeze'=>Kataforeza::ucitajSve()
        ]);
    }
    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $kataforeza=new stdClass();
            $kataforeza->partnumber='';
            $kataforeza->stanje='';
            $kataforeza->prioritet='';
            $kataforeza->minobojat='';
            $kataforeza->lokacija='Uz zid';
            $this->novoView('Unesite tražene podatke',$kataforeza);
            return;
        }
        //želim ovo da bude u funkciji kontrolaPartnumber 
        //ako part number nije dobar ne povuce vec popunjena polja isto
        $partnumber = Kataforeza::partnumber($_POST['partnumber']);
        if ($partnumber==0){  //echo $partnumber;
            $this->view->render($this->viewDir . 'novo', [
                'poruka' => 'Nije dobar kataloški broj'
                ]);
                 return false; 
        }


        //RADI SE O POST I MORAM KONTROLIRAT PRIJE UNOSA U BAZU
        
        //kontrole jel dobro ukucano
        $kataforeza=(object)$_POST;
        if(!$this->kontrolaPartnumber($kataforeza,'novoView')){return;};
        if(!$this->kontrolaStanje($kataforeza,'novoView')){return;};
        if(!$this->kontrolaPrioritet($kataforeza,'novoView')){return;};
        Kataforeza::dodajNovi($_POST);
        $this->index();

    }
    public function promjena()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->promjenaView('Promjenite željene podatke', Kataforeza::ucitaj($_GET['id']));
            return;
        }
  
        $kataforeza=(object)$_POST;
        //kontrole jel dobro ukucano
        //if(!$this->kontrolaPartnumber($kataforeza,'promjenaView')){return;};
        if(!$this->kontrolaStanje($kataforeza,'promjenaView')){return;};
        if(!$this->kontrolaPrioritet($kataforeza,'promjenaView')){return;};
        Kataforeza::promjena($_POST);
        $this->index();
    }
    public function brisanje()
    {
        Kataforeza::brisanje($_GET['id']);
        $this->index();
    }
    private function novoView($poruka,$kataforeza)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka'=>$poruka,
            'kataforeza'=>$kataforeza
        ]);
    }
    private function promjenaView($poruka,$kataforeza)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>$poruka,
            'kataforeza'=>$kataforeza
        ]);
    }
    private function kontrolaPartnumber($kataforeza, $view)
    {
        if (strlen(trim($kataforeza->partnumber))===0){
            $this->$view('Obavezno unos broja Kataloškog broja',$kataforeza);
            return false;
        }
        if (strlen(trim($kataforeza->partnumber))>20){
            $this->$view('Kataloški broj prevelik',$kataforeza);
            return false;
        }
    return true;
    }
    private function kontrolaStanje($kataforeza, $view)
    {
        if (strlen(trim($kataforeza->stanje))===0){
            $this->$view('Obavezno unos broja komada',$kataforeza);
            return false;
        }
        if (($kataforeza->stanje)>9999){
            $this->$view('Unesite točan broj komada koje se šalju na bojanje.',$kataforeza);
            return false;
        }
    return true;
    }
    private function kontrolaPrioritet($kataforeza, $view)
    {
        if(strlen(trim($kataforeza->prioritet))>1){
            $this->$view('Prioritet može biti samo od 1 do 3.', $kataforeza);
            return false;
        }
        if(($kataforeza->prioritet)>3){
            $this->$view('Prioritet može biti samo od 1 do 3.', $kataforeza);
            return false;
        }
        if(($kataforeza->prioritet)===0){
            $this->$view('Prioritet može biti samo od 1 do 3.', $kataforeza);
            return false;
        }
   
    return true;
    }



    
}