<!DOCTYPE html>
<html>
    <head>
    <title>Shuttle</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsenui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/font_awesome/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsen-css-components-blue-basic-theme.css">
                <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.min.css">
                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.css.map">
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/angular/angular.js"></script>
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/jquery-2.1.4.min.js"></script>
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/onsenui.js"></script>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                        <script type="text/javascript">
                            ons.bootstrap();
                        </script>    
                        </head>
                        <body>
                        <ons-navigator title="Profil" var="profileNavigator">
                            <ons-page class="profileMain" name="pMain">
                                <ons-toolbar>
                                    <div class="left"><b><?php echo $data["HataPage"]; ?></b></div>
                                </ons-toolbar>
                                <br />
                                <ons-list modifier="" class="settings-list">
                                    <ons-list-item>
                                        <ons-row>
                                            <ons-col width="40px"> 
                                                <i class="fa fa-exclamation-triangle"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <?php echo $data["LoginFirmaFalse"]; ?>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                </ons-list>
                            </ons-page>
                            </body>
                            </html>