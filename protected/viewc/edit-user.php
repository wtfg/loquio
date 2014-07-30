<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<link rel="stylesheet" media="screen" href="<?php echo $ul; ?>css/style.css" />
<script src='<?php echo $ul; ?>js/validate.js'></script>

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<?php
$data['head'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
Modifica utente
<?php
$data['title'] = ob_get_contents();
ob_end_clean();
ob_start();
?>


    <form id="login" name="login" method="post" action=""><input type="hidden" name="uid" value="<?php echo $data["utente"]->uid; ?>">
      <h2>Nome</h2>
      <p>
      <input type="text" name="nome" id="nome" value="<?php echo $data["utente"]->nome; ?>" />
      </p>
      <h2>Cognome</h2>
      <p>
      <input type="text" name="cognome" id="cognome" value="<?php echo $data["utente"]->cognome; ?>" />
      </p>
      <h2>Email</h2>
      <p>
      <input type="text" name="email" id="email" value="<?php echo $data["utente"]->email; ?>" />
      </p>
      <h2>Password</h2>
      <p>
      <input type="password" name="pass" id="pass" value="" />
      </p>
      <h2>Telefono</h2>
      <p>
      <input type="text" name="telefono" id="telefono" value="<?php echo $data["utente"]->telefono; ?>" />
      </p>
      <h2>Email Alternativa</h2>
      <p>
      <input type="text" name="altramail" id="altramail" value="<?php echo $data["utente"]->altramail; ?>" />
      </p>
        <h2>Livello di accesso</h2>
        <p>
        <select name="aclr">
            <option value="0" <?php echo ($data["utente"]->acl == 0) ? "selected" : ""; ?>>Utente</option>
            <option value="1" <?php echo ($data["utente"]->acl == 1) ? "selected" : ""; ?>>Docente</option>
            <option value="2" <?php echo ($data["utente"]->acl == 2) ? "selected" : ""; ?>>Amministratore</option>
        </select>
            </p>
        <br>
      <input type="submit" name="button" id="button" value="Modifica" />
          <a class='back' href="javascript:history.go(-1);">&Lt;</a>

    <br />
    </form>
    <br>
    
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
$data['content'] = ob_get_contents();
ob_end_clean();
?>