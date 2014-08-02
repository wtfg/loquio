<?php

$data["title"] ="Visualizza Docenti";

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Nome Docente</th>
        <th>Attivo</th>
        <th>Materia</th>
        <th>Modifica</th>
        <th>Imprevisto</th>
        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $ok = "icon-ok";
    $nonok = "icon-remove";

    foreach ($data["docenti"] as $doc) {

        $attivo = ($doc["attivo"] == 1) ? $ok : $nonok;
        $attivo2 = ($doc["attivo"] == 1) ? "btn-success" : "btn-danger";

        $thecontent = '
        <button class="btn btn-mini '.$attivo2.'">
            <i class="'.$attivo.'"></i>
        </button>';

        $ur = Doo::conf()->APP_URL . "admin/docenti";
        echo "
    <tr>
        <td>
            ".$doc["viewnome"]."&nbsp;
        </td>
        <td>
            ".$thecontent."&nbsp;
        </td>
        <td>
            ".$doc["nomemateria"]."&nbsp;
        </td>
        <td>
            <a href=\"".$ur."/edit/".$doc["did"]."\">
                <button class=\"btn btn-mini btn-info\">
                    <i class=\"icon-edit bigger-120\"></i>
                </button>
            </a>
        </td>
        <td>
            <a href=\"" . Doo::conf()->APP_URL . "snag/" . $doc["did"] . "\">
                <button class=\"btn btn-mini btn-info\">
                    <i class=\"icon-info-sign bigger-120\"></i>
                </button>
            </a>
        </td>
        <td>
            <a  href=\"".$ur."/delete/".$doc["did"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancrllare il docente?');\">
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

    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/docenti/new/" class="btn btn-app btn-success">
        <i class="icon-plus"></i>
        Aggiungi Docente
    </a>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>