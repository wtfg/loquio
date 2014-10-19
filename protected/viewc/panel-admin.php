<?php
ob_start();
?>
Benvenuto, grande capo!
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

<div class="widget-box">
<div class="widget-header">
    <h4 class="widget-title"> Azioni rapide </h4>
</div>
    <div class="widget-body">
    <div class="widget-main">

    <a href=<?php echo Doo::conf()->APP_URL."admin/docenti/"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon fa icon-group bigger-230"></i>
        Docenti
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/prenotazioni/"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-edit-sign bigger-230"></i>
        Prenotaz.
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/materie"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-list bigger-230"></i>
        Materie
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/list"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-list-alt bigger-230"></i>
        Lista Pren.
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/new"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-check bigger-230"></i>
        Prenota
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/calendars"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-calendar bigger-230"></i>
        Calendari
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/utenti"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-user bigger-230"></i>
        Utenti
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/bookoff"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-eraser bigger-230"></i>
        Bookoff
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/config"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-cogs bigger-230"></i>
        Configuraz.
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/cleardb"?> onclick="return confirm('Questo cancellera tutto il database! Sei sicuro??')" class="btn btn-danger btn-app radius-4">
        <i class="ace-icon icon-trash bigger-230"></i>
    Canc. DB
        </a>


    </div>    </div>
</div>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>