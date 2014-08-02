<?php
$data["title"] = "Prenotazioni per giorno";

$ul = Doo::conf()->APP_URL . "global/";

$str = "<select name='docente'>";
$teachers = $data['teachers'];
foreach ($teachers as $teacher){
    $teacherId           = $teacher->did;
    $teacherFullName     =  $teacher->nome." ". $teacher->cognome;
    $str .= "<option value='".$teacherId."'>".$teacherFullName."</option>";
}
$str .= "</select>";
ob_start();
?>
    <!--page specific plugin styles-->
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/jquery-ui-1.10.3.custom.min.css" />
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/datepicker.css" />

<?php
$data["head"] = ob_get_contents();
ob_end_clean();

ob_start();
?>
    <div class="span4">
        <div class="widget-box">
            <div class="widget-header">
                <h4>Scegli la data</h4>


            </div>

            <div class="widget-body">

                <form method="post" name="view-lista" action="">
                <div class="widget-main">
                    <div class="row-fluid">
                        <label for="id-date-picker-1">Visualizza le prenotazioni per il giorno</label>
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
                    <button class="btn btn-info" name="invia" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        Submit
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



<!--basic scripts-->

<!--[if !IE]>-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<!--<![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $ul;?>assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<script src="<?php echo $ul;?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $ul;?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $ul;?>assets/js/chosen.jquery.min.js"></script>
<script src="<?php echo $ul;?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $ul;?>assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $ul;?>assets/js/bootstrap-tag.min.js"></script>

<!--ace scripts-->

<script src="<?php echo $ul;?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo $ul;?>assets/js/ace.min.js"></script>

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