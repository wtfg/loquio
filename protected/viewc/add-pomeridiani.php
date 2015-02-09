<?php
$a = new ConfigLoader(Doo::conf()->SITE_PATH . "global/config");
$data["title"] = $a->getParam("pomeridianiTitle");

$ul = Doo::conf()->APP_URL . "global/";


ob_start();
?>


    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <strong>
            <?php echo $a->getParam("pomeridianiMessage"); ?>
        </strong>
    </div>
    <div class="span4">
        <div class="widget-box">
            <div class="widget-header">
                <h4>Pomeridiani:</h4>


            </div>

            <div class="widget-body">

                <form method="post" name="view-lista" action="">

                <div class="widget-main">
                    <div class="control-group">
                        <label class="control-label" >Nome</label>
                        <div class="controls">
                            <input type="text"  name="nome" id="nome" placeholder="Nome">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" >Cognome</label>

                        <div class="controls">
                            <input type="text"  name="cognome" id="cognome" placeholder="Cognome">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" >Classe</label>

                        <div class="controls">
                            <input type="text"  name="classe" id="classe" placeholder="Classe">
                        </div>
                    </div>
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