<?php
$data["title"] = "Filtra";

$ul = Doo::conf()->APP_URL . "global/";
/*
$str = "<select name='docente'>";
$teachers = $data['teachers'];
foreach ($teachers as $teacher){
    $teacherId           = $teacher->did;
    $teacherFullName     =  $teacher->cognome. " ".$teacher->nome;
    $str .= "<option value='".$teacherId."'>".$teacherFullName."</option>";
}
$str .= "</select>";
*/
ob_start();
?>
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/datepicker.css"/>

<?php
$data["head"] = ob_get_contents();
ob_end_clean();

ob_start();
?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <strong>Qual'&eacute; il mio ordine di prenotazione?</strong><br>
        Basta seguire questi passi:
        <ul>
            <li>Inserisci il giorno del colloquio. Clicca fuori dal calendario per nascondere il calendario.</li>
            <li>Seleziona il nome del docente</li>
            <li>Clicca sul pulsante <b>"Invia"</b> e avrai la lista.</li>
        </ul>
    </div>
    <div class="span4">

        <div class="widget-box">
            <div class="widget-header">
                <h4>--</h4>
            </div>
            <div class="widget-body">

                <div class="widget-main">
                    <form method="post" name="form" action="">
                        <fieldset id="step1">
                            <div class="control-group">
                                <label class="control-label">Num Giorni</label>

                                <div class="days">
                                    <input type="text" name="days_num" id="days_num" value="" placeholder="Nome">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="step2">

                        </fieldset>
                        <fieldset id="step3">
                            <div class="row-fluid">
                                <label for="mid">Criteri</label>
                                <select id="mid" name="mid">
                                    <option value="none">Nessuno (Docenti)</option>
                                    <option value="blocks">A blocchi</option>
                                    <option value="channels">A canali</option>
                                </select>

                            </div>

                        </fieldset>
                        <fieldset id="step4">

                        </fieldset>

                    </form>
                    <button name="prevbutton" class="btn btn-large btn-success">
                        Indietro
                    </button>
                    <button name="nextbutton" class="btn btn-large btn-success">

                        Avanti
                    </button>
                </div>
            </div>
        </div>
    </div>


<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

    <script src="<?php echo $ul; ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $ul; ?>assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo $ul; ?>assets/js/chosen.jquery.min.js"></script>
    <script src="<?php echo $ul; ?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $ul; ?>assets/js/date-time/daterangepicker.min.js"></script>
    <script src="<?php echo $ul; ?>assets/js/bootstrap-tag.min.js"></script>

    <!--inline scripts related to this page-->

    <script type="text/javascript">
        /**
         * maschera
         + seleziona numero giorni campo:       days_num
         + quali sono i giorni? campo:          days[]
         + criteri (niente, blocchi, canali):   criterion
         + N insiemi a cui assegnare docenti:   set[0..days][]
         + ricorreggi esporta
         */
        var _form = "#form";
        var teachers = {1: "amadei", 2: "amadeia", 3: "test"};//< ?php echo $data["teachers_json"] ?>;
        var steps = ["#step1", "#step2", "#step3", "#step4"];
        var days_array = [];
        var current_step = 0;
        $(document).ready(function () {
            $("#nextbutton").click(function () {
                if (current_step == steps.length - 1) {
                    $(_form).submit();
                    return;
                }
                $(steps[current_step]).hide();
                current_step++;
                call(steps[current_step].substr(1));
                $(steps[current_step]).show();
            });
            $("#prevbutton").click(function () {
                $(steps[current_step]).hide();
                current_step++;
                call(steps[current_step].substr(1));
                $(steps[current_step]).show();
            });

        });
        function step1() {
            window.days_num = $("#days_num").val();
        }
        function step2() {
            var _html = "";
            for (i = 0; i < window.days_num; i++) {
                _html += '<div class="control-group"><div class="row-fluid input-append"><input class="span10 date-picker" id="day' + i + '"  name="days[]" type="text" data-date-format="dd-mm-yyyy"><span class="add-on"><i class="icon-calendar"></i></span></div></div>';
            }
            $("#step2-fields").html(_html);
            $('.date-picker').datepicker({orientation: "top right", autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }
        function step3() {
            var inputs = document.getElementsByClassName('date-picker');
            window.days_array = [].map.call(inputs, function (input) {
                return input.value;
            });
        }
        function step4() {
            _html = "";
            for (i = 0; i < days_num; i++) {
                options = "<option value="
                " />\n"
                for (id in teachers) {
                    options += "<option value=\"" + id + "\" />" + teachers[id] + "\n"
                }
                _html += '<div class="row-fluid"><label for="form-field-select-4">' + days_array[i] + '</label><select multiple="" class="chzn-select" name="set[' + i + '][]" data-placeholder="Choose a Country...">' + options + '</select></div>';
            }
            $("#step2-fields").html(_html);
            $('.chzn-select').chosen();

        }
        function call(str) {
            window[str]();
        }
        $(function () {
            $('.date-picker').datepicker({orientation: "top right", autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        });


    </script>

<?php

$data["scripts"] = ob_get_contents();
ob_end_clean();

?>