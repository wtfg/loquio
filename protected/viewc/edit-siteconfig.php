<?php
$ul = Doo::conf()->APP_URL . "/global/";
$params = $data['config'];
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
    <h1>Configurazioni</h1>
    <h2>
        <?php echo $data['message']; ?>
    </h2>
    <form id="edit-materia" name="login" method="post" action="">
        <h2>Giorni di visibilit&aacute;:</h2>
        <input type="text" name="lookAheadTime" id="lookAheadTime" value="<?php
  echo $params->getParam("lookAheadTime"); ?>"/>
        
  <br />
  <br />
      
  <input type="submit" name="cfg" id="cfg" value="Invia" />
      
      
    </form>
<br><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="<?php echo Doo::conf()->APP_URL;?>">&Lt;</a>

</body>
</html>


