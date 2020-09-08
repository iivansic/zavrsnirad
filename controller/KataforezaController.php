<?php

class KataforezaController extends AdminController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'kataforeza' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'index');
        
    }
}