<?php
Doo::loadModel('base/DocentiBase');

class Docenti extends DocentiBase{

    function getMateria(){
        $m = Doo::loadModel("materie", true);
        $m->mid = $this->mid;
        $m = $this->db()->find($m, array("limit" => 1));
        return $m;

    }

    function setFromPost($post){
        foreach($post as $k => $v){
            $this->{$k} = $v;
        }
    }

    function getFullName(){
        return stripslashes($this->cognome . " " . $this->nome);
    }
}