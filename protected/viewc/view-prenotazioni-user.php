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
    <h1>Le Tue Prenotazioni</h1>
<table width="80%" border="0">
  <tr>
    <th scope="col">Docente</th>
    <th scope="col">Data Pren.</th>
    <th scope="col">Materia</th>
    <th scope="col">Studente</th>
    <th scope="col">Elimina</th>
  </tr>
  <?php

foreach($data as $d){
    
    
    $ur = Doo::conf()->APP_URL."prenotazioni";
    
    echo "<tr>
    <td>".$d["nomedocente"]."&nbsp;</td>
    <td>".$d["data"]."&nbsp;</td>
    <td>".$d["materia"]."&nbsp;</td>
    <td>".$d["studente"]."&nbsp;</td>
    <td><a href=\"".$ur."/del/".$d["codicecanc"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancrllare la prenotazione?');\">Elimina</a></td>
  </tr>";
    
    
}
?>
  
 
</table><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<a href="new/" class="button">Aggiungi Prenotazione</a>
</body>
</html>