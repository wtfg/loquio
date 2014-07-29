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
    <h1>Visualizza Bookoffs</h1>

    <table width="80%" border="0">
  <tr>
    <th scope="col">Nome Docente</th>
    <th scope="col">Da</th>
    <th scope="col">A</th>
    <th scope="col">Modifica</th>
    <th scope="col">Elimina</th>
  </tr>
  <?php

foreach($data as $bookoff){
    
   
    
    $ur = Doo::conf()->APP_URL."admin/bookoff";
   // $bookoff["value"] = substr(str_replace(array("timeslot","\"","{","}","[","]"),"",$bookoff["value"]),1);
    echo "<tr>
    <td>".$bookoff["nome"]."&nbsp;</td>
    <td>".$bookoff["from"]."&nbsp;</td>
    <td>".$bookoff["to"]."&nbsp;</td>
    <td><a href=\"".$ur."/edit/".$bookoff["bookoffid"]."\">Modifica</a></td>
    <td><a href=\"".$ur."/delete/".$bookoff["bookoffid"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancellare il bookoff?');\">Elimina</a></td>
  </tr>";
    
    
}
?>
  
 
</table><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<a href="bookoff/new/" class="button">Aggiungi Bookoff</a>
</body>
</html>