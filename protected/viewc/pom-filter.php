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
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/chosen.css">
<?php
$data["head"] = ob_get_contents();
ob_end_clean();

ob_start();
?>

    <div class="span8">

        <div class="widget-box">
            <div class="widget-header">
                <h4>Filtraggio delle liste</h4>
            </div>
            <div class="widget-body">

                <div class="widget-main">
                    <form method="post" name="form" id="form" action="">
                        <fieldset id="step1">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Quanti giorni durano i colloqui pomeridiani?</strong><br>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Digita il numero dei giorni</label>

                                <div class="days">
                                    <input type="text" name="days_num" id="days_num" value="" placeholder="Nome">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="step2">

                        </fieldset>
                        <fieldset id="step3">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Quali sono i criteri?</strong><br>
                                Seleziona il criterio che preferisci
                                <ul>
                                    <li><b>Nessuno</b>: le prenotazioni vengono raggruppate per docenti</li>
                                    <li><b>Blocchi</b>: divide in blocchi di studenti (ad esempio 50 al giorno). Bisogna inserire la grandezza dei blocchi, oppure suddividere in parti (es. 50,200 divide il primo blocco in 1-50 e il secondo in 51-200)</li>
                                    <li><b>Canali</b>: divide per ordine alfabetico rispettando l'ordine di prenotazione. Bisogna inserire iniziali e finali (incluse) dei canali tutte in maiuscolo, ad es. AL,MZ</li>
                                </ul>
                            </div>
                            <div class="row-fluid">
                                <label for="criterion">Criteri</label>
                                <select id="criterion" name="criterion">
                                    <option value="none">Nessuno (Docenti)</option>
                                    <option value="blocks">A blocchi</option>
                                    <option value="channels">A canali</option>
                                </select>

                            </div>
                            <div class="row-fluid">
                                <label for="mid">Criteri</label>
                                <input name="criterion-type" id="criterion-type" value="">

                            </div>
                        </fieldset>
                        <fieldset id="step4">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Assegna i giorni ai vari professori</strong><br>
                            </div>

                        </fieldset>

                    </form>
                    <button id="nextbutton" class="btn btn-large btn-success">

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
    <script type="text/javascript">
        var teachers = <?php echo $data["teachers_json"] ?>;
    </script>
    <script src="<?php echo $ul; ?>js/pom-filter.js"></script>

    <!--inline scripts related to this page-->

    <script type="text/javascript">
    </script>

<?php

$data["scripts"] = ob_get_contents();
ob_end_clean();

?>