<?php

class PrenotController extends DooController {

    public function beforeRun($resource, $action) {
        session_start();

        //if not login, group = anonymous
        $role = (isset($_SESSION['user']['acl'])) ? $_SESSION['user']['acl'] : 'anonymous';

        //check against the ACL rules
        if ($rs = $this->acl()->process($role, $resource, $action)) {

            return $rs;
        }
    }

    function showPrenUser() {
        
        // echo 'You are visiting ' . $_SERVER['REQUEST_URI'];
        
        $uid = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "";
        
        $prenotazioni = Doo::loadModel("prenotazioni", true);
        $prenotazioni->uid = $uid;
        $prenotazioni = $this->db()->find($prenotazioni, array("where"=> "data>".time()));
        
        $data = array();

        foreach($prenotazioni as $prenotazione){
            
            $d = Doo::loadModel("docenti", true); 
            $d->did =  $prenotazione->did;
            $d = $this->db()->find($d,array("limit"=>1));
            $m = Doo::loadModel("materie", true);  
            $m->mid =  $d->mid;
            $m = $this->db()->find($m,array("limit"=>1));
            
            $da["nomedocente"] = $d->nome." ".$d->cognome;
            $da["data"] =  date("d/m/Y H:i",$prenotazione->data);
            $da["materia"] = $m->nome;
            $da["studente"] = $prenotazione->studente;
            $da["codicecanc"]= $prenotazione->codicecanc;
       
            
            array_push($data,$da);
            
        }
        
        $this->renderc("view-prenotazioni-user", $data);
    }

    function showPrenDocente() {
        
        if(!isset($_POST['invia'])){
           $d = Doo::loadModel("docenti", true); 
           
           $str = "<select name='docente'>";
           
           $result = $this->db()->find($d);
           
           foreach ($result as $linea){
               //var_dump($linea);
              
               
               $id_docente = $linea->did;
               $nomecognome =  $linea->nome." ". $linea->cognome;
               $str .= "<option value='".$id_docente."'>".$nomecognome."</option>";
           }
           
           $str .= "</select>";
           
           $data['option'] = $str;
           
           //var_dump($_POST);
           
           $this->renderc("view-listapren", $data);
           
           
        }else{
          
           $ladata = $_POST['data'];
           
           $docente = $_POST['docente'];
           
           $p = Doo::loadModel("prenotazioni", true);
           $p->did = $docente;
           
            
           $d = Doo::loadModel("docenti", true); 
           $d->did = $docente;
           $docente = $this->db()->find($d,array("limit"=>1));
           $nomedoc = $docente->nome. " ".$docente->cognome;
           
           $olddata = $ladata;
           $dt = explode("/", $ladata);
           $ladata = $dt[1]."/".$dt[0]."/".$dt[2];
           $giornodopo = strtotime($ladata) + 86400;
           
           $result = $this->db()->find($p,array("where"=>"data>=".strtotime($ladata)." AND data<".$giornodopo));
           
           $data['prens'] = $result;
           $data['data'] = $olddata;
           $data['docente'] = $nomedoc;
           $this->renderc("view-listapren2", $data);
            
           
           
        }
        
        
    }

    function prenAjax() {

        if (isset($_POST['message'])) {
            /*
              $c = new myCalendar();
              $c->set_docente(json_decode("{\"Mon\":{\"seats\":1,\"timeslot\":[9,10,11,12]},\"Thu\":{\"seats\":1,\"timeslot\":[9]}}",true));

              $c->count_and_book(array("10/21/2013 12:00","10/21/2013 09:00"));
              echo $c->write_free_days(10);
             */
            $a = $_POST['message'];


            $did = $a['did'];
            
      
            
            
            $d = Doo::loadModel("docenti", true);
            $d->did = $did;
            $d = $this->db()->find($d, array("limit" => 1));

            if ($d) {

                $orelibere = json_decode($d->orelibere, true); //json_decode($d->orelibere, true);
            } else {

                $orelibere = false;
            }

            $c = new myCalendar();
            $c->load_globals(Doo::conf()->SITE_PATH);
            $p = Doo::loadModel("prenotazioni", true);
            $p->did = $did;
            $p = $this->db()->find($p);


            $prenCalendar = array();

            //var_dump($orelibere);

            if ($orelibere != false) {

                $c->set_docente($orelibere);

                foreach ($p as $f) {

                    array_push($prenCalendar, date("m/d/Y H:i", $f->data));
                }

                //$c->count_and_book(["10/21/2013 12:00","10/21/2013 09:00"]);
                $c->count_and_book($prenCalendar);
                #cambiare il parametro per i giorni liberi
                $fdays = $c->write_free_days(60);
                if($fdays != NULL){
                    echo $fdays;
                }else{
                    echo "{\"\":\"\"}";
                }
                
            } else {/**/
                echo "{\"\":\"\"}";
            }
            //}
            //$c->write_free_days(16);
        } else {
            //["1",{"allDay":"","title":"Test event","id":"821","end":"2011-06-06 14:00:00","start":"2011-06-06 06:00:00"},"1",{"allDay":"","title":"Test event 2","id":"822","end":"2011-06-10 21:00:00","start":"2011-06-10 16:00:00"}]["0",{"allDay":"","title":"Test event","id":"821","end":"2011-06-06 14:00:00","start":"2011-06-06 06:00:00"},"1",{"allDay":"","title":"Test event 2","id":"822","end":"2011-06-10 21:00:00","start":"2011-06-10 16:00:00"}] 
        }
    }

    function newPren() {

        // ajax:{ "step" : "docente", "did": 1}


        if (!isset($_POST['button'])) {

            $buf = array();
            $mats = array();

            $m = $this->db()->find("materie");


            foreach ($m as $materia) {

                $mats[$materia->mid] = $materia->nome;

                $d = Doo::loadModel("docenti", true);
                $d->mid = $materia->mid;

                $d = $this->db()->find($d, array("where"=>"attivo=1"));


                $buff = array();

                foreach ($d as $docente) {

                    $buff[$docente->did] = $docente->nome . " " . $docente->cognome;
                }

                $buf[$materia->mid] = $buff;
            }
            //var_dump($buf);
            // var_dump($mats);
            $data['uid'] = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "";
            $data['mdocenti'] = $buf;
            $data['materie'] = $mats;

            $this->renderc("add-prenotazioni", $data);
        } else {
            if (isset($_POST['did']) &&
                    isset($_POST['uid']) &&
                    isset($_POST['selected'])) {
                /*
                 * 
                 * data = post (selected)
                  did
                  uid
                  classe
                  studente
                  email
                  tel
                 */
                $_POST['selected'] = trim($_POST['selected']);
                $_POST['did'] = trim($_POST['did']);
                $_POST['classe'] = trim($_POST['classe']);
                $_POST['uid'] = trim($_POST['uid']);
                $_POST['studente'] = trim($_POST['studente']);
                $_POST['email'] = trim($_POST['email']);
                $_POST['tel'] = trim($_POST['tel']);

				$docente = Doo::loadModel("docenti", true);
				$docente->did = $_POST['did'];
				$docente = $this->db()->find($docente, array('limit'=>1));
				
                $prenotazione = Doo::loadModel("prenotazioni", true);
                $prenotazione->data = strtotime($_POST['selected']);
                $prenotazione->did = $_POST['did'];
                $prenotazione->uid = $_POST['uid'];
                $prenotazione->classe = $_POST['classe'];
                $prenotazione->studente = $_POST['studente'];
                $prenotazione->email = $_POST['email'];
                $prenotazione->tel = $_POST['tel'];
                $prenotazione->codicecanc = md5(time());
                // controlla se l'email già esiste


                $isexisting = $this->db()->find($prenotazione, array('limit' => 1));

                if (!$isexisting) {
                    $res = $this->db()->insert($prenotazione);
                    if ($res) {
						
						 //change this to your email. 
						$to = $prenotazione->email; 
						$from = "prenotazioni@loquio.it"; 
						$subject = "Prenotazione Colloquio"; 
						$thedate = explode(" ",$_POST['selected']);
						$thetime = $thedate[1];
						$thedate = $thedate[0];
						//begin of HTML message 
						$message = "<html> 
					  <body bgcolor=\"#FAFAFA\"> 
						 
							La tua prenotazione per il docente <b><font color=\"red\">".$docente->nome." ".$docente->cognome."</font></b> &egrave; stata confermata! <br> 
							La data della prenotazione &egrave; il  <font color=\"red\">".$thedate."</font> alle ore  <font color=\"red\">".$thetime."</font> <br> 
						
						  <br><br>Grazie Per L'Attenzione!<br><em>Il Team Di Loquio</em>
					  </body> 
					</html>"; 
					   //end of message 
						
						// To send the HTML mail we need to set the Content-type header. 
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers  .= "From: $from\r\n"; 
						//options to send to cc+bcc 
						//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
						//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
						 
						// now lets send the email. 
						mail($to, $subject, $message, $headers); 
				
						
                        $data['messaggio'] = "Prenotazione inserita! Riceverai una email fra poco contenente i dati della prenotazione";
                        $data['url'] = Doo::conf()->APP_URL;
                        $data['titolo'] = "Prenotato!";
                        
                        // MESSAGGIO DOCENTE MODIFICATO
                        $this->renderc('ok-page',$data);
                    } else {
                       $this->renderc("error-page");
                       return;
                    }
                } else {
                    // MESSAGGIO ERRORE FICO
                    $this->renderc("error-page");
                    return;
                }
            }else{
               $this->renderc("error-page");
               return;
            }
        }
    }

    function delPren() {
        $codicecanc = $this->params['md5'];
        $uid = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : "";
		if($uid == ""){
			$this->renderc("error-page");
			return;
		}
		
		$u = Doo::loadModel("utenti",true);
		$u->uid = $uid;
		$u = $this->db()->find($u, array('limit'=>1));
		$fromwho = $u->nome." ".$u->cognome;
		
        $prenotazione = Doo::loadModel("prenotazioni", true);
        $prenotazione->codicecanc = $codicecanc;
		$p = $this->db()->find($prenotazione, array('limit'=>1));
		$d = Doo::loadModel("docenti", true);
		$d->did = $p->did;
		$d = $this->db()->find($d, array('limit'=>1));
        $this->db()->delete($prenotazione);
        
		
		
		 //change this to your email. 
		$to = $d->email; 
		$from = "prenotazioni@loquio.it"; 
		$subject = "Colloquio Annullato"; 
		$thetime = date("h", $p->data).":00";
		$thedate = date("d/m/Y", $p->data);;
		//begin of HTML message 
		$message = "<html> 
	  <body bgcolor=\"#FAFAFA\"> 
		 
			La tua prenotazione da parte di <b><font color=\"red\">".$fromwho."</font></b> &egrave; stata annullata! <br> 
			La data della prenotazione era il <font color=\"red\">".$thedate."</font> alle ore  <font color=\"red\">".$thetime."</font> <br> 
		
		  <br><br>Grazie Per L'Attenzione!<br><em>Il Team Di Loquio</em>
	  </body> 
	</html>"; 
					   //end of message 
						
						// To send the HTML mail we need to set the Content-type header. 
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers  .= "From: $from\r\n"; 
						//options to send to cc+bcc 
						//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
						//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
						 
						// now lets send the email. 
						mail($to, $subject, $message, $headers); 
		
		
        $data['messaggio'] = "Prenotazione Annullata!";
        $data['url'] = Doo::conf()->APP_URL;
        $data['titolo'] = "Ben fatto!";

        // MESSAGGIO DOCENTE MODIFICATO
        $this->renderc('ok-page',$data);
        
    }

}
?>