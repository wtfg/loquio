
<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login - Loquio - <?php $a = ConfigLoader::getInstance(); echo $a->getParam("schoolName")?></title>

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
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header blue lighter bigger">
                        <i class="icon-coffee green"></i>
                        Inserisci le informazioni
                    </h4>

                    <div class="space-6"></div>

                    <form id="login" name="login" method="post" action="index.php/login/">
                    <fieldset>
                        <label>
                            <span class="block input-icon input-icon-right">
                                <input type="text" name="email" class="span12" placeholder="Email" />
                                <i class="icon-user"></i>
                            </span>
                        </label>

                        <label>
                            <span class="block input-icon input-icon-right">
                                <input type="password" class="span12" name="pass" placeholder="Password" />
                                <i class="icon-lock"></i>
                            </span>
                        </label>

                        <div class="space"></div>

                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-small btn-primary">
                                <i class="icon-key"></i>
                                Login
                            </button>
                        </div>

                        <div class="space-4"></div>
                    </fieldset>
                    </form>


                </div><!--/widget-main-->

                <div class="toolbar clearfix">

                    <div>
                        <a href="lostpassword/" class="forgot-password-link">
                            <i class="icon-arrow-left"></i>
                            Password dimenticata

                        </a>

                    </div>
                    <div>
                        <a href="register/" class="user-signup-link">
                            Voglio registrarmi
                            <i class="icon-arrow-right"></i>
                        </a>

                    </div>

                </div>
            </div><!--/widget-body-->
            <div style="padding:10px"><a href="mailto:loquio.official@gmail.com?subject=Bug Report dal sito Loquio">Segnala un bug</a></div>
        </div><!--/login-box-->


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
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $ul; ?>assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<!--ace scripts-->

<script src="<?php echo $ul; ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo $ul; ?>assets/js/ace.min.js"></script>

<!--inline scripts related to this page-->

</body>
</html>
