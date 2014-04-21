<?php

class LoginController extends DooController {
    /*
     * 
     * 
     * TODO mostrare pannello di controllo
     * TODO pannello prenotazioni
     * TODO pagina di errore stilosa
     * 
     * TODO pagina di validazione fica
     * TODO ritornare che il nome utente già esiste
     * TODO pannello docente
     * 
     * 
     */
    
    function firstPage() {
        
        /*
         * Prima pagina vista, se sei loggato ti manda al pannello
         * sennò ti manda al login/registrazione
         */

        session_start();

        if (isset($_SESSION['user'])) {

            $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';
            
            if ($rs = $this->acl()->process($role, "LoginController", "firstPage")) {

               // var_dump($this->acl()->process($role, "LoginController", "firstPage"));
                
                return $rs;
                
            } else {
                switch ($role){
                    case "docente":
                        return Doo::conf()->APP_URL . "prenotazioni/list";
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
                //$this->view()->renderc('control-panel', $data);
                
                /*
                 * Esegue un render del tipo
                 * $this->view()->renderc('control-panel', $data);
                 * e mostra il pannello di controllo
                 */
                
            }
        } else {
            
            /*
            * Esegue un render del tipo
            * 
            * e mostra l'errore
            */
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
            $_POST['altramail'] = trim($_POST['altramail']);

            if (!empty($_POST['email']) && !empty($_POST['pass'])) {

                $user = Doo::loadModel('utenti', true);
                $user->email = $_POST['email'];
                $user->nome = $_POST['nome'];
                $user->cognome = $_POST['cognome'];
                $user->telefono = $_POST['telefono'];
                $user->altramail = $_POST['altramail'];
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
					  <body bgcolor=\"#FAFAFA\"> 
						 
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

                        $data['messaggio'] = "Presto riceverai una email con il codice di attivazione del tuo account!";
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
        $this->view()->renderc('panel-user');
        /*
         * Esegue un render del tipo
         * 
         * e mostra il pannello di controllo
         */
    }
    function lostPassword() {
        if(!isset($_POST['invia'])){
            $u = Doo::loadModel('utenti', true);
            $u->email = $_POST['email'];
            $result = $this->db()->find($u,array("limit"=>1));
            if($result){
                $altramail = $result->altramail;
                if($altramail != NULL){
                    $data['mail'] = $altramail;
                    mail($altramail, "Reimpostazione Password", "___");
                }
            }
            
        }else{
            $this->renderc('lost-password');
        }
    }
    function showDocentePanel() {
        if(!isset($_SESSION['user'])){
            session_start();
        }
        
        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';

        if ($rs = $this->acl()->process($role, "LoginController", "showDocentePanel")) {
           
           return $rs;
        }
         
        /*
         * Esegue un render del tipo
         *
         * e mostra il pannello di controllo docente
         */
    }

}

?>