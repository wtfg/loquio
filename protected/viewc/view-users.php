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
    <h1>Visualizza Utenti</h1>

    <table width="80%" border="0">
  <tr>
    <th scope="col">Nome</th>
    <th scope="col">Email</th>
    <th scope="col">Telefono</th>
    <th scope="col">Livello di accesso</th>
    <th scope="col">Modifica</th>
    <th scope="col">Elimina</th>
  </tr>
  <?php

foreach($data["utenti"] as $user){
    

    $aclr = $user["acl"] == 0 ? "Utente" : "";
    $aclr = $user["acl"] == 1 ? "Docente" : $aclr;
    $aclr = $user["acl"] == 2 ? "Amministratore" : $aclr;

    $ur = Doo::conf()->APP_URL."admin/utenti";
   // $bookoff["value"] = substr(str_replace(array("timeslot","\"","{","}","[","]"),"",$bookoff["value"]),1);
    echo "<tr>
    <td>".$user["nome"]. " ". $user["cognome"]."&nbsp;</td>
    <td>".$user["email"]."&nbsp;</td>
    <td>".$user["telefono"]."&nbsp;</td>
    <td>".$aclr."&nbsp;</td>
    <td><a href=\"".$ur."/edit/".$user["uid"]."\">Modifica</a></td>
    <td><a href=\"".$ur."/delete/".$user["uid"]."\" onclick=\"javascript:return confirm('Sei sicuro di voler cancellare l utente?');\">Elimina</a></td>
  </tr>";
    
    
}
?>
  
 
</table><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<a href="new/" class="button">Aggiungi utente</a>
</body>
</html>