<?php

$message = $data['message'] != "" ? "<p class=\"alert alert-success\">".$data['message']."</p>" : "";

$params = $data['config'];
ob_start();
?>
Modifica Configurazioni
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php echo $message; ?>
    <form id="edit-siteconfig" name="login" method="post" action="">
        <label for="lookAheadTime">Distanza in giorni di visibilit&aacute;</label>

        <input type="text" name="lookAheadTime" id="lookAheadTime" value="<?php
        echo $params->getParam("lookAheadTime"); ?>"/>
        <br><br>
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