<?php
$ul = Doo::conf()->APP_URL . "/global/";

ob_start();
?>
Modifica utente
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

    <form class="form-horizontal" id="login" name="login" method="post" action=""><input type="hidden" name="uid" value="<?php echo $data["utente"]->uid; ?>">
        <div class="control-group">
            <label class="control-label" for="form-field-1">Nome</label>

            <div class="controls">
                <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $data["utente"]->nome; ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Cognome</label>

            <div class="controls">
                <input type="text" name="cognome" id="cognome" placeholder="Cognome" value="<?php echo $data["utente"]->cognome; ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Email</label>

            <div class="controls">
                <input type="text" name="email" id="email" placeholder="Email" value="<?php echo $data["utente"]->email; ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Password</label>

            <div class="controls">
                <input type="password" name="pass" id="pass" placeholder="Password">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Telefono</label>

            <div class="controls">
                <input type="text" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $data["utente"]->telefono; ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Email Alternativa</label>

            <div class="controls">
                <input type="text" name="altramail" id="altramail" placeholder="Email Alternativa" value="<?php echo $data["utente"]->altramail; ?>">
            </div>
        </div>
        <div class="row-fluid">
            <label for="aclt">Livello di Accesso (ACL)</label>
            <select name="aclr">
                <option value="0" <?php echo ($data["utente"]->acl == 0) ? "selected" : ""; ?>>Utente</option>
                <option value="1" <?php echo ($data["utente"]->acl == 1) ? "selected" : ""; ?>>Docente</option>
                <option value="2" <?php echo ($data["utente"]->acl == 2) ? "selected" : ""; ?>>Amministratore</option>
            </select>
        </div>

        <br>
        <br>
        <button name="button" type="submit" class="btn btn-large btn-success">
            <i class="icon-ok bigger-150"></i>
            Invia
        </button>
    </form>
<?php
$data['content'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

    <script src='<?php echo $ul; ?>js/validate.js'></script>
        <script>
var v = new FormValidator("login",
    [
    {
        name: "nome", 
        display: "Nome",
        rules: "alpha|required"
    },{
        name: "cognome", 
        display: "Cognome",
        rules: "required"
    },{
        name: "email", 
        display: "Email",
        rules: "valid_email|required"
    },{
        name: "pass", 
        display: "Password",
        rules: "required"
    },{
        name: "telefono", 
        display: "Telefono",
        rules: "numeric|required"
    },{
        name: "altramail", 
        display: "Email Alternativa",
        rules: "valid_email|required"
    }],function(errors, event){
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
<?php
$data['scripts'] = ob_get_contents();
ob_end_clean();
?>