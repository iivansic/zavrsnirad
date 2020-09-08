<?php

class DeformacijaController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'deformacija' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}