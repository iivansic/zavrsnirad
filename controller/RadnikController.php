<?php

class RadnikController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'radnik' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'radnici'=>Radnik::ucitajSve()
        ]);
        
    }
}