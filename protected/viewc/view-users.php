<?php

$data["title"] ="Visualizza Utenti";

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefono</th>

        <th>
            <i class="icon-time bigger-110 hidden-phone"></i>
            Livello Di accesso
        </th>
        <th>Modifica</th>

        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
<?php

foreach($data["utenti"] as $user){


    $aclr = $user["acl"] == 0 ? "Utente" : "";
    $aclr = $user["acl"] == 1 ? "Docente" : $aclr;
    $aclr = $user["acl"] == 2 ? "Amministratore" : $aclr;

    $ur = Doo::conf()->APP_URL."admin/utenti";
    // $bookoff["value"] = substr(str_replace(array("timeslot","\"","{","}","[","]"),"",$bookoff["value"]),1);
    echo "
    <tr>
        <td>
            ".$user["cognome"]. " ". $user["nome"]."&nbsp;
        </td>
        <td>
            ".$user["email"]."&nbsp;
        </td>
        <td>
            ".$user["telefono"]."&nbsp;
        </td>
        <td>
            ".$aclr."&nbsp;
        </td>
        <td>
            <a href=\"".$ur."/edit/".$user["uid"]."\">
                <button class=\"btn btn-mini btn-info\">
                    <i class=\"icon-edit bigger-120\"></i>
                </button>
            </a>
        </td>
        <td>
            <a href=\"".$ur."/delete/".$user["uid"]."\">
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

    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/utenti/new/" class="btn btn-app btn-success">
        <i class="icon-plus"></i>
        Aggiungi Utente
    </a>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
    <script src="<?php echo Doo::conf()->APP_URL; ?>global/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo Doo::conf()->APP_URL; ?>global/assets/js/jquery.dataTables.bootstrap.js"></script>

    <script type="text/javascript">
        $(function() {
            var oTable1 = $('#sample-table-1').dataTable( {
                "aoColumns": [
                    null, null, null, null, { "bSortable": false },
                    { "bSortable": false }
                ] } );
        })
    </script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>