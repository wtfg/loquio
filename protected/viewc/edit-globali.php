<?php

// TODO cambia anno

$STATIC_JSON_PATH = Doo::conf()->SITE_PATH . "global/json";
$GLOBAL_PATH = Doo::conf()->APP_URL . "/global/";


$anno = (isset($_POST['anno'])) ? $_POST['anno'] : date("Y");


$SUCCESS_MESSAGE = "  <script src=\"".$GLOBAL_PATH."assets/js/jquery.gritter.min.js\"></script>
            <script type=\"text/javascript\">
                        $(document).ready(function(){
                        $.gritter.add({
						// (string | mandatory) the heading of the notification
						title: 'Ben Fatto!',
						// (string | mandatory) the text inside the notification
						text: 'Calendario aggiornato con successo!',
class_name: 'gritter-success'
});
                        });
            </script>";
$FILENAME = $STATIC_JSON_PATH . "/global" . $anno . ".json";
if (!file_exists($FILENAME)) {
    if (file_exists($STATIC_JSON_PATH . "/global" . ($anno - 1))) {
        copy($STATIC_JSON_PATH . "/global" . ($anno - 1) . ".json", $FILENAME);
    } else {
        $calendario = array("gennaio" => array("1" => "false", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "febbraio" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true"), "marzo" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "aprile" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true"), "maggio" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "giugno" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true"), "luglio" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "agosto" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "settembre" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true",), "ottobre" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "novembre" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "true", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true",), "dicembre" => array("1" => "true", "2" => "true", "3" => "true", "4" => "true", "5" => "true", "6" => "true", "7" => "true", "8" => "true", "9" => "true", "10" => "true", "11" => "true", "12" => "true", "13" => "true", "14" => "true", "15" => "true", "16" => "true", "17" => "true", "18" => "true", "19" => "true", "20" => "true", "21" => "true", "22" => "true", "23" => "true", "24" => "true", "25" => "false", "26" => "true", "27" => "true", "28" => "true", "29" => "true", "30" => "true", "31" => "true"), "bisestile" => ((date("Y") % 4) == 0) ? "true" : "false",);
        $jc = json_encode($calendario);
        $f = fopen($FILENAME, "w");
        fwrite($f, $jc);
        fclose($f);
    }
}
if (isset($_POST['json'])) {

    $js = $_POST['json'];
    echo "<!--" . $js . "-->";

    $js = str_replace("\\", "", $js);
    $f = fopen($FILENAME, "w");
    fwrite($f, $js);
    fclose($f);
} else {
    $f = fopen($FILENAME, "r");
    $js = fread($f, filesize($FILENAME));
}

$js = json_decode($js, true);
$json_cal = json_encode($js);
ob_start();
?>
    <link rel="stylesheet" href="<?php echo $GLOBAL_PATH; ?>assets/css/jquery.gritter.css">
<?php
$data['head'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

<script src="<?php echo $GLOBAL_PATH; ?>/fc/lib/jquery.min.js"></script>
<script>
function activateAll() {
    $("input").each(function () {
        $(this).click(function () {

            if ($(this).attr("name") == "wChk") {
                theid = $(this).attr("id");
                day = theid.substring(0, theid.indexOf("_"));
                month = theid.substring(theid.indexOf("_") + 1);
                checked = $(this).prop("checked").toString();
                js = calendar_set_day(js, month, day, checked);
                updateJsonInput(jsonid, js);

            }
        });
    });
}
var theCalendar = <?php echo $json_cal; ?>;

function calendar_set_day(js, month, day, value) {
    //ritorna un json a cui e impostato il giorno
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];
    js[mesi[month]][day.toString()] = value;
    return js;
}
function calendar_get_day(js, month, day) {
    //ritorna il valore del giorno tovato
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];
    return js[mesi[month]][day.toString()];
}
function createTable(theJson) {
    //ritorna una stringa contente l'html della tabella dei mesi
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];
    var strFinale = "";
    var days = 31;
    for (i = 0; i < 12; i++) {
        mese = mesi[i];
        days = days_in_month(mese, theJson["bisestile"]);
        stringaOut = "<br><h3 class=\"header smaller lighter blue\">" + mese.toString().toUpperCase() + "</h3><table>";
        for (j = 1; j <= days; j++) {
            giorno = j.toString();
            nome_giorni = ["domenica", "lunedi", "martedi", "mercoledi", "giovedi", "venerdi", "sabato"];
            g = new Date();
            g.setYear(<?php echo $anno?>);
            g.setMonth(i);
            g.setDate(j);
            giorno_corrente = nome_giorni[g.getDay()];

            numeroTd = (g.getDay() + 6) % 7;
            header = "";
            if (j == 1) { // se e il primo del mese
                header = "<tr><th>L<th>M<th>M<th>G<th>V<th>S<th>D</tr><tr>";
                for (s = 0; s < numeroTd; s++) {
                    header += "<td></td>";
                }
            }
            coda = "";
            checked = "checked=\"checked\"";
            stringaOut += header;
            if (giorno_corrente == "lunedi" && j != 1) {
                stringaOut += "<tr>";

            } else if (giorno_corrente == "domenica" && j != 1) {
                coda = "</tr>";
            }

            //      http://localhost:8080/app/tabella_giorni.php

            if (theJson[mese][giorno] == "false") {
                checked = ""
            }
            inpId = j + "_" + i;
            if (j < 10) {
                ww = "0" + j;
            } else {
                ww = j;
            }
            valore_corrente = "<td><label><input type=\"checkbox\" name=\"wChk\" id=\"" + inpId + "\" " + checked + "><span class=\"lbl\">" + ww + " </span></label></td>";
            stringaOut += valore_corrente + coda;

        }
        stringaOut += "</table>";
        strFinale += stringaOut;

    }
    return strFinale;
}
function updateCalendar(theCalendar, w) {
    //aggiorna l'html di un tag w con il contenuto del calendario
    content = createTable(theCalendar);
    $(w).html(content);
    activateAll();
}
function days_in_month(m, bisestile) {
    //ritorna i giorni presenti nel mese
    if (m == "febbraio") {
        if (bisestile == "true") {
            days = 29;
        } else {
            days = 28;
        }
    } else if (m == "novembre" || m == "aprile" || m == "giugno" || m == "settembre") {
        days = 30;
    } else {
        days = 31;
    }
    return days;
}

function turn_weeks(js, weeks, activate) {
    //ritorna un json a cui attiva o disattiva specifiche settimane
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];
    for (mese = 0; mese < 12; mese++) {
        m = mesi[mese];
        for (i = 0; i < weeks.length; i++) {
            week = weeks[i];
            for (j = ((week - 1) * 7) + 1; j <= (week) * 7; j++) {
                if (j <= days_in_month(m, js["bisestile"])) {
                    if (activate == "true" || activate == "false") {
                        js[m][j.toString()] = activate;
                    }
                }
            }
        }
    }
    return js;
}
function turn_months(js, months, activate) {
    //ritorna un json a cui attiva o disattiva specifici mesi
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];

    for (mese = 0; mese < 12; mese++) {
        m = mesi[mese];
        for (i = 0; i < months.length; i++) {
            if (mese == months[i]) {
                for (j = 1; j <= days_in_month(m, js["bisestile"]); j++) {
                    if (activate == "true" || activate == "false") {
                        js[m][j.toString()] = activate;
                    }
                }
            }
        }
    }
    return js;
}
function turn_month_day(js, days, activate) {
    //ritorna un json a cui attiva o disattiva dei giorni del mese specifici
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];

    for (mese = 0; mese < 12; mese++) {
        m = mesi[mese];
        for (i = 0; i < days.length; i++) {
            if (days[i] <= days_in_month(m, js["bisestile"])) {
                if (activate == "true" || activate == "false") {
                    js[m][days[i].toString()] = activate;
                }
            }
        }
    }
    return js;
}
function turn_all(js, activate) {
    //ritorna un json a cui attiva o disattiva tutti i giorni
    var mesi = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];

    for (mese = 0; mese < 12; mese++) {
        m = mesi[mese];
        for (i = 1; i <= days_in_month(m, js["bisestile"]); i++) {
            if (activate == "true" || activate == "false") {
                js[m][i.toString()] = activate;
            }
        }
    }
    return js;
}
function updateJsonInput(id, js) {

    $(id).val(JSON.stringify(js));
}

$(document).ready(function () {

    calendar_div = "#tabella"
    jsonid = "#json";

    js = theCalendar;
    /*   js = turn_month_day(theCalendar,[1,2,3,4,5,6,7,8],"false");
     js = turn_all(js, "true")*/
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);

    activateAll();
    $("#deact").click(function () {
        disp = "false";

        ima = $("#iima_active").prop("checked");
        ab = $("#ab_active").prop("checked");
        listagiorni = $("#listagiorni_active").prop("checked");
        listamesi = $("#listamesi_active").prop("checked");
        tutti = $("#tutti_active").prop("checked");
        if (ima) {
            setta_i_ima(js, calendar_div, jsonid, disp)
        }
        if (ab) {
            setta_ab(js, calendar_div, jsonid, disp)
        }
        if (listagiorni) {
            setta_giorni(js, calendar_div, jsonid, disp)
        }
        if (listamesi) {
            setta_mesi(js, calendar_div, jsonid, disp)
        }
        if (tutti) {
            setta_tutto(js, calendar_div, jsonid, disp)
        }


    });
    $("#act").click(function () {
        disp = "true";
        ima = $("#iima_active").prop("checked");
        ab = $("#ab_active").prop("checked");
        listagiorni = $("#listagiorni_active").prop("checked");
        listamesi = $("#listamesi_active").prop("checked");
        tutti = $("#tutti_active").prop("checked");
        if (ima) {
            js = setta_i_ima(js, calendar_div, jsonid, disp)
        }
        if (ab) {
            js = setta_ab(js, calendar_div, jsonid, disp)
        }
        if (listagiorni) {
            js = setta_giorni(js, calendar_div, jsonid, disp)
        }
        if (listamesi) {
            js = setta_mesi(js, calendar_div, jsonid, disp)
        }
        if (tutti) {
            js = setta_tutto(js, calendar_div, jsonid, disp)
        }


    });

});

function setta_tutto(js, calendar_div, jsonid, disp) {
    js = turn_all(js, disp.toString());
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);
    return js;
}
function setta_i_ima(js, calendar_div, jsonid, disp) {
    valori = $("#iima").val().toString().replace(" ", "").split(",");
    js = turn_weeks(js, valori, disp.toString())
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);
    return js;
}
function setta_giorni(js, calendar_div, jsonid, disp) {
    valori = $("#listagiorni").val().toString().replace(" ", "").split(",");
    js = turn_month_day(js, valori, disp.toString())
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);

    return js;
}
function setta_mesi(js, calendar_div, jsonid, disp) {
    valori = $("#listamesi").val().toString().replace(" ", "").split(",");
    for (i = 0; i < valori.length; i++) {
        valori[i] -= 1;
    }
    js = turn_months(js, valori, disp.toString())
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);
    return js;
}
function setta_ab(js, calendar_div, jsonid, disp) {
    a = $("#a").val();
    b = $("#b").val();
    g = [];
    for (i = parseInt(a); i <= parseInt(b); i++) {
        g.push(i);
    }
    js = turn_month_day(js, g, disp.toString())
    updateCalendar(js, calendar_div);
    updateJsonInput(jsonid, js);
    return js;
}

</script>
<?php

if (isset($_POST['json'])) {
    echo $SUCCESS_MESSAGE;
}
$data['scripts'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Calendario <?php echo $anno; ?>
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

<form action="#" method="post">
    <h6>Cambia anno:</h6>
    <select onchange='javascript:form.submit()' name="anno">

        <option value="<?php echo date("Y");
        if (date("Y") == $anno) {
            echo "\" selected=\"selected";
        }

        ?>"><?php echo date("Y"); ?></option>
        <option value="<?php echo ((int)date("Y")) + 1;
        if (((int)date("Y")) + 1 == $anno) {
            echo "\" selected=\"selected";
        }

        ?>"><?php echo ((int)date("Y")) + 1; ?></option>

    </select>


</form>
<br>

    <div class="col-sm-5">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Seleziona</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="control-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="iima_active">
                                <span class="lbl"> la <input type="text" id="iima"> - a settimana di ogni mese (lista numerica separata da virgole)</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="ab_active">
                                <span class="lbl"> un range dal <input type="text" id="a"> al <input type="text" id="b"> di ogni mese</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="listagiorni_active">
                                <span class="lbl"> la lista di giorni (separata da virgole) <input type="text" id="listagiorni"> di ogni mese</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="listamesi_active">
                                <span class="lbl"> la lista (numerica separata da virgole) <input type="text" id="listamesi"> di mesi</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="tutti_active">
                                <span class="lbl"> tutti i mesi</span>
                            </label>
                        </div>

                    </div>
                        <br>
                    <div class="form-group">
                        <input type="button" id="act" value="Attiva">
                        <input type="button" id="deact" value="Disattiva">
                    </div>
                        <form action="#" method="post">
                            <input type="hidden" name="anno" value="<?php echo $anno ?>">
                            <input type="hidden" name="json" id="json" style="width:700px;" value=""><br><br>
                            <button name="invia" type="submit" class="btn btn-large btn-success">
                                <i class="icon-ok bigger-150"></i>
                                Invia
                            </button>

                        </form>
                </div>
            </div>
        </div>
    </div>

<div class="row-fluid">
<div id="tabella"></div>
</div>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>