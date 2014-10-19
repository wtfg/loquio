<?php


class BookoffController extends DooController {

    public function beforeRun($resource, $action) {

        session_start();
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

    function snagMail($email, $nomecognome, $data, $value, $delete){
        $date = date("d-m-y",strtotime($data));
        $subject = stripslashes($nomecognome).': avviso';

        $headers = "From: prenotazioni@loquio.it \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $delete = ($delete) ? "La sua prenotazione e' stata cancellata<br>" : "";

        $message = '
						<html>
					  <body>

							Il docente <b>'.$nomecognome.'</b> ha un imprevisto per il giorno
							<font color=\"#ff0000\">'.$date.'</font> <br>
							Motivazione fornita:<br>'.$value.'<br><p><strong>
							'.$delete.'</strong></p>
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
    function applyBookoff($book, $email=false){

        $pren = Doo::loadModel("prenotazioni", true);
        $pren->did = $book->did;
        $g = $pren;
        $r = $this->db()->find($pren, array("where"=>"data>=".$book->datefrom." AND data<=".strtotime('+1 day', $book->dateto)));
        if($email){
            foreach($r as $pren){
                $docente = Doo::loadModel("docenti", true);
                $docente->did = $book->did;
                $docente = $this->db()->find($docente, array("limit"=>1));
                $this->snagMail($pren->email, $docente->cognome. " ".$docente->nome, date("d-m-Y", $pren->data), "", true);
            }
        }

        $this->db()->delete($g, array("where"=>"data>=".$book->datefrom." AND data<=".strtotime('+1 day', $book->dateto)));
    }
    function snag(){
        if(isset($_POST['date'])){

            $book = Doo::loadModel('bookoff', true);
            $book->did = $this->params['id'];
            $explainText =  stripslashes($_POST['value']);
            $date = explode("-",$_POST['date']);
            $theDate = $date[2]."-".$date[1]."-".$date[0]. " 00:00:00";
            $delete = isset($_POST["delete"]) && $_POST["delete"] == "on" ? true : false;
            $pren = Doo::loadModel("prenotazioni",true);
            $pren->did = $this->params['id'];

            $daya = strtotime($theDate);
            $dayb = strtotime('+1 day', $daya);
            echo $pren->data;
            $prens = $this->db()->find($pren, array("where"=>"data>=".$daya." AND data<=".$dayb));
            $i = 0;
            foreach($prens as $p){
                $i++;
                $this->snagMail($p->email, $_POST["nomecognome"], $theDate, $explainText, $delete);
                if($delete){
                    $this->db()->delete($p);
                }
            }

            $data['messaggio'] = $i." email mandate per avvisare dell'imprevisto";
            if($delete)
                $data['messaggio'] .= "<br>Le prenotazioni sono state cancellate!";
            $data['url'] = Doo::conf()->APP_URL;
            $data['titolo'] = "Ben fatto!";
        // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
            return;
        }else{


            $data = array("docenti"=>array());

            $di = Doo::loadModel("docenti", true);
            $di->did = $this->params["id"];

            $n = $this->db()->find($di, array("limit"=>1));

            if(!$n){
                $this->renderc('error-page');
                return;
            }
            $data["docenti"] = stripslashes($n->nome. " ". $n->cognome);

            $data = $this->getContents("new-snag",$data);
            $this->renderc("base-template", $data);
        }

    }

    function newBookoff(){
        /**
         * New Bookoff
         */
        $snag = isset($this->params["id"]);

        if(isset($_POST['did'])){

            $book = Doo::loadModel('bookoff', true);
            $book->did = $snag ? $this->params['id'] : $_POST['did'];
            $fromto = explode("-",$_POST["fromto"]);

            $book->datefrom = strtotime(trim(str_replace('/', '-', $fromto[0])));
            $book->dateto = strtotime(trim(str_replace('/', '-', $fromto[1])));

            $done = $this->db()->insert($book);

            $this->applyBookoff($book, true);
            if($done){

                $data['messaggio'] = "Bookoff creato! Tutte le prenotazioni in quel range di tempo sono state cancellate e sono stati inviati gli avvisi";
                $data['url'] = Doo::conf()->APP_URL."admin/bookoff";
                $data['titolo'] = "Ben fatto!";

                $this->renderc('ok-page',$data);
                return;
            }

            /**
             * renderizza errore
             */

            $this->renderc("error-page");
        }else{


            $docenti = Doo::loadModel('docenti', true);
            $docenti = $this->db()->find($docenti);

            $data = array("docenti"=>array());
            foreach($docenti as $docente){
                array_push($data["docenti"], array("did" => $docente->did, "nomecognome" => stripslashes($docente->nome." ".$docente->cognome)));
            }

            $pagename = "add-bookoff";
            $data = $this->getContents($pagename,$data);
            $this->renderc("base-template", $data);

        }
    }

    function deleteBookoff() {
        $bookoffid = $this->params['id'];
        $bookoff = Doo::loadModel("bookoff", true);
        $bookoff->bookoffid = $bookoffid;

        $this->db()->delete($bookoff);
        $data['messaggio'] = "Bookoff Eliminato!";
        $data['url'] = Doo::conf()->APP_URL."admin/bookoff";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function viewBookoffs(){
            /**
             * Visualizza Bookoffs
             */

            $book = Doo::loadModel('bookoff', true);
            $bookoffs = $this->db()->find($book, array("asArray"=>true));
            $data = array("bookoffs"=>array());



            foreach($bookoffs as $bookoff){

                $docente = Doo::loadModel('docenti', true);
                $docente->did = $bookoff["did"];
                $docenteResult = $this->db()->find($docente, array("limit"=>1));
                if(!$docenteResult){
                    $this->renderc("error-page");
                    return;
                }

                $nc = stripslashes($docenteResult->nome ." ". $docenteResult->cognome);

                $b = array("nome" => $nc, "bookoffid" => $bookoff["bookoffid"], "from" => date("d-m-Y",$bookoff["datefrom"]), "to" => date("d-m-Y",$bookoff["dateto"]));
                array_push($data["bookoffs"], $b);
            }

            $data = $this->getContents("view-bookoffs", $data);
            $this->renderc("base-template", $data);
    }


    function editBookoff(){
        /**
         * Modifica Bookoffs
         */
        $bookoffid = $this->params['id'];

        if(isset($_POST['did'])){
            $book = Doo::loadModel('bookoff', true);
            $book->bookoffid = $bookoffid;
            $book->did = $_POST['did'];
            $fromto = explode("-",$_POST["fromto"]);

            $book->datefrom = strtotime(trim(str_replace('/', '-', $fromto[0])));
            $book->dateto = strtotime(trim(str_replace('/', '-', $fromto[1])));


            
            $this->db()->update($book);
            $this->applyBookoff($book, true);
            $data['messaggio'] = "Bookoff modificato! Tutte le prenotazioni in quel range di tempo sono state cancellate e sono stati inviati gli avvisi";
            $data['url'] = Doo::conf()->APP_URL."admin/bookoff";
            $data['titolo'] = "Ben fatto!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
            return;

        }else{


            $book = Doo::loadModel('bookoff', true);

            $book->bookoffid = $bookoffid;
            $bookOffResult = $this->db()->find($book, array("limit"=>1));
            if(!$bookOffResult){
                $this->renderc("error-page");
                return;
            }
            $docente = Doo::loadModel('docenti', true);
            $docente->did = $bookOffResult->did;
            $docenteResult = $this->db()->find($docente, array("limit"=>1));
            if(!$docenteResult){
                $this->renderc("error-page");
                return;
            }

            $data['name'] = stripslashes($docenteResult->nome ." ". $docenteResult->cognome);
            $data['did'] = $docenteResult->did;
            $data['fromto'] = date("d/m/Y", $bookOffResult->datefrom). " - ".date("d/m/Y", $bookOffResult->dateto);
            $data = $this->getContents("edit-bookoff", $data);
            $this->renderc("base-template", $data);

        }
    }






}
?>