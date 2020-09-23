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

    public function notfound($poruka)
    {
        $this->view->render('notfound', ['poruka'=>$poruka]);
    }



    public function login()
    {
        if($this->kontrolaLogiran()){
            return;
        }
        $this->loginView('', 'Popunite traženje podatke');
    }

    public function logout()
    {
            unset($_SESSION['autoriziran']);
            session_destroy();
            $this->index();
    }



    public function autorizacija()
    {
        
        if($this->kontrolaLogiran()){
            return;
        }
    

        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return;
        }
        if(strlen(trim($_POST['email']))===0){
            $this->loginView(trim($_POST['email']), 'Obavezan unos email-a');
            return;
        }
        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView(trim($_POST['email']), 'Obavezan unos lozinke');
            return;
        }
        // 100 % siguran da imam email i lozinku

        $veza=DB::getInstanca();
       
        $izraz = $veza->prepare('select * from radnik where email=:email');
        $izraz->execute(['email'=>$_POST['email']]);
        $rezultat=$izraz->fetch();

        if($rezultat==null){
            $this->loginView(trim($_POST['email']), 'unesena email adresa ne postoji u sustavu');
            return;
        }

        if(!password_verify($_POST['lozinka'], $rezultat->lozinka)){
            $this->loginView(trim($_POST['email']), 'Za uneseni email nije ispravna lozinka');
            return;
        }

        // ovdje sam autoriziran

        unset($rezultat->lozinka);
        $_SESSION['autoriziran']=$rezultat;
        $np=new NadzornaplocaController();
        $np->index();    

    }

    private function loginView($email,$poruka){
        $this->view->render('login',[
            'email' => $email,
            'poruka' => $poruka
        ]);
    }

    private function kontrolaLogiran(){
        if(isset($_SESSION['autoriziran'])){
            $np = new NadzornaplocaController();
            $np -> index(); 
            return true;
        }
        return false;
    }

    public function test(){
        //echo password_hash("a",PASSWORD_BCRYPT);
        // masivni imput u bazu
        // $veza = DB::getInstanca();
        // $veza->beginTransaction();
        // for ($i=0;$i<2000;$i++){
            // $izraz = $veza->prepare(
               //  'insert into glavnatablica (partnumber,naziv,status,stanje) values (:partnumber,:naziv,:status,:stanje);');
           //  $izraz->execute([
                // 'partnumber'=> 16000000 + $i,
                // 'naziv'=>'Generirani broj' . $i,
                // 'status' => 1,
                // 'stanje' => 0
           //  ]);
            // echo 'Gotov ' . $i . '<br/>';
        // }
       //  $veza->commit();





    }

}

