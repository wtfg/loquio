<?php

$data["title"] ="Visualizza Docenti";

ob_start();
?>
<!--
    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>

											<th>Domain</th>


											<th class="hidden-phone">
												<i class="icon-time bigger-110 hidden-phone"></i>
												Update
											</th>
											<th class="hidden-480">Status</th>

										</tr>
									</thead>

									<tbody>
										<tr>

											<td>
												<a href="#">app.com</a>
											</td>
											<td class="hidden-phone">Feb 12</td>

											<td class="hidden-480">
												<span class="label label-warning">Expiring</span>
											</td>

										</tr>
									</tbody>
								</table>

    -->
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
        $ur = Doo::conf()->APP_URL . "admin/docenti";
        $attivo = ($doc["attivo"] == 1) ? $ok : $nonok;
        $attivo2 = ($doc["attivo"] == 1) ? "btn-success" : "btn-danger";
        $lnk =  ($doc["attivo"] == 1) ? "<a href=\"".$ur."/deactivate/".$doc["did"]."\">" : "<a href=\"".$ur."/activate/".$doc["did"]."\">"; #$doc["did"]
        $thecontent = $lnk.'
        <button class="btn btn-mini '.$attivo2.'">
            <i class="'.$attivo.'"></i>
        </button></a>';


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
            <a  href=\"".$ur."/delete/".$doc["did"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancellare il docente?');\">
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
    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/docenti/new/" class="btn btn-app btn-success">
        <i class="icon-plus"></i>
        Aggiungi Docente
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
                    null,  { "bSortable": false },null,
                    { "bSortable": false },{ "bSortable": false },{ "bSortable": false }
                ] } );
        })
    </script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>