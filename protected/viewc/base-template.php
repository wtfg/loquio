<?php
$ul = Doo::conf()->APP_URL . "global/";
$theacl = $_SESSION['user']['acl'];
$themail =  $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Loquio - <?php $a = ConfigLoader::getInstance(); echo $a->getParam("schoolName")?></title>

		<meta name="description" content="" />
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

        <link rel="stylesheet" href="<?php echo $ul; ?>assets/css/custom.css" />
        <?php if(array_key_exists('head', $data)) echo $data['head']; ?>
		<!--inline styles related to this page-->
        <style>
            @media screen{
                .show-print{
                    display: none;
                }
            }
            @media print{
                body, html{
                    margin-top:-15px;
                    padding-top: -15px;

                }
                .nav, .sidebar, .hide-print, #btn-scroll-up{
                    display:none;
                    visibility:hidden;
                    max-width: 0px;
                }
                .show-print{
                    display: inline;
                    font-weight: bold;
                    visibility: visible;
                }
                .main-content{

                    width: 100%;
                    margin:0px;
                }
            }
        </style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="#" class="brand">
						<small>
							<img src="<?php echo $ul; ?>assets/images/loquio-white.png">
                            <span class="hide-print" style="margin-left:10px"><?php echo $a->getParam("schoolName"); ?></span>
						</small>
					</a><!--/.brand-->
                    <ul class="nav ace-nav pull-right">






                        <li class="open hide-print" style="background: transparent; text-align: center;padding-top: 10px;">
                            <a data-toggle="dropdown" href="#" style="width:300px; font-size:16px">
								<?php echo $themail; ?>
                            </a>


                        </li>
                    </ul>
					<!--/.ace-nav-->
				</div><!--/.container-fluid-->
			</div><!--/.navbar-inner-->
		</div>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">

				<ul class="nav nav-list">
					<li>
						<a href="<?php echo Doo::conf()->APP_URL?>">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> Pannello principale </span>
						</a>
					</li>

                    <?php
                        if($theacl == "admin"){
                    ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-calendar"></i>
							<span class="menu-text"> Prenotazioni </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">

							<li>
								<a href="<?php echo Doo::conf()->APP_URL."admin/prenotazioni/"?>">
									<i class="icon-double-angle-right"></i>
									Prenotazioni
								</a>
							</li>

							<li>
								<a  href="<?php echo Doo::conf()->APP_URL."prenotazioni/list"?>">
									<i class="icon-double-angle-right"></i>
                                    Liste Mattutini
								</a>
							</li>

                            <li>
                                <a href="<?php echo Doo::conf()->APP_URL."prenotazioni/new"?>">
                                    <i class="icon-double-angle-right"></i>
                                    Prenota (Test)
                                </a>
                            </li>
						</ul>
					</li>

                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."admin/pomeridiani"?>">
                            <i class="icon-bullhorn"></i>
                            Pomeridiani
                        </a>
                    </li>

					<li>
						<a href="<?php echo Doo::conf()->APP_URL."admin/materie"?>">
							<i class="icon-edit"></i>
							<span class="menu-text"> Materie </span>
						</a>
					</li>

                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."admin/bookoff"?>">
                            <i class="icon-bolt"></i>
                            <span class="menu-text"> Bookoffs </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."admin/docenti"?>">
                            <i class="icon-book"></i>
                            <span class="menu-text"> Docenti </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."admin/utenti"?>">
                            <i class="icon-group"></i>
                            <span class="menu-text"> Utenti </span>
                        </a>
                    </li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-cogs"></i>
							<span class="menu-text"> Configurazioni </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="<?php echo Doo::conf()->APP_URL."admin/calendars"?>">
									<i class="icon-double-angle-right"></i>
									Calendario
								</a>
							</li>

							<li>
								<a href="<?php echo Doo::conf()->APP_URL."admin/config"?>">
									<i class="icon-double-angle-right"></i>
									Configurazioni generali
								</a>
							</li>

							<li>
								<a href="<?php echo Doo::conf()->APP_URL."admin/cleardb"?>" onclick="return confirm('Questo cancellera tutto il database! Sei sicuro??')">
									<i class="icon-double-angle-right"></i>
									Cancella DB
								</a>
							</li>
						</ul>
					</li>

                <?php
                    }else if($theacl == "user"){
                            ?>
                            <?php if($a->getParam("pomeridianiActive")=="true"){
                                ?>
                                <li>
                                    <a href="<?php echo Doo::conf()->APP_URL."pomeridiani/new"?>">
                                        <i class="icon-bullhorn"></i>
                                        <b>Prenota pomeridiani</b>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo Doo::conf()->APP_URL."pomeridiani/"?>">
                                        <i class="icon-double-angle-right"></i>
                                        <b>I miei pomeridiani</b>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <li>
                                <a href="<?php echo Doo::conf()->APP_URL."prenotazioni/new"?>">
                                    <i class="icon-check"></i>
                                    Prenota mattutini
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Doo::conf()->APP_URL."prenotazioni/"?>">
                                    <i class="icon-edit-sign"></i>
                            I miei mattutini
                                </a>
                            </li>

                            <li>
                                <a  href="<?php echo Doo::conf()->APP_URL."prenotazioni/list"?>">
                                    <i class="icon-list"></i>
                            Liste Mattutini
                            </a>
                            </li>



                    <?php

                    }else{
                            $d = Doo::loadModel("docenti", true);
                            $d->email = $themail;
                            $docente =Doo::db()->find($d, array("limit"=>1));
                            $docid = $docente->did;
?>

                            <li>
                                <a  href="<?php echo Doo::conf()->APP_URL."snag/".$docid?>">
                                    <i class="icon-warning-sign"></i>
                                    Avviso imprevisti
                                </a>
                            </li>
                            <li>
                                <a  href="<?php echo Doo::conf()->APP_URL."prenotazioni/list"?>">
                                    <i class="icon-list"></i>
                                    Liste Mattutini
                                </a>
                            </li>
                    <?php
                    }
                ?>

                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."control/panel" ?>">
                            <i class="icon-cog"></i>
                            <span class="menu-text"> Account </span>
                        </a>
                    </li>


                    <li>
                        <a href="<?php echo Doo::conf()->APP_URL."logout";?>">
                            <i class="icon-retweet"></i>
                            <span class="menu-text"> Esci </span>
                        </a>
                    </li>
					<!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>

			<div class="main-content">

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->

                            <div class="page-header position-relative">
                                <div class="show-print">
                                    <h1>
                                        Loquio - Servizio di prenotazione online dei colloqui<br><br>
                                    </h1>
                                </div>
                                <h1>
                                    <?php if(array_key_exists('title', $data)) echo $data['title']; ?>
                                </h1>
                            </div>

                            <?php if(array_key_exists('content', $data)) echo $data['content']; ?>
							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
                    <div><a href="mailto:loquio.official@gmail.com?subject=Bug Report dal sito Loquio">Segnala un bug</a></div>
				</div><!--/.page-content-->

				<!--/#ace-settings-container-->
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>

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

		<!--inline scripts related to this page-->
        <?php if(array_key_exists('scripts', $data)) echo $data['scripts']; ?>
	</body>
</html>
