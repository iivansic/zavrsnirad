<?php

class StrojnaobradaController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'strojnaobrada' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}