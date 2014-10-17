<?php
$ul = Doo::conf()->APP_URL . "/global/";

ob_start();
?>
Inserisci utente
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>

    <form class="form-horizontal" id="login" name="login" method="post" action="">
        <div class="control-group">
            <label class="control-label" for="form-field-1">Nome</label>

            <div class="controls">
                <input type="text" name="nome" id="nome" placeholder="Nome">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Cognome</label>

            <div class="controls">
                <input type="text" name="cognome" id="cognome" placeholder="Cognome">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">Email</label>

            <div class="controls">
                <input type="text" name="email" id="email" placeholder="Email">
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
                <input type="text" name="telefono" id="telefono" placeholder="Telefono">
            </div>
        </div>
        <div class="row-fluid">
            <label for="aclt">Livello di Accesso (ACL)</label>
            <select name="aclr">
                <option value="0" selected>Utente</option>
                <option value="1">Docente</option>
                <option value="2">Amministratore</option>
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
        rules: "required"
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
        rules: "numeric"
    },],function(errors, event){
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