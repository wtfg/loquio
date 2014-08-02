<?php
$ul = Doo::conf()->APP_URL . "/global/";
ob_start();
?>
    <script src="<?php echo $ul?>js/docenti-add.js"></script>
    <script src="<?php echo $ul?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $ul?>assets/js/jquery.ui.touch-punch.min.js"></script>

<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Inserisci docente
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

<form id="add-docente" class="form-horizontal" name="login" method="post" action="">

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
        <label class="control-label" >E-Mail</label>

        <div class="controls">
            <input type="text"  name="email" id="email" placeholder="E-Mail">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Telefono</label>

        <div class="controls">
            <input type="text"  name="telefono" id="telefono" placeholder="Telefono">
        </div>
    </div>
    <div class="row-fluid">
        <label for="mid">Materia:</label>
        <select id="mid" name="mid">
            <?php
            foreach ($data['materie'] as $ad) {
                ?>
                <option value="<?php echo $ad['id']; ?>"><?php echo $ad['nome']; ?></option>
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
    <input type="hidden" name="orelibere" id="orelibere"  value='{}'/>
    <br /><br />
    <br />
    <button name="button" type="submit" class="btn btn-large btn-success">
        <i class="icon-ok bigger-150"></i>
        Invia
    </button>
    <br />
</form>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>