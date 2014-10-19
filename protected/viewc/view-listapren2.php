<?php

$data['data'] = date("d-m-Y",strtotime($data['data']));

$data["title"] ="Ordine di prenotazione per ".$data['docente']." nel giorno ".$data['data'];

ob_start();
?>

    <div class="row-fluid">
    <div class="span12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>N</th>
        <th>Studente</th>
        <th>Classe</th>
    </tr>
    </thead>

    <tbody>
    <?php
$i=1;
foreach($data['prens'] as $d){


    echo "<tr>
    <td>".$i."&nbsp;</td>
    <td>".$d->studente."&nbsp;</td>
    <td>".$d->classe."</td>

  </tr>";

    $i++;
}
?>


    </tbody>
    </table>
    </div><!--/span-->
    </div>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>
