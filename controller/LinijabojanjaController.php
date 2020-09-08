<?php

class LinijabojanjaController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'linijabojanja' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}