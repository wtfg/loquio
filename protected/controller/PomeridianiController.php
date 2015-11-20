<?php


class PomeridianiController extends DooController {

    public function beforeRun($resource, $action) {
        $a =  ConfigLoader::getInstance();
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

            $docente = Doo::loadModel("docenti", true);
            $docente->did = $pom->did;
            $docente = $this->db()->find($docente,array("limit"=>1));
            $limit = $docente->maxpomeridiani;

            $pomcount = Doo::loadModel("pomeridiani", true);
            $pomcount->did = $pom->did;
            $pomcount = $pomcount->count();

            if($pomcount >= $limit ){
                $this->renderc("error-page",array("message"=>"Prenotazione non riuscita. Il docente ha raggiunto il limite massimo di ".$limit." prenotazioni"));
                return;
            }

            $done = $this->db()->insert($pom);

            if($done){

                $data['messaggio'] = "Il tuo colloquio e' stato registrato! Grazie della prenotazione";
                $data['url'] = Doo::conf()->APP_URL."pomeridiani/";
                $data['titolo'] = "Ben fatto!";

                $this->renderc('ok-page',$data);
                return;
            }

            /**
             * renderizza errore
             */

            $this->renderc("error-page", array("message"=>"Errore nella creazione della prenotazione. Codice Errore 01."));

        }else{

            $docenti = Doo::loadModel('docenti', true);
            $docenti->attivo = 1;
            $docenti = $this->db()->find($docenti);

            $data = array("docenti"=>array());

            foreach($docenti as $docente){
                /*$disabled = false;
                $limit = $docente->maxpomeridiani;

                $pomcount = Doo::loadModel("pomeridiani", true);
                $pomcount->did = $docente->did;
                $pomcount = $pomcount->count();

                if($pomcount >= $limit ){
                    $disabled = true;
                }*/

                array_push($data["docenti"], array(/*"disabled" => $disabled, "maxpomeridiani" => $docente->maxpomeridiani,*/
                    "did" => $docente->did, "nomecognome" => stripslashes($docente->nome." ".$docente->cognome)));
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
                    $this->renderc("error-page", array("message"=>"Docente non trovato. Codice Errore 02"));
                    return;
                }
                $materia = Doo::loadModel('materie', true);
                $materia->mid = $docenteResult->mid;
                $materiaResult = $this->db()->find($materia, array("limit"=>1));

                if(!$materiaResult){
                    continue;
                }
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
                $this->renderc("error-page", array("message"=>"Docente non trovato. Codice Errore 03"));
                return;
            }
            $materia = Doo::loadModel('materie', true);
            $materia->mid = $docenteResult->mid;
            $materiaResult = $this->db()->find($materia, array("limit"=>1));

            $utente = Doo::loadModel('utenti', true);
            $utente->uid = $pomeridiano["uid"];
            $utenteResult = $this->db()->find($utente, array("limit"=>1));
            if(!$utenteResult or !$materiaResult){
                continue;
            }
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
                $this->renderc("error-page", array("message"=>"Colloquio pomeridiano non trovato. Codice Errore 04"));
                return;
            }
            $docente = Doo::loadModel('docenti', true);
            $docente->did = $pomResult->did;
            $docenteResult = $this->db()->find($docente, array("limit"=>1));
            if(!$docenteResult){
                $this->renderc("error-page", array("message"=>"Docente non trovato. Codice Errore 05"));
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

    function randomClass(){
        $letters = "ABCDEFGHIL";
        $nums = "12345";
        $letters = str_shuffle($letters);
        $nums = str_shuffle($nums);
        return $nums[0].$letters[0];
    }

    function randomPopulate(){
        $a = array();
        for($i=0;$i<1000;$i++){
            $p = Doo::loadModel("pomeridiani", true);
            $p->pomid = $i;
            $p->classe = $this->randomClass();
            $p->did = rand(0,10);
            $p->uid = 0;
            $p->nome = "@";
            $p->cognome = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
            array_push($a, $p);
        }
        return $a;
    }

    function filter(){
        /**
         * maschera

        + seleziona numero giorni = N
        + quali sono i giorni? N campi di selezione giorno
        + criteri (3)
        + N insiemi a cui assegnare docenti
        + ricorreggi esporta
         */

        if(!isset($_POST['days'])){
            $do = $this->db()->find(Doo::loadModel("docenti", true));
            $data = array("teachers">array());
            foreach($do as $docente){
                $data["teachers"][$docente->did] = $docente->cognome." ".$docente->nome;
            }
            $data["teachers_json"] = json_encode($data["teachers"]);
            $data = $this->getContents("pom-filter",$data);
            $this->renderc("base-template", $data);

        }else{

            $poms = Doo::loadModel("pomeridiani", true);
            $datas = $this->db()->find($poms);
            #$datas = $this->randomPopulate();
            #var_dump($datas);
            #echo "<hr>";
            $criterion = $_POST["criterion"];
            $days = $_POST["days"];
            $sets = $_POST["set"];

            $criterion_type = $_POST["criterion-type"];
            $a = new pFilter();

            $a->setData($datas);
            $a->setDays($days, $sets);
            $a->setType($criterion,$criterion_type);

            $a->divide();
            $a->getData();
            $a->toCsv();
            $a->toPDF();
            $a->downloadZip();
        }
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