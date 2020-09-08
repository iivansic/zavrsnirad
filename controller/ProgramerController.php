<?php

class ProgramerController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'programer' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}