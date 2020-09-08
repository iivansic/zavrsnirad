<?php

class GlavnatablicaController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'glavnatablica' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}