<?php
/**
 * 1st install
 */

// imports and defines we need
require_once('rrmdir.php');
define("CONFIGPATH", "protected/config/db.conf.php");
define("ALRIGHT", "<h4>Tutto OK!</h4>Le tue credenziali di accesso iniziali sono<p><b>Email</b>:admin@loquio.it <br>
<b>Password</b>: test</p>Ti consigliamo di cambiarla!");


// if we have postdata...
if (isset($_POST["address"])) {

    // list of files to delete
    $files = array("configs.txt", "rrmdir.php", "loquio.sql", __FILE__);

    // insert the data to the configuration file (CONFIGPATH)
    $file_content = str_replace(
        array('###_IP_ADDRESS_###', '###_DB_NAME_###', '###_USER_NAME_###', '###_PASSWORD_###'),
        array_map("trim", array($_POST["address"], $_POST["dbname"], $_POST["username"], $_POST["pass"])),
        file_get_contents("configs.txt")
    );

    // if succeeded to change the configuration
    if (file_put_contents(CONFIGPATH, $file_content) !== FALSE) {
        // put sql
        query($_POST["address"], $_POST["username"], $_POST["pass"], $_POST["dbname"], "loquio.sql");
        // delete all files
        foreach ($files as $f) {
            if ($f == __FILE__) echo ALRIGHT;
            unlink($f);
        }
    }
    //
    die();
}

?>

<!DOCTYPE HTML><html><head><link href=//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css rel=stylesheet><title>Prima installazione Loquio</title></head><body><div class=container><div class="row clearfix"><div class="col-md-12 column"><h3>Prima installazione Loquio</h3><form method=post action role=form><div class=form-group><label for=address>Indirizzo IP</label><input type=text class=form-control name=address></div><div class=form-group><label for=address>Nome Database</label><input type=text class=form-control name=dbname></div><div class=form-group><label for=address>Nome utente</label><input type=text class=form-control name=username></div><div class=form-group><label for=address>Password</label><input type=password class=form-control name=pass></div><button type=submit class="btn btn-default">Invia</button></form></div></div></div><script src=//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js></script></body></html>