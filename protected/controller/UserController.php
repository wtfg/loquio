<?php
/**
 * Created by PhpStorm.
 * User: Mauro
 * Date: 29/07/14
 * Time: 9.36
 */

class UserController extends DooContrller {
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

    }

    function showUsers(){
        $user = Doo::loadModel("utenti", true);
        $users = $this->db()->find($user);
        $data = array("utenti"=>array());
        foreach($users as $u){

            array_push($data["utenti"], array("email"=>$u->email, "acl"=>$u->acl, "telefono"=>$u->telefono, "altramail"=>$u->altramail, "username"=>$u->nome." ".$u->cognome));
        }
        getContents("", $data);
    }

    function updateUsers(){

    }

    function deleteUsers(){

    }
}

?>