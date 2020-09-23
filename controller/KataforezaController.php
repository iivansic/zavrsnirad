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
        $this->view->render($this->viewDir . 'novo', [
            'poruka' => 'Unesite tražene podatke'
            
        ]);
        return;
        }

        $partnumber = Kataforeza::partnumber($_POST['partnumber']);
        if ($partnumber==0){  //echo $partnumber;
            $this->view->render($this->viewDir . 'novo', [
                'poruka' => 'nije dobar kataloški broj i vrati ga na view novo'
                
            ]);
            return;
        }

        //RADI SE O POST I MORAM KONTROLIRAT PRIJE UNOSA U BAZU
        Kataforeza::dodajNovi($_POST);
        $this->index();

    }
    public function promjena()
    {
        
    }
    public function brisanje()
    {
        
    }

}