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

<body style="width:20%;text-align:center;">
    <h1>Accedi</h1>
    
    <form id="login" name="login" method="post" action="index.php/login/">
      
           
      <h2>Email</h2>
      <p>
      <input type="text" name="email" id="email" />
      </p>
      <h2>Password</h2>
      <p>
      <input type="password" name="pass" id="pass" />
      </p>
      <br />
      <input type="submit" name="button" id="button" value="Invia" />
    <br /><br />
    <p>
        <a style='font-size:14px;' href="register">Non sei ancora iscritto? Registrati!</a>
    </p>
    </form>

</body>
</html>

