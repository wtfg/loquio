<?php

$data["title"] ="Visualizza Bookoffs";

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Nome Docente</th>
        <th>Da</th>
        <th>A</th>

        <th>Modifica</th>

        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
<?php

foreach($data["bookoffs"] as $bookoff){
    //var_dump($data);
    //bookoff nome from to bookggid


    $ur = Doo::conf()->APP_URL."admin/bookoff";
    // $bookoff["value"] = substr(str_replace(array("timeslot","\"","{","}","[","]"),"",$bookoff["value"]),1);
    echo "
    <tr>
        <td>
            ".$bookoff["nome"]."&nbsp;
        </td>
        <td>
            ".$bookoff["from"]."&nbsp;
        </td>
        <td>
            ".$bookoff["to"]."&nbsp;
        </td>
        <td>
            <a href=\"".$ur."/edit/".$bookoff["bookoffid"]."\">
                <button class=\"btn btn-mini btn-info\">
                    <i class=\"icon-edit bigger-120\"></i>
                </button>
            </a>
        </td>
        <td>
            <a href=\"".$ur."/delete/".$bookoff["bookoffid"]."\">
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
    <br>
    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/bookoff/new/" class="btn btn-app btn-success">
        <i class="icon-plus"></i>
        Aggiungi Bookoff
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
                    null, null, null,{ "bSortable": false },{ "bSortable": false }
                ] } );
        })
    </script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>