<?php

class Lb1Controller extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'Lb1' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}