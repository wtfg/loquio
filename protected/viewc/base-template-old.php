<?php
$ul = Doo::conf()->APP_URL . "global/";
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

        <script src='<?php echo $ul; ?>fc/lib/jquery.min.js'></script>
        <?php
        if(array_key_exists('head', $data)) echo $data['head'];
        ?>
    </head>

    <body>
        <h1><?php if(array_key_exists('title', $data)) echo $data['title']; ?></h1>

        <?php
        if(array_key_exists('content', $data)) echo $data['content'];
        ?>

        <br><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
            <a class='back' href="javascript:history.go(-1);">&Lt;</a>

    </body>
</html>