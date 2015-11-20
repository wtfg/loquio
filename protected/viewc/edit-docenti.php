<?php
$ul = Doo::conf()->APP_URL . "/global/";
ob_start();
?>
    <script src="<?php echo $ul?>js/docenti.min.js"></script>
    <script src="<?php echo $ul?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $ul?>assets/js/jquery.ui.touch-punch.min.js"></script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Modifica docente
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

<form id="add-docente" class="form-horizontal" name="login" method="post" action="">
    <input type="hidden" name="did" id="did" value="<?php
    echo $data['did'];
    ?>">
    <div class="control-group">
        <label class="control-label" >Nome</label>

        <div class="controls">
            <input type="text"  name="nome" id="nome" value="<?php
            echo $data['nome'];
            ?>" placeholder="Nome">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Cognome</label>

        <div class="controls">
            <input type="text"  name="cognome" id="cognome" value="<?php
            echo $data['cognome'];
            ?>" placeholder="Cognome">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >E-Mail</label>

        <div class="controls">
            <input type="text"  name="email" value="<?php
            echo $data['email'];
            ?>" id="email" placeholder="E-Mail">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Telefono</label>

        <div class="controls">
            <input type="text" value="<?php
            echo $data['telefono'];
            ?>" name="telefono" id="telefono" placeholder="Telefono">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Numero Massimo di Prenotazioni Pomerdiane</label>

        <div class="controls">
            <input type="text" value="<?php
            echo $data['maxpomeridiani'];
            ?>" name="maxpomeridiani" id="maxpomeridiani" placeholder="Max">
        </div>
    </div>
    <div class="row-fluid">
        <label for="mid">Materia:</label>
        <select id="mid" name="mid">
            <?php
            foreach ($data['materie'] as $ad) {
                $sel = ($ad['id'] == $data['mid']) ? "selected=\"selected\"" : "";
                ?>
                <option value="<?php echo $ad['id']; ?>" <?php echo $sel ?> ><?php echo $ad['nome']; ?></option>
            <?php
            }
            ?>

        </select>

    </div>

    <br>
    <h3 class="header smaller lighter blue">
        Seleziona giorni e ore di ricevimento
        <small>Devi inoltre selezionare il numero massimo di prenotazioni a giorno</small>
    </h3>
    <div id="container"></div>
    <br/>
    <input type="hidden" name="orelibere" id="orelibere"  value='<?php
    echo $data['orelibere'];
    ?>'/>

    <label>
    <input type="checkbox" name="attivo" id="attivo" value="1"
        <?php
        echo $data['attivo'];
        ?>>
    <span class="lbl">Attivo?</span>
    </label>
    <br />
    <button name="button" type="submit" class="btn btn-large btn-success">
        <i class="icon-ok bigger-150"></i>
        Invia
    </button>
    <br />
</form>
<script src='<?php echo $ul; ?>js/validate.js'></script>
<!--inline scripts related to this page-->
<script>
    var v = new FormValidator("login",
        [
            {
                name: "nome",
                display: "Nome",
                rules: "required"
            },{
            name: "cognome",
            display: "Cognome",
            rules: "required"
        },{
            name: "email",
            display: "Email",
            rules: "valid_email|required"
        },{
            name: "maxpomeridiani",
            display: "Max Pomeridiani",
            rules: "numeric|required"
        },{
            name: "telefono",
            display: "Telefono"
        }],function(errors, event){
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
$data['content'] = ob_get_contents();
ob_end_clean();
?>