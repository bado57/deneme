<html lang="tr" class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
    <title><?php echo $data["LoginTitle"]; ?>|Shuttle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="favicon.png">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <link href="https://fonts.googleapis.com/css?family=Limelight|Flamenco|Federo|Yesteryear|Josefin Sans|Spinnaker|Sansita One|Handlee|Droid Sans|Oswald:400,300,700" media="screen" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/bootstrap.css"  type="text/css"/>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/animate.css"  type="text/css"/>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_FONTAWESOME; ?>/css/font-awesome.min.css" type="text/css"/>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/slick.css"  type="text/css"/>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_JS; ?>/rs-plugin/css/settings.css"  type="text/css"/>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/screen.css"  type="text/css"/>
            <script type="text/javascript" src="<?php echo SITE_USERFRONT_JS; ?>/modernizr.custom.32033.js"></script>

            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/master.css" media="screen" type="text/css"/>
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

            <style type="text/css">
                form .form-control{padding:0px 15px;
                                   border:0px;
                                   border-radius:6px;
                }

                form button {
                    padding: 0px 15px;
                    border: 0px;
                    border-radius: 6px;
                    width: 100%;
                    background-color: #1F8E0A;
                    color: #fff;
                    height: 40px;
                    line-height: 40px;
                }

                form button:hover {
                    background-color: #2fba15;
                }
                #loginFormum{
                    margin-left: 34%
                }

            </style>

            </head>
            <body>
                <!--
                <div class="pre-loader">
                    <div class="load-con">
                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/eco/logo.png" class="animated fadeInDown" alt="">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                    </div>
                </div>
                -->

                <header>


                    <div class="dil">
                        <a href="<?php echo SITE_URL; ?>/language?language=tr">Türkçe</a>|<a href="<?php echo SITE_URL; ?>/language?language=en">İngilizce</a>
                    </div>
                    <div class="tp-banner-container">
                        <div class="tp-banner">
                            <div class="container" style="text-align:center; padding-top:100px;">
                                <a href="index.html">
                                    <img src="<?php echo SITE_USERFRONT_IMG; ?>/eco/logo.png" alt="" class="logo">
                                </a>
                            </div>
                            <section class="doublediagonal">
                                <div class="container" style="padding-top:100px;" id="loginFormum">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <!--
                                                <div class="col-md-4 col-sm-3 col-xs-2">
                                                    <a role="button" class="" data-toggle="modal" data-target="#myModal">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                                -->
                                                <div class="col-md-4 col-sm-6 col-xs-8">
                                                    <form role="form" method="POST" action="<?php echo SITE_URL; ?>/userslogin" id="loginForm"> 
                                                        <div class="form-group">
                                                            <select id="kullanici" class="form-control" name="loginselected" required>
                                                                <option selected value="0"><?php echo $data["LoginSelectBox"]; ?></option>
                                                                <option value="1"><?php echo $data["LoginSelectAdmin"]; ?></option>
                                                                <option value="2"><?php echo $data["LoginSelectSofor"]; ?></option>
                                                                <option value="3"><?php echo $data["LoginSelectVeli"]; ?></option>
                                                                <option value="4"><?php echo $data["LoginSelectOgrenci"]; ?></option>
                                                                <option value="5"><?php echo $data["LoginSelectPersonel"]; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="<?php echo $data["Loginkadi"]; ?>" name="usersloginkadi">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" class="form-control" placeholder="<?php echo $data["Loginsifre"]; ?>"  name="usersloginsifre">
                                                        </div>
                                                        <button type="submit" class="" id="loginFrom"><?php echo $data["LoginButton"]; ?></button>
                                                    </form>
                                                </div>
                                                <div class="col-md-4 col-sm-3 col-xs-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>

                </header>


                <!-- Button trigger modal -->


                <!-- Modal Login-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> Hata</h4>
                        </div>
                        <div class="modal-body">
                            Bir hata medana geldi
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Kapat</button>
                            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                        </div>
                    </div>
                </div>
            </div>



            <script src="<?php echo SITE_USERFRONT_JS; ?>/jquery-1.11.1.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/bootstrap.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/slick.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/jquery.validate.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/placeholdem.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/waypoints.min.js"></script>
            <script src="<?php echo SITE_URL_LOGINJS; ?>/bootbox.min.js"></script>
            <script src="<?php echo SITE_URL_LOGINJS; ?>/userslogin.js"></script>

            <script>
                /*
                 $(document).ready(function () {
                 appMaster.preLoader();
                 });*/
            </script>
            </body>
            </html>