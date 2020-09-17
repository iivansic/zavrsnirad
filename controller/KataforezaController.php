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
            'kataforeza'=>Kataforeza::ucitajSve()
        ]);
    }
}