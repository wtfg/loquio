<?php
$ul = Doo::conf()->APP_URL . "/global/";

ob_start();
?>
        <script src='<?php echo $ul; ?>fc/lib/jquery.min.js'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $ul; ?>css/datepickr.css" />
        <script src="<?php echo $ul; ?>js/bookoffs.js"></script>
<?php
$data['head'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Modifica Bookoff
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

        <form id="edit-bookoff" name="login" method="post" action="">
            <h2>Docente: <?php
                echo $data['name'];
                ?> </h2>
            <p>
                <input type="hidden" name="did" id="did" value="<?php
                echo $data['did'];
                ?>" />
            </p>
            <h2>Data</h2>
            <p>
            <input type="text" name="date" id="date"  value="<?php
                   echo $data['date'];
            ?>"/>
            </p>

            <div id="container"></div>
            <br/>
            <input type="hidden" name="value" id="value"  value='<?php
echo $data['value'];
?>'/>

            <script type="text/javascript" src="<?php echo $ul; ?>js/datepickr.min.js"></script>
            <script type="text/javascript">

                new datepickr('date', {
                    dateFormat: 'd-m-Y', /* need to double escape characters that you don't want formatted */
                    weekdays: ['Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'],
                    months: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    defaultSuffix: '' /* the suffix that is used if nothing matches the suffix object, default 'th' */
                });
            </script>
            <input type="submit" name="button" id="button" value="Invia" />
            <br />
        </form>
        <br><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
            <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>