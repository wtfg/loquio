<?php
ob_start();
?>
    Loquio Dashboard
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


    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-edit-sign bigger-230"></i>
        Mie Pren.
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/list"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-list-alt bigger-230"></i>
        Lista Pren.
    </a>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/new"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-check bigger-230"></i>
        Prenota
    </a>



    </div>
    </div>
</div>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>