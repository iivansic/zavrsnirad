<?php

class GlavnatablicaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
    .DIRECTORY_SEPARATOR
    .'Glavnatablica'
    .DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'glavnatablice'=>Glavnatablica::ucitajSve()
        ]);
    }














}