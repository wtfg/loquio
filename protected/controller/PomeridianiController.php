<?php


class PomeridianiController extends DooController {

    public function beforeRun($resource, $action) {
        $a = new ConfigLoader(Doo::conf()->SITE_PATH . "global/config");
        if($a->getParam("pomeridianiActive") != "true"){
            return Doo::conf()->APP_URL;
        }

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

    function newPomeridiani(){
        /**
         * New P
         */

        if(isset($_POST['did'])){

            $pom = Doo::loadModel('pomeridiani', true);

            $pom->cognome = $_POST['cognome'];
            $pom->nome = $_POST['nome'];
            $pom->classe = $_POST['classe'];
            $pom->did = $_POST['did'];
            $pom->uid = $_SESSION['user']['id'];

            $done = $this->db()->insert($pom);

            if($done){

                $data['messaggio'] = "Colloquio inserito!";
                $data['url'] = Doo::conf()->APP_URL."pomeridiani/";
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
            $docenti->attivo = 1;
            $docenti = $this->db()->find($docenti);

            $data = array("docenti"=>array());

            foreach($docenti as $docente){
                array_push($data["docenti"], array("did" => $docente->did, "nomecognome" => stripslashes($docente->nome." ".$docente->cognome)));
            }

            $pagename = "add-pomeridiani";
            $data = $this->getContents($pagename,$data);
            $this->renderc("base-template", $data);

        }
    }

    function deletePomeridiani() {
        $pomid = $this->params['id'];
        $pomeridiani = Doo::loadModel("pomeridiani", true);
        $pomeridiani->pomid = $pomid;

        $this->db()->delete($pomeridiani);
        $data['messaggio'] = "Pomeridiano Eliminato!";
        $data['url'] = Doo::conf()->APP_URL."pomeridiani/";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }

    function viewPomeridiani(){
            /**
             * Visualizza Bookoffs
             */

            $pom = Doo::loadModel('pomeridiani', true);
            $pom->uid = $_SESSION['user']['id'];
            $pomeridiani = $this->db()->find($pom, array("asArray"=>true));
            $data = array("pomeridiani"=>array());

            foreach($pomeridiani as $pomeridiano){

                $docente = Doo::loadModel('docenti', true);
                $docente->did = $pomeridiano["did"];
                $docenteResult = $this->db()->find($docente, array("limit"=>1));
                if(!$docenteResult){
                    $this->renderc("error-page");
                    return;
                }
                $materia = Doo::loadModel('materie', true);
                $materia->mid = $docenteResult->mid;
                $materiaResult = $this->db()->find($materia, array("limit"=>1));


                $nc = stripslashes($docenteResult->nome ." ". $docenteResult->cognome);

                $b = array("docente" => $nc, "nomemateria"=>$materiaResult->nome, "pomid" => $pomeridiano["pomid"], "nome" => $pomeridiano["nome"], "cognome"=>$pomeridiano["cognome"], "classe"=>$pomeridiano["classe"]);
                array_push($data["pomeridiani"], $b);
            }

            $data = $this->getContents("view-pomeridiani", $data);
            $this->renderc("base-template", $data);
    }

    function viewPomeridianiAdmin(){
        /**
         * Visualizza Bookoffs
         */
        $pom = Doo::loadModel('pomeridiani', true);
        $pomeridiani = $this->db()->find($pom, array("asArray"=>true));
        $data = array("pomeridiani"=>array());

        foreach($pomeridiani as $pomeridiano){

            $docente = Doo::loadModel('docenti', true);
            $docente->did = $pomeridiano["did"];

            $docenteResult = $this->db()->find($docente, array("limit"=>1));
            if(!$docenteResult){
                $this->renderc("error-page");
                return;
            }
            $materia = Doo::loadModel('materie', true);
            $materia->mid = $docenteResult->mid;
            $materiaResult = $this->db()->find($materia, array("limit"=>1));

            $utente = Doo::loadModel('utenti', true);
            $utente->uid = $pomeridiano["uid"];
            $utenteResult = $this->db()->find($utente, array("limit"=>1));

            $nc = stripslashes($docenteResult->nome ." ". $docenteResult->cognome);

            $b = array("docente" => $nc, "nomemateria"=>$materiaResult->nome, "uid"=>$utenteResult->uid, "email"=>$utenteResult->email, "pomid" => $pomeridiano["pomid"], "nome" => $pomeridiano["nome"], "cognome"=>$pomeridiano["cognome"], "classe"=>$pomeridiano["classe"]);
            array_push($data["pomeridiani"], $b);
        }

        $data = $this->getContents("view-pomeridiani-admin", $data);
        $this->renderc("base-template", $data);
    }

    function editPomeridiani(){
        /**
         * Modifica Bookoffs
         */
        $pomid = $this->params['id'];

        if(isset($_POST['did'])){
            $pomeridiani = Doo::loadModel('pomeridiani', true);
            $pomeridiani->pomid = $pomid;
            $pomeridiani->cognome = $_POST['cognome'];
            $pomeridiani->nome = $_POST['nome'];
            $pomeridiani->classe = $_POST['classe'];
            $pomeridiani->did = $_POST['did'];

            $this->db()->update($pomeridiani);

            $data['messaggio'] = "Colloquio modificato!";
            $data['url'] = Doo::conf()->APP_URL."pomeridiani/";
            $data['titolo'] = "Ben fatto!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
            return;

        }else{

            $pomeridiani = Doo::loadModel('pomeridiani', true);

            $pomeridiani->pomid = $pomid;
            $pomResult = $this->db()->find($pomeridiani, array("limit"=>1));
            if(!$pomResult){
                $this->renderc("error-page");
                return;
            }
            $docente = Doo::loadModel('docenti', true);
            $docente->did = $pomResult->did;
            $docenteResult = $this->db()->find($docente, array("limit"=>1));
            if(!$docenteResult){
                $this->renderc("error-page");
                return;
            }

            $data['docente'] = stripslashes($docenteResult->nome ." ". $docenteResult->cognome);
            $data['did'] = $docenteResult->did;
            $data['nome'] = $pomResult->nome;
            $data['cognome'] = $pomResult->cognome;
            $data['classe'] = $pomResult->classe;
            $data = $this->getContents("edit-pomeridiani", $data);
            $this->renderc("base-template", $data);

        }
    }

    function filter(){
    }

    function deleteAll(){
        $pomeridiani = Doo::loadModel("pomeridiani", true);
        $this->db()->deleteAll($pomeridiani);
        $data['messaggio'] = "Tutti i pomeridiani eliminati!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
    }


}
?>