<?php
$data["title"] = "Inserisci Bookoff";

$ul = Doo::conf()->APP_URL . "global/";


ob_start();
?>
    <!--page specific plugin styles-->
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/jquery-ui-1.10.3.custom.min.css" />
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo $ul;?>assets/css/daterangepicker.css">
<?php
$data["head"] = ob_get_contents();
ob_end_clean();

ob_start();
?>
    <div class="span4">
        <div class="widget-box">
            <div class="widget-header">
                <h4>Bookoffs:</h4>


            </div>

            <div class="widget-body">

                <form method="post" name="view-lista" action="">
                <div class="widget-main">
                    <div class="row-fluid">
                        <label for="did">Seleziona docente</label>
                    </div>
                    <div class="control-group">
                        <div class="row-fluid input-append">
                            <select name="did" id="did">
                                <?php
                                foreach($data["docenti"] as $docente){
                                    ?>
                                    <option value="<?php echo $docente["did"]?>"><?php echo $docente["nomecognome"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <label for="id-date-range-picker-1">Range di tempo</label>
                    </div>
                    <div class="control-group">
                        <div class="row-fluid input-prepend">
                            <span class="add-on">
                                <i class="icon-calendar"></i>
                            </span>
                            <input class="span10" type="text" name="fromto" id="id-date-range-picker-1">
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




<!--page specific plugin scripts-->
    <script src="<?php echo $ul;?>assets/js/chosen.jquery.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/fuelux/fuelux.spinner.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/date-time/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/date-time/moment.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/date-time/daterangepicker.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/jquery.knob.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/jquery.autosize-min.js"></script>
    <script src="<?php echo $ul;?>assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/jquery.maskedinput.min.js"></script>
    <script src="<?php echo $ul;?>assets/js/bootstrap-tag.min.js"></script>



<!--inline scripts related to this page-->

<script type="text/javascript">
    $(function() {
        $('#id-date-range-picker-1').daterangepicker({
            format: 'DD/MM/YYYY'
        }).prev().on(ace.click_event, function(){
            $(this).next().focus();
        });
    });
</script>

<?php

$data["scripts"] = ob_get_contents();
ob_end_clean();

?>