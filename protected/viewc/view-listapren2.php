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
    <h1>Lista Prenotazioni</h1>

Prenotazioni per <?php echo $data['docente']?> nel giorno <?php echo $data['data']?>
<br>
<table width="80%" border="0">
  <tr>
    <th scope="col">N</th>
    <th scope="col">Studente</th>
  </tr>
  <?php
$i=1;
foreach($data['prens'] as $d){

    
    echo "<tr>
    <td>".$i."&nbsp;</td>
    <td>".$d->studente." ".$d->classe."&nbsp;</td>

  </tr>";
    
    $i++;
}
?>
  
 
</table><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

</body>
</html>