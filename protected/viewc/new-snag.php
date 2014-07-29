<?php
$ul = Doo::conf()->APP_URL . "/global/";

ob_start();
?>
        <script src='<?php echo $ul; ?>fc/lib/jquery.min.js'></script>
        <script src='<?php echo $ul; ?>js/validate.js'></script>

        <link rel="stylesheet" type="text/css" href="<?php echo $ul; ?>css/datepickr.css" />
<?php
$data['head'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Imprevisto!
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

        <form id="new-bookoff" name="new-bookoff" method="post" action="">
            <h2>Docente: <?php
                echo $data['docenti'];
                ?> </h2>
            <p></p>
            <h2>Data</h2>
            <p>
            <input type="text" name="date" id="date"  value=""/>
            </p>
            <h2>Spiegazione dell'imprevisto</h2>
            <textarea name="value"></textarea>

            <h2><input type="checkbox" name="delete" value="1"> Cancella tutte le prenotazioni per quel giorno</h2>
            <input type="hidden" name="nomecognome" value="<?php
            echo $data['docenti'];
            ?> ">
            <br/>

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
    <script>
        var v = new FormValidator("new-bookoff",
            [
            {
                name: "date",
                display: "Data",
                rules: "required"
            },
            {
                name: "value",
                display: "Motivazione",
                rules: "required"
            }],
            function(errors, event){
                if(errors.length > 0){
                    msg="";
                    for(er in errors){
                        msg += errors[er].message+"\n";

                    }
                    alert(msg);
                }
            }
        );
    </script>
        <br><a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
            <a class='back' href="javascript:history.go(-1);">&Lt;</a>

<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>