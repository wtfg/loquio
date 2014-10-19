<?php
$data["title"] = "Ordine di prenotazione in base al colloquio";

$ul = Doo::conf()->APP_URL . "global/";

$str = "<select name='docente'>";
$teachers = $data['teachers'];
foreach ($teachers as $teacher){
    $teacherId           = $teacher->did;
    $teacherFullName     =  $teacher->cognome. " ".$teacher->nome;
    $str .= "<option value='".$teacherId."'>".$teacherFullName."</option>";
}
$str .= "</select>";
ob_start();
?>
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/datepicker.css" />

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
            <li>Inserisci il giorno del colloquio</li>
            <li>Seleziona il nome del docente</li>
            <li>Clicca sul pulsante <b>"Invia"</b> e avrai la lista.</li>
        </ul>
    </div>
    <div class="span4">
        <div class="widget-box">
            <div class="widget-header">
                <h4>Scegli la data</h4>


            </div>

            <div class="widget-body">

                <form method="post" name="view-lista" action="">
                <div class="widget-main">
                    <div class="row-fluid">
                        <label for="id-date-picker-1">Visualizza l'ordine di prenotazione per il giorno</label>
                    </div>

                    <div class="control-group">
                        <div class="row-fluid input-append">
                            <input class="span10 date-picker" id="id-date-picker-1"  name="data" type="text" data-date-format="dd-mm-yyyy">
                                <span class="add-on">
                                    <i class="icon-calendar"></i>
                                </span>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <label for="id-date-picker-1">Seleziona docente</label>
                    </div>
                    <div class="control-group">
                        <div class="row-fluid input-append">

                            <?php echo $str ?>
                        </div>
                    </div>

                    <hr>
                    <button name="invia" type="submit" class="btn btn-large btn-success">
                        <i class="icon-ok bigger-150"></i>
                        Invia
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>


<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>




<script src="<?php echo $ul;?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $ul;?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $ul;?>assets/js/chosen.jquery.min.js"></script>
<script src="<?php echo $ul;?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $ul;?>assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $ul;?>assets/js/bootstrap-tag.min.js"></script>

<!--inline scripts related to this page-->

<script type="text/javascript">
    $(function() {
        $('.date-picker').datepicker().next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    });
</script>

<?php

$data["scripts"] = ob_get_contents();
ob_end_clean();

?>