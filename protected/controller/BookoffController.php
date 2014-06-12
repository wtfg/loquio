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

    function viewBookoffs(){
            /**
             * Visualizza Bookoffs
             */

            $book = Doo::loadModel('bookoff', true);
            $bookoffs = $this->db()->find($book, array('where' => 'date>' . time()));

            foreach($bookoffs as $bookoff){
                echo $bookoff->value;
            }
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
                /**
                 * renderizza ok
                 */
            }

            /**
             * renderizza errore
             */
        }else{


            $book = Doo::loadModel('bookoff', true);

            $book->bookoffid = $bookoffid;
            $bookOffResult = $this->db()->find($book, array("limit"=>1));

            $docente = Doo::loadModel('docenti', true);
            $docente->did = $bookOffResult->did;
            $docenteResult = $this->db()->find($docente, array("limit"=>1));

            $data['name'] = $docenteResult->nome ." ". $docenteResult->cognome;
            $data['did'] = $docenteResult->did;
            $data['value'] = $bookOffResult->value;
            $data['date'] = $bookOffResult->date;
            var_dump($data);
            $data = $this->getContents("edit-bookoff", $data);
            $this->renderc("base-template", $data);

        }
    }


    function deleteBookoff(){
        if(isset($_POST['bookoffid'])){
            $book = Doo::loadModel('bookoff', true);
            $book->bookoffid = $_POST['bookoffid'];
            if($this->db()->delete($book)){
                /**
                 * renderizza ok
                 */
            }
        }
    }



    function insertBookoff(){
        /**
         * Aggiungi Bookoffs
         */
        if(isset($_POST)){
            $book = Doo::loadModel('bookoff', true);
            $book->did = $_POST['did'];
            $book->value = $_POST['value'];
            $book->date = $_POST['date'];

            if($this->db()->insert($book)){
                /**
                 * Renderizza ok
                 */
            }

            /**
             * Renderizza fail
             */
        }else{
            /**
             * Renderizza
             */
        }

    }
}
?>