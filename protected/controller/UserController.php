<?php
/**
 * Created by PhpStorm.
 * User: Mauro
 * Date: 29/07/14
 * Time: 9.36
 */

class UserController extends DooController {
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

    function createUser(){
        if(isset($_POST["button"])){
            $user = Doo::loadModel("utenti", true);
            $user->nome = $_POST["nome"];
            $user->cognome = $_POST["cognome"];
            $user->email = $_POST["email"];
            $user->telefono = $_POST["telefono"];
            $user->pass = md5($_POST["pass"]);
    #       $user->altramail = $_POST["altramail"];
            $user->acl = $_POST["aclr"];



            if($this->db()->insert($user)){
                $data['messaggio'] = "Utente creato!";
                if($user->acl == 1){
                    $docente = Doo::loadModel("docenti", true);
                    $docente->nome = $user->nome;
                    $docente->cognome = $user->cognome;
                    $docente->email = $user->email;
                    $docente->tel = $user->telefono;
                    $docente->orelibere = "{}";
                    $docente->attivo = 0;
                    $this->db()->insert($docente);
                    $data['messaggio'] .= "<br>Anche il docente e' stato creato, ricordati di configurarlo!";
                }

                $data['url'] = Doo::conf()->APP_URL."admin/utenti/";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
                return;
            }
            $this->renderc('error-page', array("message"=>"Errore nell'inserimento dell'account utente. UserController / createUser"));

        }else{
            $data = array();
            $data = $this->getContents("add-user", $data);
            $this->renderc("base-template", $data);
            return;
        }
    }

    function showUsers(){
        $user = Doo::loadModel("utenti", true);
        $users = $this->db()->find($user);
        $data = array("utenti"=>array());
        foreach($users as $u){
            array_push($data["utenti"], array("uid"=>$u->uid, "email"=>$u->email, "telefono"=>$u->telefono, "acl"=>$u->acl, "nome"=>stripslashes($u->nome), "cognome"=>stripslashes($u->cognome)));
        }
        $data = $this->getContents("view-users", $data);
        $this->renderc("base-template", $data);
        return;
    }

    function updateUser(){
        if(isset($_POST["button"])){
            $user = Doo::loadModel("utenti", true);
            $user->uid =  $_POST["uid"];
            $olduser = $this->db()->find($user, array("limit"=>1));
            $oldacl = $olduser->acl;
            $oldmail = $olduser->email;
            $user->nome = $_POST["nome"];
            $user->cognome = $_POST["cognome"];
            $user->email = $_POST["email"];
            $user->telefono = $_POST["telefono"];
            if($_POST["pass"] != null)
                $user->pass =md5($_POST["pass"]);
    #       $user->altramail = $_POST["altramail"];
            $user->acl = $_POST["aclr"];

            $this->db()->update($user);
            $data['messaggio'] = "Utente modificato!";
            if($user->acl == 1){
                $docente = Doo::loadModel("docenti", true);

                $docente->email = $oldmail;
                $result = $this->db()->find($docente, array("limit"=>1));

                if($oldacl == 1){
                    if($result){
                        $docente->did = $result->did;
                        $docente->nome = $_POST["nome"];
                        $docente->cognome = $_POST["cognome"];
                        $docente->email = $_POST["email"];
                        $docente->tel = $_POST["telefono"];
                        $this->db()->update($docente);
                        $data['messaggio'] .= "<br>Anche il docente e' stato modificato, ricordati di configurarlo!";
                    }
                }else{

                    if(!$result){
                        $this->db()->insert($docente);
                        $data['messaggio'] .= "<br>Il docente e' stato inserito, ricordati di configurarlo!";
                    }else{
                        $docente->did = $result->did;
                        $this->db()->update($docente);
                        $data['messaggio'] .= "<br>Anche il docente e' stato modificato, ricordati di configurarlo!";
                    }
                }

            }
            $data['url'] = Doo::conf()->APP_URL."admin/utenti/";
            $data['titolo'] = "Ben fatto!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
            return;

        }else{
            $user = Doo::loadModel("utenti", true);

            $user->uid = $this->params["id"];


            $user = $this->db()->find($user, array("limit"=>1));
            $data = array("utente"=>$user);
            $data["admin"] = true;

            $data = $this->getContents("edit-user", $data);
            $this->renderc("base-template", $data);
            return;
        }
    }

    function panelUser(){
        if(isset($_POST["button"])){

            $olduser = Doo::loadModel("utenti", true);
            $olduser->uid = $_POST['uid'];
            $olduser = $this->db()->find($olduser, array("limit"=>1));

            $user = Doo::loadModel("utenti", true);
            $user->uid =  $_POST["uid"];
            $user->nome = $_POST["nome"];
            $user->cognome = $_POST["cognome"];
            $user->email = $_POST["email"];
            $user->telefono = $_POST["telefono"];
            if($_POST["pass"] != null)
                $user->pass =md5($_POST["pass"]);


            $this->db()->update($user);
            $data['messaggio'] = "Utente modificato!";
            if($olduser->acl == 1){
                $docente = Doo::loadModel("docenti", true);


                $docente->email = $olduser->email;

                $docente = $this->db()->find($docente, array("limit"=>1));
                $docente->nome = $user->nome;
                $docente->cognome = $user->cognome;
                $docente->email = $user->email;
                $docente->tel = $user->telefono;


                $this->db()->update($docente);
                $data['messaggio'] .= "<br>Anche i tuoi dati docente sono stati modificati!";
            }
            $data['url'] = Doo::conf()->APP_URL;
            $data['titolo'] = "Ben fatto!";

            // MESSAGGIO DOCENTE MODIFICATO
            $this->renderc('ok-page',$data);
            return;

        }else{
            $user = Doo::loadModel("utenti", true);

            $user->uid = $_SESSION["user"]["id"];

            $user = $this->db()->find($user, array("limit"=>1));
            $data = array("utente"=>$user);

            $data["admin"] = false;

            $data = $this->getContents("edit-user", $data);
            $this->renderc("base-template", $data);
            return;
        }
    }

    function deleteUser(){
        $user = Doo::loadModel("utenti", true);
        $user->uid = $this->params["id"];
        $u = $this->db()->find($user, array("limit"=>1));
        $docente = Doo::loadModel("docenti", true);
        $docente->email = $u->email;
        $this->db()->delete($docente);
        $this->db()->delete($user);

        $data['messaggio'] = "Utente cancellato!";
        $data['url'] = Doo::conf()->APP_URL."admin/utenti/";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
        return;



    }
}

?>