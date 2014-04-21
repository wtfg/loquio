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

    function showAdminPanel() {
        $this->renderc("panel-admin");
    }

    function viewDocenti() {
        /**
         * Funzione che imposta lo script per la view del docente
         */
        $docenti = $this->db()->find("docenti");
        $data = array();
        foreach ($docenti as $docente) {


            $m = Doo::loadModel("materie", true);
            $m->mid = $docente->mid;
            $m = $this->db()->find($m, array("limit" => 1));
            if ($m) {
                $d['nomemateria'] = $m->nome;
            } else {
                $d['nomemateria'] = "--";
            } $d['viewnome'] = $docente->nome . " " . $docente->cognome;
            $d['did'] = $docente->did;
            $d['attivo'] = $docente->attivo;
            

            array_push($data, $d);
        }

        $this->renderc("view-docenti", $data);
    }

    function editDocenti() {
        // Dato un ID pagina mostra la scheda di modifica del docente
        // oppure se sta inserendo te lo comunica

        $did = $this->params['id'];
        $materie = $this->db()->find("materie");
        $data['materie'] = array();
        foreach ($materie as $materia) {

            array_push($data['materie'], array('id' => $materia->mid, 'nome' => $materia->nome));
        }

        if (!isset($_POST['button'])) {

            $docente = Doo::loadModel("docenti", true);
            $docente->did = $did;
            $docente = $this->db()->find($docente, array("limit" => 1));

            $data['did'] = $docente->did;
            $data['email'] = $docente->email;
            $data['mid'] = $docente->mid;
            $data['nome'] = $docente->nome;
            $data['cognome'] = $docente->cognome;
            $data['telefono'] = $docente->tel;
            $data['orelibere'] = $docente->orelibere;
            if ($docente->attivo == 1) {
                $data['attivo'] = "checked=\"checked\"";
            } else {
                $data['attivo'] = "";
            }
            $this->renderc("edit-docenti", $data);
        } else {
            if (isset($_POST['did'])) {

                $_POST['did'] = trim($_POST['did']);
                $_POST['email'] = trim($_POST['email']);
                $_POST['mid'] = trim($_POST['mid']);
                $_POST['nome'] = trim($_POST['nome']);
                $_POST['cognome'] = trim($_POST['cognome']);
                $_POST['telefono'] = trim($_POST['telefono']);
                $_POST['orelibere'] = str_replace("\\","",trim($_POST['orelibere']));
                $_POST['attivo'] = isset($_POST['attivo'])? 1 : 0;

                if (!empty($_POST['did'])) {

                    $docente = Doo::loadModel("docenti", true);
                    $docente->did = $_POST['did'];
                    $docente = $this->db()->find($docente, array("limit" => 1));
                    $docente->email = $_POST['email'];
                    $docente->nome = $_POST['nome'];
                    $docente->cognome = $_POST['cognome'];
                    $docente->tel = $_POST['telefono'];
                    $docente->orelibere = $_POST['orelibere'];
                    $docente->mid = $_POST['mid'];
                    $docente->attivo = $_POST['attivo'];

                    if ($res = $this->db()->update($docente)) {

                        $data['messaggio'] = "Docente Modificato Con Successo!";
                        $data['url'] = Doo::conf()->APP_URL;
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

    function deleteDocenti() {
        //echo 'You are visiting ' . $_SERVER['REQUEST_URI'];

        $did = $this->params['id'];
        $docente = Doo::loadModel("docenti", true);
        $docente->did = $did;

        $this->db()->delete($docente);
        
        $data['messaggio'] = "Docente Eliminato Con Successo!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function addDocenti() {

        if (!isset($_POST['button'])) {


            $materie = $this->db()->find("materie");
            $data['materie'] = array();
            foreach ($materie as $materia) {

                array_push($data['materie'], array('id' => $materia->mid, 'nome' => $materia->nome));
            }

            $this->renderc("add-docenti", $data);
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

                    // controlla se l'email già esiste
                    $existing = Doo::loadModel('Docenti', true);
                    $existing->email = $docente->email;
                    $isexisting = $this->db()->find($existing, array('limit' => 1));

                    if (!$isexisting) {
                        $res = $this->db()->insert($docente);
                        if ($res) {
                            // MESSAGGIO DOCENTE INSERITO
                            $data['messaggio'] = "Docente Inserito!";
                            $data['url'] = Doo::conf()->APP_URL;
                            $data['titolo'] = "Ben fatto!";

                            // MESSAGGIO DOCENTE MODIFICATO
                            $this->renderc('ok-page',$data);
                        }
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
        $data = array();



        foreach ($materie as $materia) {

            $d['nome'] = $materia->nome;
            $d['mid'] = $materia->mid;

            array_push($data, $d);
        }

        $this->renderc("view-materie", $data);
    }

    function editMaterie() {

        $mid = $this->params['id'];

        if (!isset($_POST['nome'])) {


            $materia = Doo::loadModel("materie", true);
            $materia->mid = $mid;
            $materia = $this->db()->find($materia, array('limit' => 1));

            $data['mid'] = $mid;
            $data['nome'] = $materia->nome;

            $this->renderc("edit-materie", $data);
        } else {
            $_POST['nome'] = trim($_POST['nome']);
            if (!empty($_POST['nome'])) {
                $materia = Doo::loadModel("materie", true);
                $materia->nome = $_POST['nome'];
                $materia->mid = $_POST['mid'];

                $existing = Doo::loadModel("materie", true);
                $materia->nome = $_POST['nome'];
                $existing = $this->db()->find($materia, array('limit' => 1));
                if (!$existing) {

                    if ($this->db()->update($materia)) {
                        $data['messaggio'] = "Materia inserita!";
                        $data['url'] = Doo::conf()->APP_URL;
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

    function deleteMaterie() {
        $mid = $this->params['id'];
        $materia = Doo::loadModel("materie", true);
        $materia->mid = $mid;

        $this->db()->delete($materia);
        $data['messaggio'] = "Materia Eliminata!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function addMaterie() {
        if (!isset($_POST['nome'])) {
            $this->renderc("add-materie");
        } else {
            $_POST['nome'] = trim($_POST['nome']);
            if (!empty($_POST['nome'])) {
                $materia = Doo::loadModel("materie", true);
                $materia->nome = $_POST['nome'];
                $existing = $this->db()->find($materia, array('limit' => 1));
                if (!$existing) {

                    if ($this->db()->insert($materia)) {
                        $data['messaggio'] = "Materia Inserita!";
                        $data['url'] = Doo::conf()->APP_URL;
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
        $prens = $this->db()->find($p, array('where' => 'data>' . time()));
        $pren = array();

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
            $materieModel->did = $d['did'];
            $materia = $this->db()->find($materieModel, array('limit' => 1));
            $d['materia_id'] = $materia->mid;
            $d['materia'] = $materia->nome;
            $d['nome_docente'] = $da->nome . " " . $da->cognome;
            $d['creata'] = $prenotazione->creata;
            $d['data'] = date("d-m-Y", $prenotazione->data);
            $d['studente'] = $prenotazione->studente;
            $d['classe'] = $prenotazione->classe;
            $d['email'] = $prenotazione->email;
            $d['tel'] = $prenotazione->tel;
            $d['codice_canc'] = $prenotazione->codicecanc;
            array_push($pren, $d);
        }
        #var_dump($pren);
        $this->renderc('view-user-admin', $pren);
        #echo 'You are visiting ' . $_SERVER['REQUEST_URI'];
    }

    function editGlobalSettings() {

        $this->renderc('edit-globali', $_SESSION['user']);
    }

}

?>