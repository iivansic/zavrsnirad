<?php
class IndexController extends Controller
{
    public function index()
    {
       $this->view->render('pocetna');
    }
    public function onama()
    {
        $this->view->render('onama');
    }
}