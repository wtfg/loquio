<?php

class PrenotController extends DooController
{

    public function beforeRun($resource, $action)
    {
        session_start();
        //if not login, group = anonymous
        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';
        //check against the ACL rules
        if ($rs = $this->acl()->process($role, $resource, $action)) {
            return $rs;
        }
    }

    /**
     * Da le basi per il template
     * @param $viewName string nome view
     * @param $data array associativo
     * @return mixed data
     */
    function getContents($viewName, $data){
        $data = $data;
        include(Doo::conf()->SITE_PATH . "protected/viewc/" . $viewName . ".php");
        return $data;
    }

    /** Invia messaggio di prenotazione avvenuta
     * @param $to
     * @param $docente
     * @param $theTime
     * @param $theDate
     */
    function sendEmailSuccessfulBooking($to, $docente, $theTime, $theDate, $studentname){
        $from = "prenotazioni@loquio.it";
        $subject = "Prenotazione Colloquio";

        //begin of HTML message
        $message = "<html>
                          <body>

                                La tua prenotazione per il docente <b><font color=\"red\">" . $docente->nome . " " . $docente->cognome . "</font></b> &egrave; stata confermata! <br>
                                La data della prenotazione &egrave; il  <font color=\"red\">" . $theDate . "</font> dalle ore  <font color=\"red\">" . $theTime . "</font> <br>
                                Per vedere l'ordine di prenotazione accedi alle liste giornaliere sul tuo account Loquio.

                              <br><br>Grazie Per L'Attenzione!<br><em>Il Team Di Loquio</em>
                          </body>
                        </html>";
        //end of message


        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $from\r\n";

        // now lets send the email.
        mail($to, $subject, $message, $headers);

        $from = "prenotazioni@loquio.it";
        $subject = "Prenotazione Colloquio da ".$studentname;

        //begin of HTML message
        $message = "<html>
                          <body>

                                Hai ricevuto una prenotazione da <font color=\"red\"><b>" . $studentname. "</b></font><br>
                                La data della prenotazione &egrave; il  <font color=\"red\">" . $theDate . "</font> dalle ore  <font color=\"red\">" . $theTime . "</font> <br>
                                Per vedere l'ordine di prenotazione accedi alle liste giornaliere sul tuo account Loquio.

                              <br><br>Grazie Per L'Attenzione!<br><em>Il Team Di Loquio</em>
                          </body>
                        </html>";
        //end of message


        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $from\r\n";

        // now lets send the email.
        mail($docente->email, $subject, $message, $headers);
    }

    /**
     * @param $d        object docente
     * @param $p        object prenotazione
     * @param $fromwho  string nome prenotato
     */
    function sendEmailCanceledBooking($d, $p, $fromwho){
        $to = $d->email;
        $from = "prenotazioni@loquio.it";
        $subject = "Colloquio Annullato";
        $thetime = date("h", $p->data) . ":00";
        $thedate = date("d/m/Y", $p->data);
        //begin of HTML message
        $message = "<html>
	  <body>

			La tua prenotazione da parte di <b><font color=\"red\">" . $fromwho . "</font></b> &egrave; stata annullata! <br>
			La data della prenotazione era il <font color=\"red\">" . $thedate . "</font> dalle ore  <font color=\"red\">" . $thetime . "</font> <br>

		  <br><br>Grazie Per L'Attenzione!<br><em>Il Team Di Loquio</em>
	  </body>
	</html>";
        //end of message

        // To send the HTML mail we need to set the Content-type header.
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $from\r\n";
        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        mail($to, $subject, $message, $headers);
    }
    /**
     * Ottiene la prenotazione dall'id utente
     * @param $id
     *          id utente
     * @param null $parameters
     *          array associativo coi parametri
     * @return mixed
     *          ritorna oggetto
     */
    function getBook($id, $parameters = null)
    {
        $bookModel = Doo::loadModel("prenotazioni", true);
        $bookModel->uid = $id;
        if ($parameters == null) {
            return $this->db()->find($bookModel);
        } else {
            return $this->db()->find($bookModel, $parameters);
        }
    }

    /**
     * Ottiene il docente dall'id
     * @param $id
     *          id docente
     * @param null $parameters
     *          array associativo coi parametri
     * @return mixed
     *          ritorna oggetto
     */
    function getTeacher($id, $parameters = null)
    {
        $teacherModel = Doo::loadModel("docenti", true);
        $teacherModel->did = $id;
        if ($parameters == null) {
            return $this->db()->find($teacherModel);
        } else {
            return $this->db()->find($teacherModel, $parameters);
        }
    }

    /**
     * Ottiene la materia dall'id
     * @param $id
     *          id materia
     * @param null $parameters
     *          array associativo coi parametri
     * @return mixed
     *          ritorna oggetto
     */
    function getSubject($id, $parameters = null)
    {
        $subjectModel = Doo::loadModel("materie", true);
        $subjectModel->mid = $id;
        if ($parameters == null) {
            return $this->db()->find($subjectModel);
        } else {
            return $this->db()->find($subjectModel, $parameters);
        }
    }

    /**
     * Carica tutta la tabella docenti
     * @return mixed oggetto docenti
     */
    function getTeachers($a=null){
        if($a == null)
            $teachers = $this->db()->find(Doo::loadModel("docenti", true));
        else
            $teachers = $this->db()->find(Doo::loadModel("docenti", true), $a);
        return $teachers;
    }

    /**
     * CONTROLLERS
     */

    function showPrenUser()
    {
        $uid = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "";
        $bookModel = $this->getBook($uid, array("where" => "data>" . time()));

        $data = array("prenotazioni"=>array());

        foreach ($bookModel as $book) {
            $teacherModel = $this->getTeacher($book->did, array("limit" => 1));
            $subjectModel = $this->getSubject($teacherModel->mid, array("limit" => 1));

            $resultDict = array("nome_docente" => stripslashes($teacherModel->nome . " " . $teacherModel->cognome),
                                "data" => date("d-m-Y H:i", $book->data),
                                "materia" => $subjectModel->nome,
                                "studente" => stripslashes($book->studente),
                                 "classe" => $book->classe,
                                "codice_canc" => $book->codicecanc
            );

            array_push($data["prenotazioni"], $resultDict);
        }

        $data = $this->getContents("view-prenotazioni-user", $data);
        $this->renderc("base-template", $data);
    }

    function showPrenDocente()
    {
        if (!isset($_POST['invia'])) {
            $data = array("teachers" => $this->getTeachers(array("where"=>"attivo=1")),"message" => "");
            $data =  $this->getContents("view-listapren", $data);
            $this->renderc("base-template", $data);
        } else {

            $theDate = trim($_POST['data']);
            $dt = explode("-", $theDate);

            if(strtotime($theDate) == false){
                $data = array("teachers" => $this->getTeachers(),"message" => "Inserisci una data nel formato gg-mm-aaaa");
                $data =  $this->getContents("view-listapren", $data);
                $this->renderc("base-template", $data);
                return;
            }

            // swappa date
            $theDate = $dt[1] . "/" . $dt[0] . "/" . $dt[2];

            // docente
            $teacher = trim($_POST['docente']);
            $booking = Doo::loadModel("prenotazioni", true);
            $booking->did = $teacher;
            $teacher = $this->getTeacher($teacher, array("limit" => 1));
            $teacherFullName =  $teacher->cognome. " ".$teacher->nome;

            // passate all'array
            $nextDay = strtotime($theDate) + 86400;
            $teachers = $this->db()->find($booking, array("where" => "data>=" . strtotime($theDate) . " AND data<" . $nextDay, "asc"=>"pid"));

            $data = array('data' => $theDate,
                          'docente' => $teacherFullName,
                          'prens' => $teachers
            );

            $data =  $this->getContents("view-listapren2", $data);
            $this->renderc("base-template", $data);
        }
    }

    function prenAjax()
    {
        $emptyObject = "{\"\":\"\"}";
        $conf = new ConfigLoader(Doo::conf()->SITE_PATH . "global/config");
        $LOOK_AHEAD_DAYS = $conf->getParam("lookAheadTime");
        #$_POST['message']['did'] = 4;


        if (isset($_POST['message'])) {

            // teacher data queries
            $teacherId = $_POST['message']['did'];
            $teacher = $this->getTeacher($teacherId, array("limit" => 1));

            // in case of errors
            if ($teacher){
                $freeHours = json_decode($teacher->orelibere, true); //json_decode($d->orelibere, true);
            }else{
                echo $emptyObject;
                return;
            }

            // load bookings for teacher
            $bookings = Doo::loadModel("prenotazioni", true);
            $bookings->did = $teacherId;
            $bookings = $this->db()->find($bookings);

            $prenCalendar = array();


            $theCalendar = new myCalendar(Doo::conf()->SITE_PATH . "global/json/");
            $theCalendar->setTeacher($freeHours);

            foreach ($bookings as $f) {
                array_push($prenCalendar, date("m/d/Y H:i", $f->data));
            }

            $bookoffs = Doo::loadModel("bookoff", true);
            $bookoffs->did = $teacherId;
            $bookoffs = $this->db()->find($bookoffs, array("where"=>"datefrom >= '".time()."'"));


            $theCalendar->addBookings($prenCalendar);
            $freeDays = $theCalendar->getFreeDaysJSON($LOOK_AHEAD_DAYS);
            $freeDaysObject = json_decode($freeDays,true);


            foreach($bookoffs as $bookoff){

                $fromStamp = $bookoff->datefrom;
                $toStamp = strtotime("+1 day", $bookoff->dateto);

                foreach($freeDaysObject as $freeElm){

                    if(is_array($freeElm) && array_key_exists("start", $freeElm)){
                        $prenTime = strtotime($freeElm["start"]);
                        #echo $fromStamp."&lt;".$prenTime."&lt;".$toStamp."<BR>";
                        if($prenTime<=$toStamp && $prenTime>= $fromStamp){
                            #var_dump($freeDays);
                            $object = ',{"title":"Libero","start":"'.$freeElm["start"].'","allDay":""}';
                            $freeDays = str_replace($object, "", $freeDays);
                            #echo "<br><br>".$freeDays;
                            continue;
                        }
                    }
                }



            }
            if ($freeDays != NULL) {
                echo $freeDays;
            } else {
                echo $emptyObject;
            }
        }
    }

    function newPren()
    {
        if (!isset($_POST['button'])) {

            $subjectTeacherDict = array();
            $subjectArray = array();

            $subjects = $this->db()->find("materie");

            foreach ($subjects as $subj) {

                $subjectArray[$subj->mid] = $subj->nome;

                $d = Doo::loadModel("docenti", true);
                $d->mid = $subj->mid;
                $d = $this->db()->find($d, array("where" => "attivo=1"));

                $teacherFullNamesDict = array();

                foreach ($d as $teacher) {
                    $teacherFullNamesDict[$teacher->did] = $teacher->cognome. " ". $teacher->nome;
                }

                $subjectTeacherDict[$subj->mid] = $teacherFullNamesDict;
            }

            $data = array('uid' => isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "",
                          'mdocenti' => $subjectTeacherDict,
                          'materie' => $subjectArray
            );
            $data = $this->getContents("add-prenotazioni", $data);
            $this->renderc("base-template", $data);


        } else {
            if (isset($_POST['did']) &&
                isset($_POST['uid']) &&
                isset($_POST['selected'])
            ) {

                $_POST['selected'] = trim($_POST['selected']);
                $_POST['did'] = trim($_POST['did']);
                $_POST['classe'] = trim($_POST['classe']);
                $_POST['uid'] = trim($_POST['uid']);
                $_POST['studente'] = trim($_POST['studente']);
                #$_POST['email'] = trim($_POST['email']);
                #$_POST['tel'] = trim($_POST['tel']);

                $teacher = $this->getTeacher($_POST['did'], array('limit' => 1));
                $u = Doo::loadModel("utenti", true);
                $u->email = $_SESSION["user"]['username'];
                $u = $this->db()->find($u,array("limit"=>1));

                $booking = Doo::loadModel("prenotazioni", true);
                $booking->data = strtotime($_POST['selected']);
                $booking->did = $_POST['did'];
                $booking->uid = $_POST['uid'];
                $booking->classe = $_POST['classe'];
                $booking->studente = $_POST['studente'];
                $booking->email = $u->email;
                $booking->tel = $u->telefono;
                $booking->codicecanc = md5(time());

                $isExisting = $this->db()->find($booking, array('limit' => 1));

                if (!$isExisting) {
                    $insertSuccessful = $this->db()->insert($booking);
                    if ($insertSuccessful) {
                        $to = $booking->email;
                        $theDate = explode(" ", $_POST['selected']);
                        $theTime = $theDate[1];
                        $theDate = $theDate[0];
                        $this->sendEmailSuccessfulBooking($to, $teacher, $theTime, $theDate, $booking->studente);

                        $data = array('messaggio' => "Prenotazione inserita! Riceverai una email fra poco contenente i dati della prenotazione",
                                      'url' => Doo::conf()->APP_URL . "prenotazioni/",
                                      'titolo' => "Prenotato!"
                        );

                        $this->renderc('ok-page', $data);
                        return;
                    }
                }
            }
            $this->renderc("error-page");
            return;
        }
    }

    function delPren()
    {
        $deleteCode = $this->params['md5'];
        $uid = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "";

        if ($uid == "") {
            $this->renderc("error-page");
            return;
        }

        $userModel = Doo::loadModel("utenti", true);
        $userModel->uid = $uid;
        $userModel = $this->db()->find($userModel, array('limit' => 1));
        $fromWho = $userModel->nome . " " . $userModel->cognome;

        $booking = Doo::loadModel("prenotazioni", true);
        $booking->codicecanc = $deleteCode;

        $p = $this->db()->find($booking, array('limit' => 1));
        $d = Doo::loadModel("docenti", true);
        $d->did = $p->did;
        $d = $this->db()->find($d, array('limit' => 1));

        $this->db()->delete($booking);

        $this->sendEmailCanceledBooking($d, $p, $fromWho);

        $data = array('messaggio' => "Prenotazione Annullata!",
            'url' => Doo::conf()->APP_URL. "prenotazioni/",
            'titolo' => "Ben Fatto!"
        );
        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page', $data);

    }

}

?>