<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> </title>
<link rel="stylesheet" type="text/css" href="<?php echo $ul; ?>css/datepickr.css" />
<link rel="stylesheet" media="screen" href="<?php echo $ul; ?>css/style.css" />

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>

<body>
    <h1>Lista Prenotazioni</h1><!--
Prenotazioni per docente - pag 1
-->

<form method="post" action="">
    <h2>In che data vuoi sapere?</h2>
    <p>
    <input type="text" id="data" name="data" value ="">
    </p>
    
    <h2>Per quale docente vuoi vedere la lista?</h2>
    <p>
            <?php echo $data['option'] ?>
    </p>
    <input type="submit" name="invia" value="Invia">
</form>
	<script type="text/javascript" src="<?php echo $ul; ?>js/datepickr.min.js"></script>
		<script type="text/javascript">
		
			new datepickr('data', {
				dateFormat: 'd/m/Y', /* need to double escape characters that you don't want formatted */
				weekdays: ['Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'],
				months: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
				defaultSuffix: '' /* the suffix that is used if nothing matches the suffix object, default 'th' */
			});
		</script>
<a class='logout' href="<?php echo Doo::conf()->APP_URL."logout";?>">Esci</a>
    <a class='back' href="javascript:history.go(-1);">&Lt;</a>

</body>
</html>