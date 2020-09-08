<?php

class DispecerController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'dispecer' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}