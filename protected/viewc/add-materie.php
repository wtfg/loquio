<?php
ob_start();
?>
Inserisci materia
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
    <form id="add-materia" name="login" method="post" action="">
        <h2>Nome materia:</h2>
        <input type="text" name="nome" id="nome" />
        <br /><br />
        <input type="submit" name="button" id="button" value="Invia" />
      <br />
    </form>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>>
