<?php
/**
 * APRE ZIP
 * INSERISCE QUERY
 * CANCELLA
 * data.zip
 * configs.txt
 * pclzip.lib.php
 * rrmdir.php
 * loquio.sql
 * se stesso
 */

require_once('rrmdir.php');

/*
rrmdir("dooframework");
rrmdir("global");
rrmdir("protected");
*/

$file = file_get_contents("configs.txt");
$configpath = "protected/config/db.conf.php";


$replaces = array(
    "ip"=>array('###_IP_ADDRESS_###', ""),
    "db"=>array('###_DB_NAME_###', ""),
    "un"=>array('###_USER_NAME_###', ""),
    "pw"=>array('###_PASSWORD_###', "")
);
$files = array("configs.txt", "rrmdir.php", "loquio.sql", __FILE__);
$scriptpath = dirname(__FILE__);
$message = "";

if(isset($_POST["address"])){
    $replaces["ip"][1] = $_POST["address"];
    $replaces["db"][1] = $_POST["dbname"];
    $replaces["un"][1] = $_POST["username"];
    $replaces["pw"][1] = $_POST["pass"];

    foreach($replaces as $replace)
        $file = str_replace($replace[0], $replace[1], $file);

    if(file_put_contents($configpath, $file) !== FALSE){

        query($_POST["address"], $_POST["username"], $_POST["pass"], $_POST["dbname"], "loquio.sql");

        foreach($files as $filepath){
            if($filepath == __FILE__)
                echo <<<HTML
<h4>Tutto OK!</h4>
Le tue credenziali di accesso iniziali sono
 <p>
    <b>Email</b>: admin@loquio.it <br>
    <b>Password</b>: test
 </p>
 Ti consigliamo di cambiarla!
HTML;
            unlink($filepath);
        }


    }

    //
    die();

}
?>
<!DOCTYPE HTML>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Prima installazione Loquio</title>
</head>
<body>

<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <?php echo "$message"; ?>
            <h3>
                Prima installazione Loquio
            </h3>
            <form method="post" action="" role="form">
                <div class="form-group">
                    <label for="address">Indirizzo IP</label>
                    <input type="text" class="form-control" name="address">
                </div>
                <div class="form-group">
                    <label for="address">Nome Database</label>
                    <input type="text" class="form-control" name="dbname">
                </div>
                <div class="form-group">
                    <label for="address">Nome utente</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    <label for="address">Password</label>
                    <input type="password" class="form-control" name="pass">
                </div>
                 <button type="submit" class="btn btn-default">Invia</button>
            </form>
        </div>
    </div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>
</html>