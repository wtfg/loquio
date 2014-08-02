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
        <label for="nome">Nome materia:</label>
        <input type="text" name="nome" id="nome" value="" placeholder="Materia" />
        <br />
        <button name="button" type="submit" class="btn btn-large btn-success">
            <i class="icon-ok bigger-150"></i>
            Invia
        </button>
      <br />
    </form>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
