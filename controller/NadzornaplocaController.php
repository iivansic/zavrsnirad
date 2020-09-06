<?php

class NadzornaplocaController extends Controller
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR;
    public function index()
    {
        $this->view->render($this->viewDir . 'nadzornaploca');
        
    }
}