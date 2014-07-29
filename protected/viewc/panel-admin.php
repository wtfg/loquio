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

<body style="text-align:center;">
    <h1>Ciao, di cosa ti vuoi occupare?</h1>
    
    <a href=<?php echo Doo::conf()->APP_URL."admin/docenti/"?> class="butt">Docenti</a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/prenotazioni/"?> class="butt">Prenotazioni</a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/materie"?> class="butt">Materie</a>
    <br>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/list"?> class="butt">Lista Prenotazioni</a>
    <a href=<?php echo Doo::conf()->APP_URL."prenotazioni/new"?> class="butt">Prenota Colloquio</a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/calendars"?> class="butt">Calendari</a>
    <br>
    <a href=<?php echo Doo::conf()->APP_URL."admin/cleardb"?> onclick="return confirm('Questo cancellera tutto il database! Sei sicuro??')" class="butt">Cancella DB</a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/bookoff"?> class="butt">Bookoff</a>
    <a href=<?php echo Doo::conf()->APP_URL."admin/config"?> class="butt">Configurazioni</a>
<a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
</body>
</html>

