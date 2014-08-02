<?php
ob_start();
?>
Modifica Materia
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
    <form id="edit-materia" name="login" method="post" action="">
        <label for="nome">Nome materia:</label>
        <input type="text" name="nome" id="nome" value="<?php
        echo $data['nome']; ?>" />
        <br /><br /><input type="hidden" name="mid" id="mid" value="<?php
        echo $data['mid']; ?>"/><br />
        <button name="button" type="submit" class="btn btn-large btn-success">
            <i class="icon-ok bigger-150"></i>
            Invia
        </button>
        <br />
    </form>


<?php
$data['content'] = ob_get_contents();
ob_end_clean();
?>