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
            $user->altramail = $_POST["altramail"];
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

                $data['url'] = Doo::conf()->APP_URL."admin";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
                return;
            }
            $this->renderc('error-page');

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
            array_push($data["utenti"], array("uid"=>$u->uid, "email"=>$u->email, "telefono"=>$u->telefono, "acl"=>$u->acl, "nome"=>$u->nome, "cognome"=>$u->cognome));
        }
        $data = $this->getContents("view-users", $data);
        $this->renderc("base-template", $data);
        return;
    }

    function updateUser(){


        if(isset($_POST["button"])){
            $user = Doo::loadModel("utenti", true);
            $user->uid =  $_POST["uid"];
            $user->nome = $_POST["nome"];
            $user->cognome = $_POST["cognome"];
            $user->email = $_POST["email"];
            $user->telefono = $_POST["telefono"];
            $user->pass =md5($_POST["pass"]);
            $user->altramail = $_POST["altramail"];
            $user->acl = $_POST["aclr"];

            if($this->db()->update($user)){
                $data['messaggio'] = "Utente modificato!";
                if($user->acl == 1){
                    $docente = Doo::loadModel("docenti", true);
                    $docente->nome = $user->nome;
                    $docente->cognome = $user->cognome;
                    $docente->email = $user->email;
                    $docente->tel = $user->telefono;
                    $this->db()->update($docente);
                    $data['messaggio'] .= "<br>Anche il docente e' stato modificato, ricordati di configurarlo!";
                }
                $data['url'] = Doo::conf()->APP_URL."admin";
                $data['titolo'] = "Ben fatto!";

                // MESSAGGIO DOCENTE MODIFICATO
                $this->renderc('ok-page',$data);
                return;
            }
            $this->renderc('error-page');

        }else{
            $user = Doo::loadModel("utenti", true);
            $user->uid = $this->params["id"];
            $user = $this->db()->find($user, array("limit"=>1));
            $data = array("utente"=>$user);
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
        $data['url'] = Doo::conf()->APP_URL."admin";
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
        return;



    }
}

?>