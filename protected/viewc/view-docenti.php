<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> </title>
<link rel="stylesheet" media="screen" href="<?php echo $ul; ?>css/style.css" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>

<body>
    <h1>Visualizza Docenti</h1>

<table width="80%" border="0">
    <tr>
        <th scope="col">Nome Docente</th>
        <th scope="col">Attivo</th>
        <th scope="col">Materia</th>
        <th scope="col">Modifica</th>
        <th scope="col">Elimina</th>
    </tr>
    <?php
    $ok = "v";
    $nonok = "x";
    
    foreach ($data as $doc) {

        $attivo = ($doc["attivo"] == 1) ? $ok : $nonok;
        
        $ur = Doo::conf()->APP_URL . "admin/docenti";

        echo "<tr>
    <td>" . $doc["viewnome"] . "&nbsp;</td>
    <td class=\"active-" . $attivo . "\">" . $attivo . "&nbsp;</td>
    <td>" . $doc["nomemateria"] . "&nbsp;</td>
    <td><a href=\"" . $ur . "/edit/" . $doc["did"] . "\">Modifica</a></td>
    <td><a href=\"" . $ur . "/delete/" . $doc["did"] . "\" onclick=\"javascript:return confirm('Sei sicuro di voler cancrllare il docente?');\">Elimina</a></td>
  </tr>";
    }
    ?>


</table>
    <a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<a href="new/" class="button">Aggiungi Docente</a>
</body>
</html>