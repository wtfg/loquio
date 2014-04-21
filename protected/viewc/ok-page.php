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
<meta http-equiv="refresh" content="3;URL=<?php echo $data['url'];?>">
<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>

<body style="width:20%;">
    <h1><?php echo $data['titolo'];?></h1>
    <p>
        <?php
        echo $data['messaggio'];
        ?>
        
    </p>

</body>
</html>

