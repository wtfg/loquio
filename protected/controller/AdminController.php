<?php


class AdminController extends DooController {
    public function beforeRun($resource, $action) {

        session_start();


        //if not login, group = anonymous
        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';

        //check against the ACL rules
        if ($rs = $this->acl()->process($role, $resource, $action)) {
            return $rs;
        }
    }
    function getContents($viewName, $data){
        $data = $data;
        include(Doo::conf()->SITE_PATH . "protected/viewc/" . $viewName . ".php");
        return $data;
    }
    function renderView($viewName, $data){
        include(Doo::conf()->SITE_PATH . "protected/viewc/" . $viewName . ".php");
        $this->renderc("base-template", $data);
    }
    public function showAdminPanel() {
        $this->renderView("panel-admin",array());
    }

    function editSiteConfig(){
        $instance = ConfigLoader::getInstance();
        $data['message'] = "";

        if(isset($_POST['lookAheadTime'])){
            $instance->setParams($_POST);
            $data['message'] = "Aggiornato!";
        }

        $data['config'] = $instance;
        $this->renderView("edit-siteconfig", $data);
    }


    function viewDocenti() {
        $docenti = $this->db()->find("docenti");
        $data = array("docenti"=>array());

        foreach ($docenti as $docente)
            array_push($data["docenti"],
                array(
                "nomemateria"=>$docente->getMateria() != false ? $docente->getMateria()->nome : "--",
                "viewnome" => $docente->getFullName(),
                "did"=>$docente->did,
                "attivo" =>$docente->attivo
                )
            );

        $this->renderView("view-docenti", $data);
    }

    function randomPassword() {
       return $this->load()->helper('DooTextHelper', true)->randomName(8);
    }

    function editDocenti() {
        Doo::loadModel('materie');
        Doo::loadModel('docenti');
        Doo::loadModel('utenti');
        $did = $this->params['id'];
        $data['materie'] = array();
        $materie = (new Materie())->find();

        foreach ($materie as $materia)
            array_push($data['materie'], array('id' => $materia->mid, 'nome' => stripslashes($materia->nome)));

        if (!isset($_POST['button'])) {

            $docente = (new Docenti())->getbyDid_first($did);

            $data = array(
                'did' => $docente->did,
                'materie' => $data['materie'],
                'email' => $docente->email,
                'mid' => $docente->mid,
                'nome' => stripslashes($docente->nome),
                'cognome' => stripslashes($docente->cognome),
                'telefono' => $docente->tel,
                'orelibere' => $docente->orelibere,
                'attivo' => ($docente->attivo == 1) ? "checked=\"checked\"" : ""
            );

            $this->renderView("edit-docenti", $data);

        } elseif (isset($_POST['did'])) {

            array_walk($_POST, create_function('&$val', '$val = trim($val);'));

            $_POST['orelibere'] = str_replace("\\","",trim($_POST['orelibere']));
            $_POST['attivo'] = isset($_POST['attivo'])? 1 : 0;

            if (!empty($_POST['did'])) {

                $docente = (new Docenti)->getbyDid_first($_POST["did"]);
                $oldmail = $docente->email;
                $docente->setFromPost($_POST);
               /* $docente->email = $_POST['email'];
                $docente->nome = $_POST['nome'];
                $docente->cognome = $_POST['cognome'];
                $docente->tel = $_POST['tel'];
                $docente->orelibere = $_POST['orelibere'];
                $docente->mid = $_POST['mid'];
                $docente->attivo = $_POST['attivo'];
                #$utente = Doo::loadModel("utenti", true);
                #$utente->email = $oldmail;*/

                $utente = (new Utenti)->getByEmail_first($oldmail); #$this->db()->find($utente, array("limit" => 1));
                $utente->nome = $docente->nome;
                $utente->cognome = $docente->cognome;
                $utente->telefono = $docente->tel;
                $utente->email  = $docente->email;

                $this->db()->update($docente);
                $userModified = $this->db()->update($utente);

                $data['messaggio'] = "Docente Modificato Con Successo!";

                if($userModified) $data['messaggio'] .= "<br>Il suo account utente e' stato sincronizzato con successo!";

                $data['url'] = Doo::conf()->APP_URL . "admin/docenti/";
                $data['titolo'] = "Ben fatto!";

                $this->renderc('ok-page',$data);
                return;

            } else {

                $this->renderc("error-page");
            }
        }
    }


    function deleteDocenti() {
        //echo 'You are visiting ' . $_SERVER['REQUEST_URI'];
        Doo::loadModel('docenti');
        Doo::loadModel('utenti');
        $did = $this->params['id'];
        $docente = Doo::loadModel("docenti", true);
        $docente->did = $did;
        $docente = (new Docenti)->getbyDid_first($did);

        $docentecorrelato = $this->db()->find($docente, array("limit"=>1));
        $utenti = new Utenti;
        $utenti->email = $docente->email;
        $utenti->acl = 1;
        $utente = $this->db()->find($utenti, array("limit"=>1));

        $this->db()->delete($docente);
        if($utente)
            $this->db()->delete($utente);

        $data['messaggio'] = "Docente e utente correlato eliminato con successo!";
        $data['url'] = Doo::conf()->APP_URL . "admin/docenti/";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }


    function sendNewTeacherMail($email, $pass){
        $subject = 'Il tuo account docente e stato creato!';

        $headers = "From: prenotazioni@loquio.it \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '
						<html>
					  <body bgcolor=\"#FAFAFA\">

							Il tuo account docente &eacute; stato creato con successo!<br><b>Non perdere e non cancellare questa email!<b>
							 Le tue credenziali di accesso al sito sono:<br><p>
							 Username: <b>'.$email.'</b><br>
							 Password: <b>'.$pass.'</b><br>
							 </p>

						  <br><br>Grazie Per L\'Attenzione!<br><em>Il Team Di Loquio</em>
					  </body>
					</html>';


        /*
         * Se non sei in locale rimuovi dal commento
         * il comando mail e commenta la linea $data['message']
         *
         */
        mail($email,  $subject, $message, $headers);
    }


    function deactivateDocenti(){
        Doo::loadModel('docenti');
        $d = new Docenti;
        $d->did =  $this->params['id'];
        $d->attivo = 0;
        $this->db()->update($d);

        $data['messaggio'] = "Docente Disattivato!";
        $data['url'] = Doo::conf()->APP_URL . "admin/docenti";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
        return;

    }

    function activateDocenti(){
        Doo::loadModel('docenti');
        $d = new Docenti;
        $d->did =  $this->params['id'];
        $d->attivo = 0;
        $this->db()->update($d);

        $data['messaggio'] = "Docente Attivato!";
        $data['url'] = Doo::conf()->APP_URL . "admin/docenti";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
        return;

    }
    function addDocenti() {

        if (!isset($_POST['button'])) {

            $materie = $this->db()->find("materie");
            $data['materie'] = array();
            foreach ($materie as $materia) {

                array_push($data['materie'], array('id' => $materia->mid, 'nome' => $materia->nome));
            }

            $data = $this->getContents("add-docenti", $data);
            $this->renderc("base-template", $data);


        } else {

            // {"Mon":{"seats":1,"timeslot":[9,10,11,12]},"Thu":{"seats":1,"timeslot":[9]}}

            if (isset($_POST['mid']) && isset($_POST['orelibere']) &&
                    isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['telefono'])) {

                $_POST['email'] = trim($_POST['email']);
                $_POST['mid'] = trim($_POST['mid']);
                $_POST['nome'] = trim($_POST['nome']);
                $_POST['cognome'] = trim($_POST['cognome']);
                $_POST['telefono'] = trim($_POST['telefono']);
                $_POST['orelibere'] = trim($_POST['orelibere']);

                if (!empty($_POST['email'])) {

                    $docente = Doo::loadModel("docenti", true);
                    $docente->email = $_POST['email'];
                    $docente->nome = $_POST['nome'];
                    $docente->cognome = $_POST['cognome'];
                    $docente->tel = $_POST['telefono'];
                    $docente->orelibere = str_replace("\\","",$_POST['orelibere']);
                    $docente->mid = $_POST['mid'];
                    $docente->attivo = 1;

                    $ran = $this->randomPassword();


                    $utente = Doo::loadModel("utenti", true);
                    $utente->email = $docente->email;
                    $utente->nome = $docente->nome;
                    $utente->cognome = $docente->cognome;
                    $utente->telefono = $docente->tel;
                    $utente->pass = md5($ran);
                    $utente->acl = 1;


                    // controlla se l'email già esiste
                    $existing = Doo::loadModel('Docenti', true);
                    $existing->email = $docente->email;
                    $isExisting = $this->db()->find($existing, array('limit' => 1));
                    $existingUser = Doo::loadModel('Utenti', true);
                    $existingUser->email = $docente->email;
                    $isExistingUser = $this->db()->find($existing, array('limit' => 1));

                    if (!$isExisting && !$isExistingUser) {

                        $res = $this->db()->insert($docente);
                        $res2 = $this->db()->insert($utente);
                        if ($res && $res2) {
                            // MESSAGGIO DOCENTE INSERITO
                            $this->sendNewTeacherMail($docente->email, $ran);
                            $data['messaggio'] = "Docente Inserito! Al docente verra inviata una mail con la sua password!";
                            $data['url'] = Doo::conf()->APP_URL. "admin/docenti/";
                            $data['titolo'] = "Ben fatto!";

                            // MESSAGGIO DOCENTE MODIFICATO
                            $this->renderc('ok-page',$data);
                            return;
                        }
                        $this->renderc("error-page");
                        return;
                    } else {
                        // MESSAGGIO ERRORE FICO
                        $this->renderc("error-page");
                    }
                }
            }
        }
    }

    function viewMaterie() {

        $materie = $this->db()->find("materie");
        $data = array("materie"=>array());

        foreach ($materie as $materia) {

            $d['nome'] = stripslashes($materia->nome);
            $d['mid'] = $materia->mid;

            array_push($data["materie"], $d);
        }
        $data = $this->getContents("view-materie", $data);
        $this->renderc("base-template", $data);
    }

    function editMaterie() {

        $mid = $this->params['id'];

        if (!isset($_POST['nome'])) {

            $materia = Doo::loadModel("materie", true);
            $materia->mid = $mid;
            $materia = $this->db()->find($materia, array('limit' => 1));

            $data['mid'] = $mid;
            $data['nome'] = stripslashes($materia->nome);

            $data = $this->getContents("edit-materie", $data);
            $this->renderc("base-template", $data);

        } else {
            $_POST['nome'] = trim($_POST['nome']);
            if (!empty($_POST['nome'])) {
                $materia = Doo::loadModel("materie", true);
                $materia->nome = $_POST['nome'];
                $materia->mid = $_POST['mid'];
                $materia->nome = $_POST['nome'];


                $this->db()->update($materia);

                $data['messaggio'] = "Materia inserita!";
                $data['url'] = Doo::conf()->APP_URL . "admin/materie/";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
                return;

            }
        }
    }

    function clearDB(){
        $materie = Doo::loadModel("materie", true);
        $docenti = Doo::loadModel("docenti", true);
        $prenotazioni = Doo::loadModel("prenotazioni", true);
        $bookoff = Doo::loadModel("bookoff", true);
        $this->db()->deleteAll($materie);
        $this->db()->deleteAll($prenotazioni);
        $this->db()->deleteAll($bookoff);
        $this->db()->deleteAll($docenti);

        $data['messaggio'] = "Database ripulito!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function deleteMaterie() {
        $mid = $this->params['id'];
        $materia = Doo::loadModel("materie", true);
        $materia->mid = $mid;

        $this->db()->delete($materia);
        $data['messaggio'] = "Materia Eliminata!";
        $data['url'] = Doo::conf()->APP_URL . "admin/materie/";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function addMaterie() {
        if (!isset($_POST['nome'])) {
            $data = $this->getContents("add-materie", array());
            $this->renderc("base-template", $data);
        } else {
            $_POST['nome'] = trim($_POST['nome']);
            if (!empty($_POST['nome'])) {
                $materia = Doo::loadModel("materie", true);
                $materia->nome = $_POST['nome'];
                $existing = $this->db()->find($materia, array('limit' => 1));
                if (!$existing) {

                    if ($this->db()->insert($materia)) {
                        $data['messaggio'] = "Materia Inserita!";
                        $data['url'] = Doo::conf()->APP_URL . "admin/materie/";
                        $data['titolo'] = "Ben fatto!";
                        
                        // MESSAGGIO DOCENTE MODIFICATO
                        $this->renderc('ok-page',$data);
                    }
                } else {
                    $this->renderc("error-page");
                }
            }
        }
    }

    function viewPrenotazioni() {
        $p = Doo::loadModel("prenotazioni", true);
        $prens = $this->db()->find($p, array('where' => 'data>' . mktime(0,0,0,date("n"),date("j"),date("Y"))));
        $pren = array("prenotazioni"=>array());

        foreach ($prens as $prenotazione) {
            $d['pid'] = $prenotazione->pid;
            $d['did'] = $prenotazione->did;
            $docentiModel = Doo::loadModel("docenti", true);
            $docentiModel->did = $d['did'];
            $da = $this->db()->find($docentiModel, array('limit' => 1));

            if($da == false){
                $del = Doo::loadModel("prenotazioni", true);
                $del->pid = $d['pid'];
                $this->db()->delete($del);
                echo "Eliminata Prenotazione Per Docente Inesistente<br>";
                continue;
            }

            $materieModel = Doo::loadModel("materie", true);
            $materieModel->mid = $da->mid;
            $materia = $this->db()->find($materieModel, array('limit' => 1));
            $d['materia_id'] = $materia->mid;
            #$d['pid'] = $d['pid'] ;
            $d['materia'] = stripslashes($materia->nome);
            $d['nome_docente'] = stripslashes($da->nome . " " . $da->cognome);
            $d['creata'] = $prenotazione->creata;
            $d['data'] = date("d-m-Y H:i", $prenotazione->data);
            $d['studente'] = stripslashes($prenotazione->studente);
            $d['classe'] = $prenotazione->classe;
            $d['email'] = $prenotazione->email;
            $d['tel'] = $prenotazione->tel;
            $d['codice_canc'] = $prenotazione->codicecanc;
            array_push($pren["prenotazioni"], $d);
        }
        #var_dump($pren);
        $data = $this->getContents('view-user-admin',  $pren);
        $this->renderc('base-template', $data);
        #echo 'You are visiting ' . $_SERVER['REQUEST_URI'];
    }

    function editGlobalSettings() {

        $data = $this->getContents("edit-globali",  $_SESSION['user']);
        $this->renderc("base-template", $data);
    }

}

?>