<?php
ob_start();
?>
Benvenuto!
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            <strong>Nuovo su Loquio?</strong><br>
            Spendi 5 minuti per seguire la <b>guida</b> e scopri cosa puoi fare con Loquio.
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="span6">

    <div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title"> Azioni rapide </h4>
    </div>
        <div class="widget-body">
        <div class="widget-main">


        <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/"?> class="btn btn-app btn-info no-radius">
            <i class="ace-icon icon-edit-sign bigger-230"></i>
            Mie Pren.
        </a>
        <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/list"?> class="btn btn-app btn-primary no-radius">
            <i class="ace-icon icon-list-alt bigger-230"></i>
            Lista Pren.
        </a>
        <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/new"?> class="btn btn-app btn-success btn-primary no-radius">
            <i class="ace-icon icon-check bigger-230"></i>
            Pren. Matt.
        </a>
<?php
        if(ConfigLoader::getInstance()->getParam("pomeridianiActive")=="true"){
?>

        <a href="<?php echo Doo::conf()->APP_URL."pomeridiani/new"?>" class="btn btn-app btn-success btn-primary no-radius">
            <i class="icon-bullhorn"></i>
            <b>Pren. pom.</b>
        </a>
        <a href="<?php echo Doo::conf()->APP_URL."pomeridiani/"?>" class="btn btn-app btn-success btn-primary no-radius">
            <i class="icon-double-angle-right"></i>
            <b>I miei pom.</b>
        </a>
<?php
        }
?>

        </div>
        </div>
    </div>

</div>
<div class="span6">
    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h4>Come posso prenotare?</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row-fluid">
                    <div class="span12">
                        <ul class="unstyled spaced">
                            <li>
                                <i class="icon-circle green"></i>
                                Clicca sulla voce <b>"Prenota"</b> del men&uacute; laterale a sinistra
                            </li>
                            <li>
                                <i class="icon-circle green"></i>
                                Compila il form che apparir&aacute; inserendo il nome dello studente per cui si viene a
                                parlare, selezionando materia, docente e scegliendo un appuntamento tra i giorni disponibili.
                            </li>
                            <li>
                                <i class="icon-circle green"></i>
                                Ecco fatto! Ti arriver&aacute; una mail di conferma al tuo indirizzo email.
                            </li>
                            <li>
                                <i class="icon-star blue"></i>
                                Se vuoi conoscere l'ordine di prenotazione in cui verrai chiamato nel giorno del colloquio,
                                seleziona la voce <b>"Ordine prenotazione"</b> del men&uacute; laterale a sinistra.<br>
                                Dovrai inserire il giorno e il docente per cui hai prenotato e cliccare sul tasto <b>Invia</b>
                                e conoscerai l'ordine di prenotazione del giorno del colloquio.
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>