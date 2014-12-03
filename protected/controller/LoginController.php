<?php

class LoginController extends DooController {

    /**
     * Prima pagina vista, se sei loggato ti manda al pannello
     * sennò ti manda al login/registrazione
     */
    function firstPage() {


        session_start();

        if (isset($_SESSION['user'])) {

            $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';
            
            if ($rs = $this->acl()->process($role, "LoginController", "firstPage")) {
                return $rs;
            } else {
                switch ($role){
                    case "docente":
                        $this->showDocentePanel();
                        break;
                    case "user":
                        $this->showUserPanel();
                        break;
                    case "admin":
                        return Doo::conf()->APP_URL . "admin";
                        break;
                    default:
                        $this->renderc("error-page");
                }
                
            }
        } else {
            $this->view()->renderc('login-page');
        }
    }

    #

    function registerPage() {
        
        /*
         * Renderizza il form di registrazione
         */
        
        session_start();
        if (!isset($_SESSION['user'])) {
            $this->view()->renderc('register-page');
        } else {
            return Doo::conf()->APP_URL;
        }
    }

    #


    function validateUser() {

        /*
         * Link di validazione utente
         */

        $token = $this->params['id'];
        $data = explode("+", str_rot13(base64_decode($token)));

        if (sizeof($data) == 2) {

            $user = Doo::loadModel('utenti', true);
            
            $user->email = $data[0];
            $user->acl = $data[1];

            $user = $this->db()->find($user, array('limit' => 1));

            if ($user) {
                
                $user->acl = 0;
                $this->db()->update($user);
                $dat['message'] = "Validato con successo";
                
                
            } else {
                /*
                * Esegue un render dell'errore
                * 
                * e mostra l'errore
                */
                $this->renderc("error-page");
            }
        } else {

            /*
            * Esegue un render dell'errore
            * 
            * e mostra l'errore
            */
            $this->renderc("error-page");
        }
            
        /*
        * Esegue un render della pagina di successo 
        * e riporta al pannello
        */
        $data['messaggio'] = "Ora puoi accedere al pannello di login fra pochissimi secondi!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Validato!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    #

    function insertUser() {

        /*
         * Metodo POST che inserisce l'utente nel DB e invia 
         * una email di validazione
         */

        $data['message'] = Doo::conf()->APP_URL;

        if (isset($_POST['email']) && isset($_POST['pass']) &&
                isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['telefono'])) {

            $_POST['email'] = trim($_POST['email']);
            $_POST['pass'] = trim($_POST['pass']);
            $_POST['nome'] = trim($_POST['nome']);
            $_POST['cognome'] = trim($_POST['cognome']);
            $_POST['telefono'] = trim($_POST['telefono']);
    #        $_POST['altramail'] = trim($_POST['altramail']);

            if (!empty($_POST['email']) && !empty($_POST['pass'])) {

                $user = Doo::loadModel('utenti', true);
                $user->email = $_POST['email'];
                $user->nome = $_POST['nome'];
                $user->cognome = $_POST['cognome'];
                $user->telefono = $_POST['telefono'];
    #            $user->altramail = $_POST['altramail'];
                $user->pass = md5($_POST['pass']);
                $user->acl = rand(2061994, 99914071);
                $mail = $user->email;

                // controlla se l'email già esiste

                $existing = Doo::loadModel('utenti', true);
                $existing->email = $user->email;
                $isexisting = $this->db()->find($existing, array('limit' => 1));

                if (!$isexisting) {
                    $res = $this->db()->insert($user);
                    if ($res) {
                        $data['message'] = base64_encode(str_rot13($user->email . "+" . $user->acl));

                        $subject = 'Verifica iscrizione';

                        $headers = "From: prenotazioni@loquio.it \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $message = '
						<html> 
					  <body>
						 
							Clicca o copia il link riportato qua sotto per attivare la tua registrazione <br> 
							<font color=\"red\"><a href="' . Doo::conf()->APP_URL . 'register/complete/' . $data['message'] . '">
                        ' . Doo::conf()->APP_URL . 'register/complete/' . $data['message'] . '
                        </a></font> <br> 
						
						  <br><br>Grazie Per L\'Attenzione!<br><em>Il Team Di Loquio</em>
					  </body> 
					</html>';
                        

                        /*
                         * Se non sei in locale rimuovi dal commento
                         * il comando mail e commenta la linea $data['message']
                         * 
                         */
                         mail($mail,  $subject, $message, $headers);

                        //$data['messaggio'] = "FAKE MAIL<br>" .
                        //        $mail . "<br><br>" . $subject . "<br><br>" . $message . "<br><br>" . $headers;

                        $data['messaggio'] = "Presto riceverai una email con il codice di attivazione del tuo account!<br><b>Attenzione, la mail potrebbe comparire come Posta Indesiderata o Spam, assicurati di controllare bene la posta!</b>";
                        $data['url'] = Doo::conf()->APP_URL;
                        $data['titolo'] = "Benvenuto!";
                        
                        // MESSAGGIO DOCENTE MODIFICATO
                        $this->renderc('ok-page',$data);
                    }
                } else {
                    /*
                     * TODO 
                     * deve ritornare l'errore che il nome utente già esiste
                     */
                    $this->renderc("error-page");
                }
            }
        }
    }

    #

    function logIn() {

        if (isset($_POST['email']) && isset($_POST['pass'])) {

            $_POST['email'] = trim($_POST['email']);
            $_POST['pass'] = md5(trim($_POST['pass']));

            if (!empty($_POST['email']) && !empty($_POST['pass'])) {

                $user = Doo::loadModel('utenti', true);
                $user->email = $_POST['email'];
                $user->pass = $_POST['pass'];
                $user = $this->db()->find($user, array('limit' => 1));

                if ($user) {

                    session_start();
                    switch ($user->acl) {
                        case 0:
                            $acl = "user";
                            break;
                        case 1:
                            $acl = "docente";
                            break;
                        case 2:
                            $acl = "admin";
                            break;
						default:
                            if($user->acl > 2){
                                ###
                            }
							$this->renderc("error-page");
							return;
                    }
                    unset($_SESSION['user']);
                    $_SESSION['user'] = array(
                        'id' => $user->uid,
                        'username' => $user->email,
                        'acl' => $acl,
                    );

                    switch ($user->acl) {
                        case 0:
                            return Doo::conf()->APP_URL;
                            break;
                        case 1:
                            
                            return Doo::conf()->APP_URL . "prenotazioni/list";
                            break;
                        case 2:
                            
                            return Doo::conf()->APP_URL . "admin";
                            break;
                    }
                }
            }
        }

        /*
         * Inserisci una pagina d'errore stilosa
         */
        $this->renderc("error-page");
        //echo 'You are visiting '.$_SERVER['REQUEST_URI'];
    }
    function getContents($viewName, $data){
        $data = $data;
        include(Doo::conf()->SITE_PATH . "protected/viewc/" . $viewName . ".php");
        return $data;
    }
    #

    function logOut() {

        session_start();
        unset($_SESSION['user']);
        session_destroy();
        return Doo::conf()->APP_URL;
    }

    #

    function showUserPanel() {

        if(!isset($_SESSION['user'])){
            session_start();
        }

        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';


        if ($rs = $this->acl()->process($role, "LoginController", "showUserPanel")) {

            return $rs;
        }
        $utenti = Doo::loadModel("utenti",true);
        $utenti->email = $_SESSION['user']['username'];

        $utenti = $this->db()->find($utenti, array("limit"=>1));
        if($utenti === false){
            $data['messaggio'] = "I tuo dati sono stati modificati, ti stiamo disconnettendo per la tua sicurezza";
            $data['url'] = Doo::conf()->APP_URL."logout";
            $data['titolo'] = "Validato!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
        }else{
             $this->renderc("base-template", $this->getContents("panel-user", array()));
        }/*
         * Esegue un render del tipo
         * 
         * e mostra il pannello di controllo
         */
    }


    function lostPassword() {
        if(isset($_POST['email'])){
            $u = Doo::loadModel('utenti', true);
            $u->email = $_POST['email'];
            $result = $this->db()->find($u,array("limit"=>1));
            if($result){

                $subject = 'Cambio password';

                $headers = "From: prenotazioni@loquio.it \r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $link = Doo::conf()->APP_URL . 'reset/' . base64_encode(str_rot13($result->email."|".$result->pass."|".time()));
                $message = '
						<html>
					  <body>

							Se vuoi rimpostare la tua password devi cliccare su questo link entro 24 ore, altrimenti scadr&aacute; il link. <br>
							<font color=\"red\"><a href="' . $link. '">
                        ' . $link . '
                        </a></font> <br>
                        Se non hai richiesto di impostare la tua password, ignora questo messaggio.<br>

						  <br><br>Grazie Per L\'Attenzione!<br><em>Il Team Di Loquio</em>
					  </body>
					</html>';


                /*
                 * Se non sei in locale rimuovi dal commento
                 * il comando mail e commenta la linea $data['message']
                 *
                 */
               # mail($mail,  $subject, $message, $headers);

                mail($result->email, $subject, $message, $headers);
                //var_dump($result);
                $data['messaggio'] = "Se la tua mail risulta corretta ti arriver&aacute; una mail con il link per reimpostare la password";
                $data['url'] = Doo::conf()->APP_URL;
                $data['titolo'] = "Ben Fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
            }
            else{
                $data['messaggio'] = "Se la tua mail risulta corretta ti arriver&aacute; una mail con il link per reimpostare la password";
                $data['url'] = Doo::conf()->APP_URL;
                $data['titolo'] = "Ben Fatto!";
                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
            }
            // email|passmd5|
        }else{
            $this->renderc("lost-password");

            # $this->renderc('lost-password');
        }
    }

    function resetPassword() {

        if(isset($this->params['id'])){
            if(isset($_POST["uid"])){
                $u = Doo::loadModel('utenti', true);
                $u->uid = $_POST["uid"];
                $u->pass = md5($_POST["pass"]);
                $this->db()->update($u);

                # stampa un ok!
                $data['messaggio'] = "Password reimpostata con successo!";
                $data['url'] = Doo::conf()->APP_URL;
                $data['titolo'] = "Ben Fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);


            }else{
                $u = Doo::loadModel('utenti', true);
                $base = str_rot13(base64_decode($this->params['id']));
                $user = explode("|", $base)[0];
                $pass = explode("|", $base)[1];
                $time = explode("|", $base)[2];
                $difference = (time() - $time )/3600;
                if($difference > 24){
                    $this->renderc("error-page");
                    return;
                }
                $u->email = $user;
                $u->pass = $pass;
                $result = $this->db()->find($u, array("limit"=>1));

                if($result){
                    $this->renderc("reset-password", array("uid"=> $result->uid));
                }
            }
        }else{
            #error
            $this->renderc("error-page");
            return;
           # $this->renderc('lost-password');
        }
    }

    function privacyPolicy(){
        $this->renderc("privacy-policy");
    }

    function showDocentePanel() {
        if(!isset($_SESSION['user'])){
            session_start();
        }
        
        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';

        if ($rs = $this->acl()->process($role, "LoginController", "showDocentePanel")) {
           
           return $rs;
        }

        $id = $_SESSION["user"]["id"];

        $d = Doo::loadModel("docenti",true);
        $d->email = $_SESSION["user"]["username"];
        $d = $this->db()->find($d, array("limit"=>1));
        if($d === false){
            $data['messaggio'] = "I tuo dati sono stati modificati, ti stiamo disconnettendo per la tua sicurezza";
            $data['url'] = Doo::conf()->APP_URL."logout";
            $data['titolo'] = "Validato!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
        }else{
            $data = array("id"=>$d->did);
            $this->renderc("base-template", $this->getContents("panel-docente", $data));
        }
        /*
         * Esegue un render del tipo
         *
         * e mostra il pannello di controllo docente
         */
    }

}

?>