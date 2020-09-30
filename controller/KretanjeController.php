<?php

class KretanjeController extends AutorizacijaController
{

    private $viewDir = 'privatno' 
    . DIRECTORY_SEPARATOR 
    . 'kretanje'
    . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index', [
            'kretanja'=>Kretanje::ucitajSve()
        ]);
    }


    public function novo()
    {
      
    }



    public function promjena()
    {
       
    }

    public function brisanje()
    {
       Kretanje::brisanje($_GET['id']);
       $this->index();
    }










    private function novoView($poruka,$smjer)
    {
       
    }

    private function promjenaView($poruka,$smjer)
    {
      
    }

}