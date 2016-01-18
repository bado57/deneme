<html lang="tr" class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
    <title><?php echo $data["LoginTitle"]; ?> | Shuttle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="favicon.png">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="<?php echo SITE_USERFRONT_CSS; ?>/bootstrap.css"  type="text/css"/>
            <!-- Alert style -->
            <link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/alertify.css" rel="stylesheet" type="text/css" />
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
            <script src="<?php echo SITE_USERFRONT_JS; ?>/jquery-1.11.1.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script src="<?php echo SITE_URL_DOM; ?>"></script>
            <!--Alert-->

            <script src="<?php echo SITE_USERFRONT_JS; ?>/bootstrap.min.js"></script>
            <script src="<?php echo SITE_USERFRONT_JS; ?>/jquery.validate.js"></script>
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
            <script src="<?php echo SITE_JS_LANGUAGE; ?>/<?php echo Session::get("dil"); ?>.js"></script>
            <script src="<?php echo SITE_PLUGINADMIN_JS; ?>/alertify.js"></script>
            <script src="<?php echo SITE_URL_LOGINJS; ?>/userslogin.js"></script>
            <style type="text/css">
                body{background-color: #009933;}
                form .form-control{padding:0px 15px;
                                   border:0px;
                                   border-radius:6px;
                }

                form button {
                    padding: 0px 15px;
                    border: 0px;
                    border-radius: 6px;
                    width: 100%;
                    background-color: #25B10A;
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
            <div class="container" style="text-align:center; padding-top:100px;">
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
                <a class="col-lg-4 col-md-4 col-sm-6 col-xs-10" href="<?php echo SITE_URL; ?>">
                    <img style="margin:0px auto; max-width:100%;" src="<?php echo SITE_USERFRONT_IMG; ?>/eco/logo.png" alt="Shuttle Logo" class="logo">
                </a>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
            </div>
            <div class="container" style="padding-top:100px;" style="text-align:center;">
                <input type="hidden" id="sonucDeger" value="<?php echo $model[0]["Result"]; ?>" />
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10">
                    <form role="form" action="<?php echo SITE_URL; ?>/UsersLogin" method="POST"  id="loginForm"> 
                        <div class="form-group">
                            <select id="kullaniciLanguage" class="form-control" name="loginselected" required>                                   
                                <option value="ar" <?php echo Session::get('dil') == 'ar' ? 'selected' : ''; ?>>Arabic</option>
                                <option value="zh" <?php echo Session::get('dil') == 'zh' ? 'selected' : ''; ?>>Chinese</option>
                                <option value="en" <?php echo Session::get('dil') == 'en' ? 'selected' : ''; ?>>English</option>
                                <option value="fr" <?php echo Session::get('dil') == 'fr' ? 'selected' : ''; ?>>French</option>
                                <option value="de" <?php echo Session::get('dil') == 'de' ? 'selected' : ''; ?>>German</option>
                                <option value="tr" <?php echo Session::get('dil') == 'tr' ? 'selected' : ''; ?>>Turkish</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="<?php echo $data["Kadi"]; ?>" name="usersloginkadi">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="<?php echo $data["Sifre"]; ?>"  name="usersloginsifre">
                        </div>
                        <button type="submit" id="loginFrom"><?php echo $data["LoginButton"]; ?></button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
            </div>
            <!-- Button trigger modal -->
            </body>
            </html>