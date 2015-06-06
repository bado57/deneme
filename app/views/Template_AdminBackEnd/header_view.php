<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
    <title><?php echo $data["Baslik"]; ?> | Shuttle</title>
    <link rel="shortcut icon" href="<?php echo SITE_PLUGINADMIN_IMG; ?>/favicon.png">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Google Font -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <!-- Bootstrap 3.0.2 -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />


            <!-- Font Awesome -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/font-awesome.min.css" rel="stylesheet" type="text/css" />

            <!-- Bootstrap wysihtml5 - text editor -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

            <!-- Theme style -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/shuttle.css" rel="stylesheet" type="text/css" />
            <!-- Alert style -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/alertify.css" rel="stylesheet" type="text/css" />
            <!-- iCheck style -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/iCheck/square/green.css" rel="stylesheet" type="text/css" />
            <!-- jQuery 2.0.2 -->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/jquery.min.js"></script>
            <script src="<?php echo SITE_URL_DOM; ?>"></script>

            <!-- jQuery UI 1.10.3 -->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

            <!-- Bootstrap -->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/bootstrap.min.js" type="text/javascript"></script>

            <!-- Datatables & Bootstrap -->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/jquery.dataTables.min.js"></script>
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/dataTables.bootstrap.js"></script>

            <!--Jquery select -->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/bootstrap-multiselect.js"></script>
            <!--Validation-->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/validation.js"></script>
            <!--Script Language-->
            <script src="<?php echo SITE_JS_LANGUAGE; ?>/<?php echo Session::get("dil"); ?>.js"></script>
            <!--Alert-->
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/alertify.js"></script>
            <script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminbildirimajax.js" type="text/javascript"></script>
            <script>
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
            </head>
            <body class="skin-blue">
            <script>
                var domAnimator = new DomAnimator();
                var frame1 = ['       .-"-.       ',
                    '     _/.-.-.\\_     ',
                    '    ( ( o o ) )    ',
                    '     |/  "  \\|     ',
                    "      \\'/^\\'/      ",
                    '      /`\\ /`\\      ',
                    '     /  /|\\  \\     ',
                    '    ( (/ T \\) )    ',
                    '     \\__/^\\__/     '];

                var frame2 = ['       .-"-.       ',
                    '     _/_-.-_\\_     ',
                    '    / __> <__ \\    ',
                    '   / //  "  \\\\ \\   ',
                    "  / / \\'---'/ \\ \\  ",
                    '  \\ \\_/`"""`\\_/ /  ',
                    '   \\           /   ',
                    '    \\         /    ',
                    '     |   .   |     ']

                var frame3 = ['       .-"-.       ',
                    '     _/_-.-_\\_     ',
                    '    /|( o o )|\\    ',
                    '   | //  "  \\\\ |   ',
                    "  / / \\'---'/ \\ \\  ",
                    '  \\ \\_/`"""`\\_/ /  ',
                    '   \\           /   ',
                    '    \\         /    ',
                    '     |   .   |     ']

                domAnimator.addFrame(frame1);
                domAnimator.addFrame(frame2);
                domAnimator.addFrame(frame3);
                domAnimator.animate(1000);
            </script>
            <!-- header logo: style can be found in header.less -->
            <header class="header hidden-xs hidden-sm">
                <a href="<?php echo SITE_URL_LOGINN; ?>" class="logo" >
                    <!-- Add the class icon to your logo image or logo icon to add the margining -->
                    <img src="<?php echo SITE_PLUGINADMIN_IMG; ?>/logo.png" class="img" alt="User Image"/>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav">
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bullhorn"></i>
                                    <span class="label label-warning">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#" id="tumunuGosterDuyuru"><?php echo $data["TumunuGor"]; ?></a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu" id="bildirimTikla">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-warning"></i>
                                    <span class="label label-warning" id="bildirimCount"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo $data["Bildirimler"]; ?><a href="#" id="tumunuOkundu"><?php echo $data["OkunduIsaret"]; ?></a></li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu"  id="bildirim">
                                        </ul>
                                    </li>
                                    <div id="loadmoreajaxloader" style="display:none"><center><img src="<?php echo SITE_IMG; ?>/ajax-loader2.gif" /></center></div>
                                    <div id="loadmoreajaxloaderText" style="display:none"><center><?php echo $data["BildirimYok"]; ?></center></div>
                                    <li class="footer"><a href="#" id="tumunuGoster"><?php echo $data["TumunuGor"]; ?></a></li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="<?php echo SITE_URL; ?>/adminweb/ayarislem" title="Bildirim Ayarları">
                                    <i class="fa fa-cog"></i>
                                </a>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span>  <?php echo Session::get("kullaniciad"); ?>&nbsp;<?php echo Session::get("kullanicisoyad"); ?><i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header bg-light-blue">
                                        <img src="<?php echo SITE_PLUGINADMIN_IMG; ?>/avatar3.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo Session::get("kullaniciad"); ?>&nbsp;<?php echo Session::get("kullanicisoyad"); ?>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo SITE_URL; ?>/adminweb/profil" class="btn btn-default btn-flat"><?php echo $data["Profil"]; ?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo SITE_URL_LOGOUT; ?>" class="btn btn-default btn-flat"><?php echo $data["CikisYap"]; ?></a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>