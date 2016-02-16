<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
    <title>Shuttle</title>

    <!-- Styles -->
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/opensans.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/lato.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/font-awesome.min.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/animate.min.css" rel="stylesheet"/> 
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/lightbox.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/green.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/main.css" rel="stylesheet"/>
    <link href="<?php echo SITE_USERFRONT_CSS; ?>/responsive.css" rel="stylesheet"/>
    <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/alertify.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo SITE_USERFRONT_IMG; ?>/ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo SITE_USERFRONT_IMG; ?>/ico/apple-touch-icon-144-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo SITE_USERFRONT_IMG; ?>/ico/apple-touch-icon-114-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo SITE_USERFRONT_IMG; ?>/ico/apple-touch-icon-72-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" href="<?php echo SITE_USERFRONT_IMG; ?>/ico/apple-touch-icon-57-precomposed.png"/>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/lightbox.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/wow.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/jquery.countTo.js"></script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/icheck.js"></script>
    <script>
        var SITE_URL = "http://localhost/SProject/";
        function reset() {
            alertify.set({
                labels: {
                    ok: jsDil.Tamam,
                    cancel: jsDil.Kapat
                },
                delay: 3000,
                buttonReverse: false,
                buttonFocus: "ok"
            });
        }
    </script>
    <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/main.js"></script> 
    <script src="<?php echo SITE_JS_LANGUAGE; ?>/<?php echo Session::get("dil"); ?>.js"></script>
    <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/alertify.js"></script>
</head><!--/head-->

<body>
    <header id="header">      
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow">
                    <div class="social-icons pull-right">
                        <ul class="nav nav-pills social-menu">
                            <li><a class="fcb" href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a class="twt" href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a class="ggl" href=""><i class="fa fa-google-plus"></i></a></li>
                            <li>
                                <select id="kullaniciLanguage" class="langSelect form-control" name="loginselected" required>     
                                    <option value="tr" <?php echo Session::get('dil') == 'tr' ? 'selected' : ''; ?>>Turkish</option>
                                    <option value="en" <?php echo Session::get('dil') == 'en' ? 'selected' : ''; ?>>English</option>
                                </select>
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
        <div class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="<?php echo SITE_URL_HOME; ?>">
                        <h1><img src="<?php echo SITE_USERFRONT_IMG; ?>/logo.png" alt=" Shuttle logo"/></h1>
                    </a>

                </div>
                <div class="collapse navbar-collapse">
                    <ul class="mainMenu nav navbar-nav navbar-right">
                        <li id="index" class="active"><a href="<?php echo SITE_URL; ?>/UserIndex/index"><?php echo $data["Anasayfa"]; ?></a></li>
                        <li id="about"><a href="<?php echo SITE_URL; ?>/UserIndex/about"><?php echo $data["Hakkinda"]; ?></a></li>
                        <li id="features"><a href="<?php echo SITE_URL; ?>/UserIndex/features"><?php echo $data["Ozellikler"]; ?></a></li>
                        <li id="how_it_works"><a href="<?php echo SITE_URL; ?>/UserIndex/how_it_works"><?php echo $data["NClsir"]; ?></a></li>
                        <li id="faq"><a href="<?php echo SITE_URL; ?>/UserIndex/faq"><?php echo $data["SSS"]; ?></a></li>
                        <li id="sign_up"><a href="<?php echo SITE_URL; ?>/UserIndex/sign_up"><i class="fa fa-check-circle"></i> <?php echo $data["KayitOl"]; ?></a></li>
                        <li id="Login"><a href="<?php echo SITE_URL; ?>/Login"><i class="fa fa-sign-in"></i> <?php echo $data["GirisYap"]; ?></a></li>         
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--/#header-->