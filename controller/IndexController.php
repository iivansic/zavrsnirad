<?php
class IndexController extends Controller
{
    public function index()
    {
       $this->view->render('pocetna',[
           'kljuc1' => 'Vrijednost1',
           'kljuc2' => [1,2,7,9]
       ]);
    }
    public function onama()
    {
        $this->view->render('onama');
    }
}