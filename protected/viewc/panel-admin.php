<?php
$b = $this->db()->find(Doo::loadModel("prenotazioni", true), array("where"=>"data>=".time()));

$data["overall_prenotazioni_num"] = Doo::loadModel("prenotazioni", true)->count();
$data["new_prenotazioni_num"] = count($b);
$data['prenotazioni_percentage_num'] = ((count($b)/Doo::loadModel("prenotazioni", true)->count())*100)."%";

$data["docenti_num"] = Doo::loadModel("docenti", true)->count();

$data["utenti_num"] = Doo::loadModel("utenti", true)->count();


ob_start();
?>
Benvenuto, grande capo!
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
    <div class="col-sm-7 infobox-container">
        <div class="infobox infobox-green">
            <div class="infobox-icon">
                <i class="ace-icon fa icon-twitter"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $data['docenti_num']?></span>
                <div class="infobox-content">docenti inseriti</div>
            </div>
        </div>

        <div class="infobox infobox-blue">
            <div class="infobox-icon">
                <i class="ace-icon fa icon-comments"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $data['new_prenotazioni_num']?></span>
                <div class="infobox-content">prenotazioni nuove</div>
            </div>
            <div class="stat stat-success">
                <?php echo $data['prenotazioni_percentage_num']?>

            </div>
        </div>
        <div class="infobox infobox-blue">
            <div class="infobox-icon">
                <i class="ace-icon fa icon-key"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $data['overall_prenotazioni_num']?></span>
                <div class="infobox-content">prenotazoni totali</div>
            </div>
        </div>
        <div class="infobox infobox-pink">
            <div class="infobox-icon">
                <i class="ace-icon fa icon-shopping-cart"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $data['utenti_num']?></span>
                <div class="infobox-content">utenti in totale</div>
            </div>
        </div>


    </div>

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
    <a href=<?php echo Doo::conf()->APP_URL."admin/pomeridiani"?> class="btn btn-app btn-primary no-radius">
        <i class="ace-icon icon-user bigger-230"></i>
        Pomeridiani
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