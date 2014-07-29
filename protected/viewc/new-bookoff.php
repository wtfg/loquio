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
Nuovo Bookoff
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

        <form id="new-bookoff" name="login" method="post" action="">
            <h2>Docente:</h2>
            <p>
               <select name="did" id="did">
                   <?php
                   foreach($data["docenti"] as $docente){
                       ?>
                       <option value="<?php echo $docente["did"]?>"><?php echo $docente["nomecognome"]?></option>
                   <?php
                   }
            ?>
               </select>
            </p>
            <h2>Dal giorno</h2>
            <p>
            <input type="text" name="from" id="from"  value=""/>
            </p>

            <h2>Al giorno</h2>
            <p>
                <input type="text" name="to" id="to"  value=""/>
            </p>

            <script type="text/javascript" src="<?php echo $ul; ?>js/datepickr.min.js"></script>
            <script type="text/javascript">

                new datepickr('from', {
                    dateFormat: 'd-m-Y', /* need to double escape characters that you don't want formatted */
                    weekdays: ['Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'],
                    months: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    defaultSuffix: '' /* the suffix that is used if nothing matches the suffix object, default 'th' */
                });
                new datepickr('to', {
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