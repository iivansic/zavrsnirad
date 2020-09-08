<?php

class ZavarivanjeController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'zavarivanje' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}