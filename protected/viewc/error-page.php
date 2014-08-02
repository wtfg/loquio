
<?php
$ul = Doo::conf()->APP_URL . "/global/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login - Loquio</title>

    <meta name="description" content="Errore!" />
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
    <meta http-equiv="refresh" content="3;URL=<?php echo Doo::conf()->APP_URL;?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body class="login-layout">
<div class="main-container container-fluid">
<div class="main-content">
<div class="row-fluid">
<div class="span12">
<div class="login-container">


<div class="space-6"></div>

<div class="row-fluid">
    <div class="position-relative">
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header red lighter bigger">
                        <i class="icon-bolt red"></i>
                        OPS!
                    </h4>

                    <div class="space-6"></div>

                    <?php
                    if(isset($data["message"])){
                        echo $data["message"];
                    }else{
                        ?>
                        Questa &eacute; una pagina di errore, se ti appare significa che qualcosa &eacute; andato storto.
                                                                                                           Forse questa non &eacute; la pagina che stavi cercando. Forse la pagina che cerchi non esiste pi&uacute;, o forse
                        non hai le credenziali per poter accedere in qualche area riservata.
                    <?php
                    }
                    ?>

                </div><!--/widget-main-->
                <br>

                <div class="toolbar clearfix">
                &nbsp;
                </div>
            </div><!--/widget-body-->
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
