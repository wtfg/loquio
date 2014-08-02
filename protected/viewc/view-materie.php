<?php

$data["title"] ="Visualizza Materie";

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Nome Materia</th>
        <th>Modifica</th>
        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
    <?php

    foreach($data["materie"] as $mat){



        $ur = Doo::conf()->APP_URL."admin/materie";

        echo "<tr>
    <td>".$mat["nome"]."&nbsp;</td>
    <td>
        <a href=\"".$ur."/edit/".$mat["mid"]."\">
            <button class=\"btn btn-mini btn-info\">
                <i class=\"icon-edit bigger-120\"></i>
            </button>
        </a>
    </td>
    <td>
            <a  href=\"".$ur."/delete/".$mat["mid"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancellare la materia?');\">
                <button class=\"btn btn-mini btn-danger\">
                    <i class=\"icon-trash bigger-120\"></i>
                </button>
            </a>
        </td>
    <td>
  </tr>";

    }
    ?>

    </tbody>
    </table>
    </div><!--/span-->
    </div>

    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/materie/new/" class="btn btn-app btn-success">
        <i class="icon-plus"></i>
        Aggiungi Materia
    </a>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>