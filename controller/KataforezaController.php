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
        //kontrole jel dobro ukucano ne radi mi kontrola partnumbera
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
    public function obojano()
    {
         
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['id'])) {
                $kataforeza=new stdClass();
                $this->obojanoView('Unesite tražene podatke',$kataforeza);
                return;
            }else{
                $this->obojanoView('Unesite tražene podatke',Kataforeza::ucitaj($_GET['id']));
                return;
                
            }
        }
        //kontrole jel dobro ukucano doradit ovo mora provjeravat jel ispravan id u kataforezi dal postoji...
        $kataforeza=(object)$_POST;
        if(!$this->kontrolaId($kataforeza,'obojanoView')){return;};
        if(!$this->kontrolaStanje($kataforeza,'obojanoView')){return;};
        Kataforeza::obojano($_POST);
        $this->index();  
    }
    
    private function novoView($poruka,$kataforeza)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka'=>$poruka,
            'kataforeza'=>$kataforeza
        ]);
    }
    private function obojanoView($poruka,$kataforeza)
    {
        $this->view->render($this->viewDir . 'obojano',[
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
    private function kontrolaID($kataforeza, $view)
    {

        if(($kataforeza->id)===''){
            $this->$view('Skenirajte ponovo karticu, u slučaju ponavljanja greške pozvati nadređenog.',$kataforeza);
            return false;
        }
        if (strlen(trim($kataforeza->id))===0){
            $this->$view('Obavezno unos broja ID broja',$kataforeza);
            return false;
        }
        if (strlen(trim($kataforeza->id))>10){
            $this->$view('ID broj prevelik',$kataforeza);
            return false;
        }
        // greška ovdje ako id se ne nalazi u kataforeza izbaci error
        $id = Kataforeza::id($kataforeza->id);
        if ($id==0){  //echo $partnumber;
            $this->$view('ID broj nije dobar ne nalazi se na spisku kataforeze.',$kataforeza);
            return false; 
        }
        return true;
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
        $partnumber = Kataforeza::partnumber($kataforeza->partnumber);
        if ($partnumber==0){ 
            $this->$view('Kataloški broj nije dobar',$kataforeza);
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
        // kako odradit da ova kontrola radi
        /*
        $stanje = Kataforeza::stanje($kataforeza->id);
        if ($stanje<($kataforeza->stanje)){ 
            $this->$view('Unos količine je veći od stanja količine pozicije na kataforezi.',$kataforeza);
            return false;
            }
            */
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
        if(($kataforeza->prioritet)<1){
            $this->$view('Prioritet može biti samo od 1 do 3.', $kataforeza);
            return false;
        }
        if(($kataforeza->prioritet)===''){
            $this->$view('Prioritet može biti samo od 1 do 3.', $kataforeza);
            return false;
        }
        return true;
    }


    
    



    
}