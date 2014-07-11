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

    function newBookoff(){
        /**
         * New Bookoff
         */
        if(isset($_POST['button'])){
            $book = Doo::loadModel('bookoff', true);
            $book->did = $_POST['did'];
            $book->value = stripslashes($_POST['value']);
            $date = explode("-",$_POST['date']);
            $book->date = $date[2]."-".$date[1]."-".$date[0]. " 00:00:00";
            $done = $this->db()->insert($book);
            if($done){
                $data['messaggio'] = "Bookoff creato!";
                $data['url'] = Doo::conf()->APP_URL."admin/bookoff";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
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
                array_push($data["docenti"], array("did" => $docente->did, "nomecognome" => $docente->nome." ".$docente->cognome));
            }
            $data = $this->getContents("new-bookoff",$data);
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
            $bookoffs = $this->db()->find($book, array('where' => 'date>' . time(), "asArray"=>true));
            $data = array();



            foreach($bookoffs as $bookoff){

                $docente = Doo::loadModel('docenti', true);
                $docente->did = $bookoff["did"];
                $docenteResult = $this->db()->find($docente, array("limit"=>1));
                if(!$docenteResult)

                    $this->renderc("error-page");

                $nc = $docenteResult->nome ." ". $docenteResult->cognome;

                $b = array("nome" => $nc, "bookoffid" => $bookoff["bookoffid"], "value" => $bookoff["value"], "date" => $bookoff["date"]);
                array_push($data, $b);
            }

            $data = $this->getContents("view-bookoffs", $data);
            $this->renderc("base-template", $data);
    }


    function editBookoff(){
        /**
         * Modifica Bookoffs
         */
        $bookoffid = $this->params['id'];

        if(isset($_POST['button'])){
            $book = Doo::loadModel('bookoff', true);
            $book->bookoffid = $bookoffid;
            $book->did = $_POST['did'];
            $book->value = stripslashes($_POST['value']);
            $book->date = $_POST['date'];

            if($this->db()->update($book)){
                $data['messaggio'] = "Bookoff modificato!";
                $data['url'] = Doo::conf()->APP_URL."admin/bookoff";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
                return;
            }

            /**
             * renderizza errore
             */

            $this->renderc("error-page");
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

            $data['name'] = $docenteResult->nome ." ". $docenteResult->cognome;
            $data['did'] = $docenteResult->did;
            $data['value'] = $bookOffResult->value;
            $data['date'] = $bookOffResult->date;
            $data = $this->getContents("edit-bookoff", $data);
            $this->renderc("base-template", $data);

        }
    }






}
?>