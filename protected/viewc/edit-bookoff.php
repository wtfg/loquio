<?php
$data["title"] = "Modifica Bookoff";

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
                        <input type="hidden" name="did" id="did" value="<?php
                        echo $data['did'];
                        ?>" />

                <div class="widget-main">
                    <div class="row-fluid">
                        <label for="did">Docente: <?php
                            echo $data['name'];
                            ?></label>
                    </div>

                    <div class="row-fluid">
                        <label for="id-date-range-picker-1">Range di tempo</label>
                    </div>
                    <div class="control-group">
                        <div class="row-fluid input-prepend">
                            <span class="add-on">
                                <i class="icon-calendar"></i>
                            </span>
                            <input class="span10" type="text" value="<?php
                            echo $data['fromto'];
                            ?>" name="fromto" id="id-date-range-picker-1">
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

<!--ace scripts-->

<script src="<?php echo $ul;?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo $ul;?>assets/js/ace.min.js"></script>

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