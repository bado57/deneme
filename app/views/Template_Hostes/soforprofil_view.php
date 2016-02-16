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
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/profilajaxquery.js"></script>
                        <script src="<?php echo MLANGUAGE_JS . $model['dil']; ?>.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/validation.js"></script>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                        <script type="text/javascript">
                            ons.bootstrap();
                        </script>
                        </head>
                        <body>
                        <input type="hidden" name="id" value="<?php echo $model['id']; ?>"></input>
                        <input type="hidden" name="firmaId" value="<?php echo $model['FirmaId']; ?>"></input>
                        <input type="hidden" name="lang" value="<?php echo $model['dil']; ?>"></input>
                        <input type="hidden" name="emailUnut" value="<?php echo $model['Email']; ?>"></input>
                        <input type="hidden" name="enlem" value="<?php echo $model['enlem']; ?>"></input>
                        <input type="hidden" name="boylam" value="<?php echo $model['boylam']; ?>"></input>
                        <input type="hidden" name="location" value="<?php echo $model['Location']; ?>"></input>
                        <!--harita bilgileri-->
                        <input type="hidden" name="country" value=""></input>
                        <input type="hidden" name="administrative_area_level_1" value=""></input>
                        <input type="hidden" name="administrative_area_level_2" value=""></input>
                        <input type="hidden" name="locality" value=""></input>
                        <input type="hidden" name="neighborhood" value=""></input>
                        <input type="hidden" name="route" value=""></input>
                        <input type="hidden" name="postal_code" value=""></input>
                        <input type="hidden" name="street_number" value=""></input>
                        <input type="hidden" name="soforLokasyon" value=""></input>
                        <ons-navigator title="Profil" var="profileNavigator">

                            <ons-page class="profileMain" name="pMain">
                                <ons-toolbar>
                                    <div class="left"><b><i class="fa fa-user"></i> <?php echo $data["GenelBilgi"]; ?></b></div>
                                </ons-toolbar>
                                <br />
                                <ons-list modifier="" class="settings-list">
                                    <ons-list-item>
                                        <ons-row>
                                            <ons-col width="40px"> 
                                                <i class="fa fa-mortar-board"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <b id="genelAd"><?php echo $model['Ad'] . ' ' . $model['Soyad']; ?></b>
                                                <div class="username" id="genelKadi"><i class="fa fa-user"></i> <?php echo $model['Kadi']; ?></div>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                    <ons-list-item>
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-phone-square"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <span id="genelTelefon"> <?php echo $model['Phone']; ?></span>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                    <ons-list-item>
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-envelope"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <span id="genelEmail"> <?php echo $model['Email']; ?></span>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                    <ons-list-item>
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-map-marker"></i>
                                            </ons-col>
                                            <ons-col class="coldty adressbar">
                                                <span id="genelAdres"> <?php echo $model['Adres']; ?></span>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                </ons-list>
                                <br />
                                <div class="settings-header"><?php echo $data["Islemler"]; ?></div>
                                <ons-list modifier="" class="edit-list">
                                    <ons-list-item modifier="chevron" onclick="profileNavigator.pushPage('edit.html', {animation: 'slide'})">
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-edit"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <?php echo $data["BilgiDuzen"]; ?>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                    <ons-list-item modifier="chevron" onclick="profileNavigator.pushPage('map.html', {animation: 'slide'})">
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-map-marker"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <?php echo $data["LokasyonBelirle"]; ?>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                    <ons-list-item modifier="chevron" onclick="profileNavigator.pushPage('lock.html', {animation: 'slide'})">
                                        <ons-row>
                                            <ons-col width="40px">
                                                <i class="fa fa-lock"></i>
                                            </ons-col>
                                            <ons-col class="coldty">
                                                <?php echo $data["SifreDegis"]; ?>
                                            </ons-col>
                                        </ons-row>
                                    </ons-list-item>
                                </ons-list>
                                <br />

                            </ons-page>


                            <ons-template id="edit.html">
                                <ons-page id="editpage">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="profileNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-edit"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="profileNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-user"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />

                                    <div class="login-form">
                                        <ons-row>
                                            <ons-col class="colform" width="25%">
                                                <?php echo $data['Ad']; ?>
                                            </ons-col>
                                            <ons-col class="colblank" width="2%">:</ons-col>
                                            <ons-col class="colformdty">
                                                <input id="isim" type="text"  name="editAd" class="text-input--underbar" placeholder="<?php echo $data['Ad']; ?>" value="">
                                            </ons-col>
                                        </ons-row>
                                        <br />
                                        <ons-row>
                                            <ons-col class="colform" width="25%">
                                                <?php echo $data['Soyad']; ?>
                                            </ons-col>
                                            <ons-col class="colblank" width="2%">:</ons-col>
                                            <ons-col class="colformdty">
                                                <input type="text" name="editSoyad" class="text-input--underbar" placeholder="<?php echo $data['Soyad']; ?>" value="">
                                            </ons-col>
                                        </ons-row>
                                        <br />
                                        <ons-row>
                                            <ons-col class="colform" width="25%">
                                                <?php echo $data['Telefon']; ?>
                                            </ons-col>
                                            <ons-col class="colblank" width="2%">:</ons-col>
                                            <ons-col class="colformdty">
                                                <input type="text" name="editTelefon" class="text-input--underbar" placeholder="<?php echo $data['Telefon']; ?>" value="">
                                            </ons-col>
                                        </ons-row>
                                        <br />
                                        <ons-row>
                                            <ons-col class="colform" width="25%">
                                                <?php echo $data['Email']; ?>
                                            </ons-col>
                                            <ons-col class="colblank" width="2%">:</ons-col>
                                            <ons-col class="colformdty">
                                                <input type="text" name="editEmail" class="text-input--underbar" placeholder="<?php echo $data['Email']; ?>" value="">
                                            </ons-col>
                                        </ons-row>
                                    </div>

                                    <br />

                                    <ons-bottom-toolbar>
                                        <ons-row>
                                            <ons-col width="49%" style="text-align:left;">
                                                <button class="button button--large" onclick="profileNavigator.popPage()"><i class="fa fa-times"></i></button>
                                            </ons-col>
                                            <ons-col width="2%">
                                            </ons-col>
                                            <ons-col width="49%" style="text-align:right;">
                                                <button class="button button--large" onclick="$.SoforIslemler.soforEdtEkle()"><i class="fa fa-check"></i></button>
                                            </ons-col>
                                        </ons-row>
                                    </ons-bottom-toolbar>


                                </ons-page>
                            </ons-template>

                            <ons-template id="map.html">
                                <ons-page id="mappage">
                                    <style>
                                        .google-maps {
                                            position: absolute;
                                            width: 100%;
                                            height: 100%;
                                            overflow: hidden;
                                        }

                                        .google-maps iframe {
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            width: 100% !important;
                                            height: 100% !important;
                                        }
                                    </style>
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="profileNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-map-marker"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="profileNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-user"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                    <ons-bottom-toolbar>
                                        <ons-row>
                                            <ons-col width="49%" style="text-align:left;">
                                                <button class="button button--large" onclick="profileNavigator.popPage()"><i class="fa fa-times"></i></button>
                                            </ons-col>
                                            <ons-col width="2%">
                                            </ons-col>
                                            <ons-col width="49%" style="text-align:right;">
                                                <button class="button button--large" onclick="$.SoforIslemler.soforMapSave()"><i class="fa fa-check"></i></button>
                                            </ons-col>
                                        </ons-row>
                                    </ons-bottom-toolbar>
                                </ons-page>
                            </ons-template>

                            <ons-template id="lock.html">
                                <ons-page id="lockpage">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="profileNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-lock"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="profileNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-user"></i></ons-button></div>
                                    </ons-toolbar>

                                    <div class="login-form">
                                        <input type="password" name="eskiSifre" class="text-input--underbar" placeholder="<?php echo $data['EskiSifre']; ?>" value="">
                                            <input type="password" name="yeniSifre" class="text-input--underbar" placeholder="<?php echo $data['YeniSifre']; ?>" value="">
                                                <input type="password" name="yeniSifreTekrar" class="text-input--underbar" placeholder="<?php echo $data['YeniSifreTekrar']; ?>" value="">
                                                    </div>

                                                    <div class="login-form">
                                                        <button class="button accessButton button--large" onclick="$.SoforIslemler.soforSfreEkle()"><i class="fa fa-check"></i></button>
                                                        <br />
                                                        <br />
                                                        <br />
                                                        <button class="button button--large" onclick="$.SoforIslemler.soforMailUnut()" style="background-color:transparent !important; border:none !important; color:#0949e2;"><?php echo $data['SifreUnut']; ?> </button>
                                                    </div>

                                                    </ons-page>
                                                    </ons-template>
                                                    </ons-navigator>
                                                    <ons-modal var="modal" style="text-align:center;">
                                                        <div class="load">
                                                            <i class="fa fa-refresh fa-spin"></i>
                                                        </div>
                                                    </ons-modal>

                                                    </body>

                                                    </html>