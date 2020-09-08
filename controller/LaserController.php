<?php

class LaserController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'laser' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}