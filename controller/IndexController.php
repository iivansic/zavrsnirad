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
    public function login()
    {
        $this->view->render('login',[
            'email' => '',
            'poruka' => 'Popunite traženje podatke'
        ]);
    }
    public function autorizacija()
    {
        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return;
        }
        if(strlen(trim($_POST['email']))===0){
            $this->view->render('login',[
                'email' => '',
                'poruka' => 'Obavezan unos email-a'
            ]);
            return;
        }
        if(strlen(trim($_POST['lozinka']))===0){
            $this->view->render('login',[
                'email' => trim($_POST['email']),
                'poruka' => 'Obavezan unos lozinke'
            ]);
            return;
        }
        // 100 % siguran da imam email i lozinku
       
    }

}