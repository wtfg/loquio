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

        <script src='<?php echo $ul; ?>fc/lib/jquery.min.js'></script>
        
        <script src="<?php echo $ul; ?>js/docenti.js"></script>
    </head>
    <body>

        <h1>Modifica docente</h1>

        <form id="add-docente" name="login" method="post" action="">
            <h2>Nome</h2>
            <p>
            <input type="hidden" name="did" id="did" value="<?php
            echo $data['did'];
            ?>">
            <input type="text" name="nome" id="nome" value="<?php
                   echo $data['nome'];
            ?>" />
            </p>
            <h2>Cognome</h2>
            <p>
            <input type="text" name="cognome" id="cognome"  value="<?php
                   echo $data['cognome'];
            ?>"/>
            </p>
            <h2>Email</h2>
            <p>
            <input type="text" name="email" id="email"  value="<?php
                   echo $data['email'];
            ?>"/>
            </p>
            <h2>Telefono</h2>
            <p>
            <input type="text" name="telefono" id="telefono"  value="<?php
                echo $data['telefono'];
                ?>"/>
            </p>
            <h2>Materia</h2>
            <p>
            <select id="mid" name="mid">
<?php
foreach ($data['materie'] as $ad) {
    if ($ad['id'] == $data['mid']) {
        $sel = "selected=\"selected\"";
    } else {
        $sel = "";
    }
    ?>

                    <option value="<?php echo $ad['id']; ?>" <?php echo $sel ?> ><?php echo $ad['nome']; ?></option>
    <?php
}
?>

            </select>

            </p>
            

            <div id="container"></div>
            <br/>
            <input type="hidden" name="orelibere" id="orelibere"  value='<?php
echo $data['orelibere'];
?>'/>
      
            <h2>Attivo:</h2>
            <input type="checkbox" name="attivo" id="attivo" value="1"
<?php
echo $data['attivo'];
?>> 
            <br />
                  <br />
            <input type="submit" name="button" id="button" value="Invia" />
            <br />
        </form>
        <br><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
            <a class='back' href="javascript:history.go(-1);">&Lt;</a>

    </body>
</html>
