<?php

$data["title"] ="Visualizza Pomeridiani";

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
        <th>#</th>
        <th>UserId</th>
        <th>Email Utente</th>
        <th>Docente</th>
        <th>Materia</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Classe</th>
        <th>Modifica</th>
        <th>Elimina</th>
    </tr>
    </thead>

    <tbody>
    <?php


    foreach ($data["pomeridiani"] as $pom) {
        $ur = Doo::conf()->APP_URL . "pomeridiani";

        echo "
    <tr>
    <td>
    ".$pom["pomid"]."&nbsp;
    </td>
     <td>
            ".$pom["uid"]."&nbsp;
        </td>
        <td>
            ".$pom["email"]."&nbsp;
        </td>
        <td>
            ".$pom["docente"]."&nbsp;
        </td>
        <td>
            ".$pom["nomemateria"]."&nbsp;
        </td>
        <td>
            ".$pom["nome"]."&nbsp;
        </td>
        <td>
            ".$pom["cognome"]."&nbsp;
        </td>
        <td>
            ".$pom["classe"]."&nbsp;
        </td>
        <td>
            <a href=\"".$ur."/edit/".$pom["pomid"]."\">
                <button class=\"btn btn-mini btn-info\">
                    <i class=\"icon-edit bigger-120\"></i>
                </button>
            </a>
        </td>
        <td>
            <a  href=\"".$ur."/delete/".$pom["pomid"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancellare la tua prenotazione del colloquio pomeridiano?');\">
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
    <a href="<?php echo Doo::conf()->APP_URL; ?>admin/filter" class="btn btn-app btn-success">
        <i class="icon-cloud-download"></i>
        Filtra
    </a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>pomeridiani/new/" class="btn btn-app btn-primary">
        <i class="icon-plus"></i>
        Prenota
    </a>
    <a onclick="javascript: return confirm('Sei sicuro di voler svuotare tutti i pomeridiani?');" href="<?php echo Doo::conf()->APP_URL; ?>admin/pomeridiani/deleteall" class="btn btn-app btn-danger">
        <i class="icon-trash"></i>
        Svuota
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
                    null,null,null, null,null,null,null,null,{ "bSortable": false },{ "bSortable": false }
                ] } );
        })
    </script>
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>