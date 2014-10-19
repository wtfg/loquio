<?php

$data["title"] = "Le tue Prenotazioni";

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Data Pren.</th>
        <th>Materia</th>
        <th>Studente</th>
        <th>Classe</th>
        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
<?php

foreach($data["prenotazioni"] as $d){


    $ur = Doo::conf()->APP_URL."prenotazioni";
    // $bookoff["value"] = substr(str_replace(array("timeslot","\"","{","}","[","]"),"",$bookoff["value"]),1);
    echo "
    <tr>
        <td>".$d["nome_docente"]."&nbsp;</td>
        <td>".$d["data"]."&nbsp;</td>
        <td>".$d["materia"]."&nbsp;</td>
        <td>".$d["studente"]."&nbsp;</td>
        <td>".$d["classe"]."&nbsp;</td>
        <td>
            <a href=\"".$ur."/del/".$d["codice_canc"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancrllare la prenotazione?');\">
                <button class=\"btn btn-mini btn-danger\">
                    <i class=\"icon-trash bigger-120\"></i>
                </button>
            </a>
        </td>
   </tr>";

}
    ?>

    </tbody>
    </table>
    </div><!--/span-->
    </div>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();

if($_SESSION["user"]["acl"]=="admin"){

    ?>
    <script type="text/javascript">
        location.href = "<?php echo Doo::conf()->APP_URL; ?>admin/prenotazioni"
    </script>
    <?php
}
?>
    <script src="<?php echo Doo::conf()->APP_URL; ?>global/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo Doo::conf()->APP_URL; ?>global/assets/js/jquery.dataTables.bootstrap.js"></script>

    <script type="text/javascript">
        $(function() {
            var oTable1 = $('#sample-table-1').dataTable( {
                "aoColumns": [
                    null, null, null, null,null,{ "bSortable": false }
                ] } );
        })
    </script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>