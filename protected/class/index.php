<?php

/*
 * 
 * TODO ottenere dati globali e parsarli
 *
 */

class myCalendar {

    public $book = array();
    public $docente = array();
    function load_globals($basedir){

        for($y=(int)date("Y");$y<=(int)date("Y")+1;$y++){
            
            $url = $basedir."/global".$y.".json";
            $f = fopen($url,"r");
            $r = fread($f, filesize($url));
            fclose($f);
            $g = json_decode($r, true);
            $mesi = array("","gennaio","febbraio","marzo","aprile","maggio","giugno","luglio","agosto","settembre","ottobre","novembre","dicembre");
            $unpush = array();
            foreach($g as $nomemese => $mese){
                if($nomemese != "bisestile"){
                    foreach($mese as $giorno => $valgiorno){
                        if($valgiorno == "false"){
                            $num_mese = array_search($nomemese,$mesi);
                            //$data_book = strtotime();
                            $this->bookoff($num_mese."/".$giorno."/".$y);
                            //array_push($unpush, $data_book);
                        }
                    }
                }
            }
        }
        //var_dump($this->book);
    }
    function d() {

        var_dump($this->book);
    }

    function export_bookoff() {


        return json_encode($this->book);
    }

    function clean_import_bookoff($str) {

        $this->book = json_decode($str);
    }

    function set_docente($a) {
        $this->docente = $a;
    }

    function bookoff($date_from, $date_to = NULL) {

        if (is_null($date_to)) {

            array_push($this->book, strtotime($date_from));
        } else {

            array_push($this->book, strtotime($date_from) . "|" . strtotime($date_to));
        }
    }

    public function is_booked($date) {

        //vede che data risulta occupata

        $date = strtotime($date);

        foreach ($this->book as $current) {

            $s = explode("|", $current);

            if (sizeof($s) >= 2) {

                if ($date > (int) $s[0] and $date < (int) $s[1]) {

                    return TRUE;
                }
            } else {
                if ((int) $date == (int) $current) {

                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    function count_and_book($prenotazioni) {
        //conta le prenotazioni e se eccedono lo booka
        $prens = array();
        $return = array();

        // trasforma le prenotazioni in date giornaliere

        foreach ($prenotazioni as $b) {

            array_push($prens, date("m/d/Y", strtotime($b)));
        }

        // conta i valori

        $counts = array_count_values($prens);

//		echo"<hr>";
//		var_dump($prens);
//		echo"<hr>";
//		var_dump($counts);
//		echo"<hr>";

        foreach ($prens as $f) {

            // vede che giorno e e se c'e vedere se e libero

            if (array_key_exists(date("D", strtotime($f)), $this->docente)) {
                $seats = $this->docente[date("D", strtotime($f))]["seats"];
            } else {

                $seats = 0;
            }

            if ($counts[$f] >= $seats && $seats != 0) {

                //if((array_search($prenhour, $this->docente[date( "D", strtotime($f))]["timeslot"]) === false)){
                if (array_search($f, $return) === false) {

                    array_push($return, $f);
                    if ($this->is_booked($f) == FALSE) {
                        $this->bookoff($f);
                        //echo $f." <b>prenotato</b><br><br>";
                    }
                }
                //}
            }
        }

        return $return;
    }

    function get_avalaible_days($days_limit) {

        //partendo da oggi ricava i giorni disponibili di un docente
        $return = array();
        $booked_days = array();
        
        $firstday = strtotime(date("m/d/Y",time()));
        //echo "<hr>".$firstday."<hr>";

        $lastday = $firstday + ($days_limit * 24 * 60 * 60);

        //echo "<hr>".$lastday."<hr>";

        for ($i = 0; $i < $days_limit; $i++) {

            $dayi = $firstday + ($i * 24 * 60 * 60);
            if($this->is_booked(date("m/d/Y", $dayi))){
                continue;
            }
            //echo "<hr>".$dayi."<hr>";

            if (array_key_exists(date("D", $dayi), $this->docente)) {

                //echo date( "D", $dayi)." esiste per il docente";

                if ($this->docente[date("D", $dayi)]["seats"] != 0) {

                    //echo date( "D", $dayi)." ha dei seats per il docente";

                    foreach ($this->docente[date("D", $dayi)]["timeslot"] as $timeslot) {

                        //echo $timeslot;
                        //echo date("m/d/Y", $dayi)." ".$timeslot.":00";
                        $timeSlotTime = strtotime(date("m/d/Y", $dayi) . " " . $timeslot . ":00");
                        $nowTime = time();
                        if (!$this->is_booked(date("m/d/Y", $dayi))) {//." ".$timeslot.":00" )){
                            if( $timeSlotTime>$nowTime){
                            //echo "<hr><hr>".date("m/d/Y", $dayi)." ".$timeslot.":00 e libero<hr><hr>";
                                array_push($return, strtotime(date("m/d/Y", $dayi) . " " . $timeslot . ":00"));
                            }
                            // TODO ritorna una lista seria
                        } else {
                            array_push($booked_days, strtotime(date("m/d/Y", $dayi) . " " . $timeslot . ":00"));
                        }
                    }
                }
            }
        }
        //var_dump($return);
        return array($return, $booked_days);
    }

    function write_free_days($days) {

        $output = "[";
        $i = 0;

        $availabledays = $this->get_avalaible_days($days);
        //return "{\"nigga\":\"hoe\"}";

        if ($availabledays) {
            
            if(sizeof($availabledays[0])==0){
                return "[]";
            }
            foreach ($availabledays[0] as $event) {

                $d = date("Y-m-d H:i:s", $event);
                $output .= "\"" . $i . "\",{\"title\":\"Libero\",\"start\":\"" . $d . "\",\"allDay\":\"\"},";
                $i++;
            }
            foreach ($availabledays[1] as $event) {

                $d = date("Y-m-d H:i:s", $event);
                $output .= "\"" . $i . "\",{\"title\":\"Occupato\",\"start\":\"" . $d . "\",\"allDay\":\"\"},";
                $i++;
            }

            return substr($output, 0, strlen($output) - 1) . "]";
        }
    }

}

/*

  <!DOCTYPE html>
  <html>
  <head>
  <link href='global/fc/fullcalendar/fullcalendar.css' rel='stylesheet' />
  <link href='global/fc/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
  <script src='global/fc/lib/jquery.min.js'></script>
  <script src='global/fc/lib/jquery-ui.custom.min.js'></script>
  <script src='global/fc/fullcalendar/fullcalendar.js'></script>
  <script>

  $(document).ready(function() {

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  $('#calendar').fullCalendar({
  defaultView: 'agendaWeek',
  editable: false,
  firstDay: 1,
  timeFormat: 'H(:mm)',
  eventClick: function(calEvent, jsEvent, view) {

  curr_min = calEvent.start.getMinutes() + "";

  if (curr_min.length == 1)
  {
  curr_min = "0" + curr_min;
  }
  data = calEvent.start.getDate() + "-"+(calEvent.start.getMonth()+1)+"-"+calEvent.start.getFullYear()+" "+calEvent.start.getHours()+":"+curr_min;

  if(calEvent.title!="Occupato"){

  $('#selected').html('Event: ' + data);

  }
  //alert('Event: ' + calEvent.title);

  //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
  //alert('View: ' + view.name);

  // change the border color just for fun
  //$(this).css('border-color', 'red');

  },
  columnFormat: {
  month: 'ddd',    // Mon
  week: 'ddd d/M', // Mon 9/7
  day: 'dddd d/M'  // Monday 9/7
  },
  events: [
  <?php
  echo $c->writeFreeDays(31);
  ?>


  ],
  eventColor: '#000044'
  });

  });

  </script>
  <style>

  body {
  margin-top: 40px;
  text-align: center;
  font-size: 14px;
  font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
  }

  #calendar {
  width: 900px;
  margin: 0 auto;
  }

  </style>
  </head>
  <body>
  <div id="selected" style="background-color:#CCC"></div>
  <div id='calendar'></div>
  </body>
  </html> */
?>