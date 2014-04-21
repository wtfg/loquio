<?php

/**
 * Class myCalendar
 * Fa il lavoro sporco, ovvero capire i calendari
 * gestire i docenti e i bookoff
 */
class myCalendar
{

    private $bookedOffDays = array();
    private $teacher = array();
    private $monthNames = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");
    private $basedir = "";

    /**
     * @param $path string la directory dove si trovano i file di configurazione annuali
     */
    function myCalendar($path = null)
    {


        $this->basedir = $path;

        $this->loadGlobals($this->basedir);

    }

    /**
     * Ottiene il file delle configurazioni in quell'anno
     * @param $year
     *          anno delle globali
     * @return mixed
     *          oggetto PHP contenente le configurazioni
     */

    private function getData($year)
    {

        $url = $this->basedir . "global" . $year . ".json";

        if (file_exists($url)) {
            $f = fopen($url, "r");
            $r = @fread($f, filesize($url));
            fclose($f);
            return json_decode($r, true);
        }

    }

    /**
     * Carica le impostazioni globali e depenna i giorni settati su "no"
     */
    private function loadGlobals()
    {
        $currentYear = (int)date("Y");
        $nextYear = $currentYear + 1;
        for ($currentYear; $currentYear <= $nextYear; $currentYear++) {
            $g = $this->getData($currentYear);
            foreach ($g as $monthKey => $monthValue) {
                if ($monthKey != "bisestile") {
                    foreach ($monthValue as $dayKey => $dayValue) {
                        if ($dayValue == "false") {
                            $monthNumber = array_search($monthKey, $this->monthNames);
                            $this->bookOff($monthNumber . "/" . $dayKey . "/" . $currentYear);
                        }
                    }
                }
            }
        }
    }

    private function d()
    {
        var_dump($this->bookedOffDays);
    }

    function getJSONBookOff()
    {
        return json_encode($this->bookedOffDays);
    }

    function setJSONBookOff($str)
    {
        $this->bookedOffDays = json_decode($str);
    }

    function setTeacher($a)
    {
        $this->teacher = $a;
    }

    /**
     * Depenna un giorno dal calendario, quel giorno non
     * sara' prenotabile per nessuno
     * @param $date_from
     *          la data del giorno in formato data
     * @param null $date_to
     *          una data di destinazione (di default null)
     */
    function bookOff($date_from, $date_to = NULL)
    {
        if (is_null($date_to)) {
            array_push($this->bookedOffDays, strtotime($date_from));
        } else {
            array_push($this->bookedOffDays, strtotime($date_from) . "|" . strtotime($date_to));
        }
    }

    /**
     * Verifica se quel giorno e' off o meno
     * @param $date
     *          la data del giorno in formato data
     * @return bool
     *          true se il giorno e' occupato
     *          false se e' libero
     */
    public function isBookedOff($date)
    {
        $date = strtotime($date);
        foreach ($this->bookedOffDays as $current) {
            $s = explode("|", $current);
            if (sizeof($s) >= 2) {
                if ($date > (int)$s[0] and $date < (int)$s[1]) return TRUE;
            } else {
                if ((int)$date == (int)$current) return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Informa il calendario delle prenotazioni di un docente
     * restituisce e depenna in automatico quando le prenotazioni
     * superano il massimo consentito
     * @param $bookingsArray
     * @return array
     */
    function addBookings($bookingsArray)
    {

        $bookings = array(); # array contenente le prenotazioni
        $return = array(); # UNUSED di ritorno

        foreach ($bookingsArray as $b) {
            array_push($bookings, date("m/d/Y", strtotime($b))); # aggiunge le prenotazioni in modo riformattato
        }

        $bookingsNumber = array_count_values($bookings); # raggruppa in "key" i valori delle prenotazioni

        foreach ($bookings as $booking) { # per ogni giorno
            # imposta il max prenotazioni
            $bookingsMax = $this->thisTeacherHasSeats(strtotime($booking)) ? $this->teacher[date("D", strtotime($booking))]["seats"] : 0;

            # se ci sono prenotazioni per quel giorno
            /** @var $bookingsNumber conto dei giorni */
            if (($bookingsNumber[$booking] >= $bookingsMax)
                && $bookingsMax != 0
                && array_search($booking, $return) === false
            ) {

                array_push($return, $booking);
                if ($this->isBookedOff($booking) == FALSE) {
                    $this->bookOff($booking);
                }

            }
        }
        return $return;
    }

    /**
     * Se il docente e' disponibile quel giorno
     * @param $day  int il giorno in TIMESTAMP UNIX
     * @return bool true se ci sono seats, false se non ci sono
     */
    private function thisTeacherHasSeats($day)
    {
        $a = array_key_exists(date("D", $day), $this->teacher);
        return $a && ($this->teacher[date("D", $day)]["seats"] != 0);
    }

    /**
     * ritorna i giorni disponibili per il docente
     * @param $days_limit       int numero di giorni a cui guardare
     * @return array            una coppia di array:
     *                          il primo ha i giorni disponibili
     *                          il secondo quelli occupati
     *                          entrambi sono formattati per il calendar
     */
    private function lookAhead($days_limit)
    {
        $return = array();
        $booked_days = array();
        $firstDay = strtotime(date("m/d/Y", time()));

        for ($i = 0; $i < $days_limit; $i++) {

            $nextDay = $firstDay + ($i * 24 * 60 * 60);
            if ($this->isBookedOff(date("m/d/Y", $nextDay))) {
                continue;
            }
            if ($this->thisTeacherHasSeats($nextDay)) {
                foreach ($this->teacher[date("D", $nextDay)]["timeslot"] as $timeSlot) {

                    // TODO timeslot a 15 minuti, basta rimuovere :00 e implementarlo nel DB

                    $timeSlotTime = strtotime(date("m/d/Y", $nextDay) . " " . $timeSlot . ":00");
                    $nowTime = time();

                    if (!$this->isBookedOff(date("m/d/Y", $nextDay))) {
                        if ($timeSlotTime > $nowTime) {
                            # aggiunge ai disponibili
                            array_push($return, $timeSlotTime);
                        }
                    } else {
                        # aggiunge ai non disponibili
                        array_push($booked_days, $timeSlotTime);
                    }
                }
            }
        }
        return array($return, $booked_days);
    }

    /**
     * AJAX: Ottiene i giorni disponibili in JSON
     * @param $days
     *              i giorni da lookahead
     * @return string
     *              la stringa JSON
     */
    function getFreeDaysJSON($days)
    {

        $output = "[";
        $i = 0;
        $availableDays = $this->lookAhead($days);

        if ($availableDays) {
            if (sizeof($availableDays[0]) == 0) {
                return "[]";
            }
            # processa i giorni disponibili
            foreach ($availableDays[0] as $event) {
                $d = date("Y-m-d H:i:s", $event);
                $output .= "\"" . $i . "\",{\"title\":\"Libero\",\"start\":\"" . $d . "\",\"allDay\":\"\"},";
                $i++;
            }
            # processa i giorni occupati
            foreach ($availableDays[1] as $event) {
                $d = date("Y-m-d H:i:s", $event);
                $output .= "\"" . $i . "\",{\"title\":\"Occupato\",\"start\":\"" . $d . "\",\"allDay\":\"\"},";
                $i++;
            }
            return substr($output, 0, strlen($output) - 1) . "]";
        }
    }

}

?>