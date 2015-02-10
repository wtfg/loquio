<?php
$a = new ConfigLoader(Doo::conf()->SITE_PATH . "global/config");
$data["title"] = "Modifica Prenotazione Pomeridiana";

$ul = Doo::conf()->APP_URL . "global/";

ob_start();
?>
    <script src='<?php echo $ul; ?>js/validate.js'></script>
<?php
$data['head'] = ob_get_contents();
ob_end_clean();
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
                <h4>Pomeridiano:</h4>


            </div>

            <div class="widget-body">

                <form method="post" id="pomeridiano" name="pomeridiano" action="">
                    <div class="widget-main">
                        <div class="control-group">
                            <label class="control-label" >Nome</label>
                            <div class="controls">
                                <input type="text"  name="nome" id="nome" placeholder="Nome" value="<?php echo $data['nome']; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" >Cognome</label>

                            <div class="controls">
                                <input type="text"  name="cognome" id="cognnome" placeholder="Cognome" value="<?php echo $data['cognome']; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" >Classe</label>

                            <div class="controls">
                                <input type="text"  name="classe" id="classe" placeholder="Classe" value="<?php echo $data['classe']; ?>">
                            </div>
                        </div>
                        <input type="hidden" name="did" id="did" value="<?php
                        echo $data['did'];
                        ?>" />

                <div class="widget-main">
                    <div class="row-fluid">
                        <label for="did">Docente: <?php
                            echo $data['docente'];
                            ?></label>
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

    <script>
        var v = new FormValidator("pomeridiano",
            [
                {
                    name: "nome",
                    display: "Nome",
                    rules: "required"
                }, {
                name: "cognome",
                display: "Cognome",
                rules: "required"
            },{
                name: "classe",
                display: "Classe",
                rules: "valid_class|required"
            }
            ],
            function(errors, event){
                if(errors.length > 0){
                    msg="";
                    for(er in errors){
                        msg += errors[er].message+"\n";

                    }
                    alert(msg);
                }
            }
        );
    </script>
<?php

$data["scripts"] = ob_get_contents();
ob_end_clean();

?>