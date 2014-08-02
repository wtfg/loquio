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
    <h1>Ciao, cosa vuoi fare?</h1>
    
    <a href="prenotazioni/new" class="butt"> Prenota Colloquio</a>
    <a href="prenotazioni/" class="butt">Le Mie Prenotazioni</a>
    <a href="prenotazioni/list" class="butt">Liste Prenotazioni</a>
<a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
</body>
</html>

