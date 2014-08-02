<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Loquio - Registrati</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--basic styles-->

    <link href="<?php echo $ul; ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo $ul; ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--page specific plugin styles-->

    <!--fonts-->

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    <!--ace styles-->

    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/ace-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/ace-ie.min.css" />
    <![endif]-->

    <!--inline styles related to this page-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body class="login-layout">
<div class="main-container container-fluid">
<div class="main-content">
<div class="row-fluid">
<div class="span12">
<div class="login-container">
<div class="row-fluid">
    <div class="center">
        <h1>
            <i class="icon-leaf green"></i>
            <img src="<?php echo $ul; ?>assets/images/loquio-white.png">
        </h1>
    </div>
</div>

<div class="space-6"></div>

<div class="row-fluid">
    <div class="position-relative">


        <div id="signup-box" class="visible signup-box widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header green lighter bigger">
                        <i class="icon-group blue"></i>
                        Registrazione nuovo utente
                    </h4>

                    <div class="space-6"></div>
                    <p> Inserisci i tuoi dati per inziare: </p>

                    <form id="login" name="login" method="post" action="doregister/">
                    <fieldset>
                        <label>
                            <span class="block input-icon input-icon-right">
                                <input name="email" type="email" class="span12" placeholder="Email" />
                                <i class="icon-envelope"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input name="nome" type="text" class="span12" placeholder="Nome" />
                                <i class="icon-user"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input name="cognome" type="text" class="span12" placeholder="Cognome" />
                                <i class="icon-user"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input name="pass" type="password" class="span12" placeholder="Password" />
                                <i class="icon-lock"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input type="text" name="telefono" class="span12" placeholder="Telefono" />
                                <i class="icon-retweet"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input type="text" name="altramail" class="span12" placeholder="Email Alternativa" />
                                <i class="icon-retweet"></i>
                            </span>
                        </label>

                        <label>
                            <input type="checkbox" />
                            <span class="lbl">
                                Accetto il
                                <a href="#">Trattamento dei dati personali</a>
                            </span>
                        </label>

                        <div class="space-24"></div>

                        <div class="clearfix">
                            <button type="reset" class="width-30 pull-left btn btn-small">
                                <i class="icon-refresh"></i>
                                Reset
                            </button>

                            <button type="submit" class="width-65 pull-right btn btn-small btn-success">
                                Register
                                <i class="icon-arrow-right icon-on-right"></i>
                            </button>
                        </div>
                    </fieldset>
                    </form>
                </div>

                <div class="toolbar center">
                    <a href="<?php echo Doo::conf()->APP_URL; ?>" class="back-to-login-link">
                        <i class="icon-arrow-left"></i>
                        Torna al login
                    </a>
                </div>
            </div><!--/widget-body-->
        </div><!--/signup-box-->
    </div><!--/position-relative-->
</div>
</div>
</div><!--/.span-->
</div><!--/.row-fluid-->
</div>
</div><!--/.main-container-->

<!--basic scripts-->

<!--[if !IE]>-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<!--<![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo $ul; ?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo $ul; ?>assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='<?php echo $ul; ?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $ul; ?>assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<!--ace scripts-->

<script src="<?php echo $ul; ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo $ul; ?>assets/js/ace.min.js"></script>
<script src='<?php echo $ul; ?>js/validate.js'></script>
<!--inline scripts related to this page-->
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
</body>
</html>



