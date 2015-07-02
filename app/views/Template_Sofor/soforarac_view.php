<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    <link href="<?php echo SITE_MPLUGIN_CSS; ?>/calendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo SITE_MPLUGIN_CSS; ?>/calendar/cal_custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsenui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/font_awesome/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsen-css-components-blue-basic-theme.css">
                <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.min.css">
                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.css.map">

                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/angular/angular.js"></script>
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/jquery-2.1.4.min.js"></script>
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/onsenui.js"></script>
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/aracajaxquery.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/calendar/moment.min.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/calendar/fullcalendar.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/calendar/lang-all.js"></script>
                        <script src="<?php echo MLANGUAGE_JS . $model[0]['dil']; ?>.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/validation.js"></script>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                        <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
                        <script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>
                        <script type="text/javascript">
                            ons.bootstrap();</script>
                        </head>
                        <body>
                        <input type="hidden" name="id" value="<?php echo $model[0]['id']; ?>"></input>
                        <input type="hidden" name="firmaId" value="<?php echo $model[0]['FirmaId']; ?>"></input>
                        <input type="hidden" name="lang" value="<?php echo $model[0]['dil']; ?>"></input>
                        <input type="hidden" name="enlem" value="<?php echo $model[0]['enlem']; ?>"></input>
                        <input type="hidden" name="boylam" value="<?php echo $model[0]['boylam']; ?>"></input>
                        <input type="hidden" name="location" value="<?php echo $model[0]['Location']; ?>"></input>

                        <ons-navigator title="<?php echo $data["AracListe"]; ?>" var="aracNavigator">

                            <ons-page>
                                <ons-toolbar>
                                    <div class="left"><i class="fa fa-reorder"></i> <?php echo $data["AracListe"]; ?></div>
                                </ons-toolbar>
                                <br />
                                <ons-list modifier="" class="person-list" var="listnavigator">
                                    <?php foreach ($model as $aracModel) { ?>
                                        <ons-list-item class="person" modifier="chevron" onclick="aracNavigator.pushPage('aracdetay.html', {animation: 'slide', aracID: <?php echo $aracModel['ID']; ?>})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="person-name">
                                                    <?php echo $aracModel['Plaka']; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    <?php } ?>
                                </ons-list>
                            </ons-page>

                            <ons-template id="aracdetay.html">
                                <ons-page class="profileMain" name="pMain" id="aracdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-bus"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["AracBilgi"]; ?> </div>

                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <input type="hidden" name="aracID" value=""></input>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="aracPlaka"></span></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="aracListMarka">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-flag"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="aracMarka"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="aracListYil">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-dashboard"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="aracYil"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-users"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="aracKapasite"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-road"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="aracKm"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="" id="aracIDurum"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="aracDurum"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="aracListAciklama">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-align-justify"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="aracAciklama"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="aracNavigator.pushPage('aracyolcu.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-users"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["KullaniciBilgi"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="aracNavigator.pushPage('aracyonetici.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-sitemap"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["YoneticiBilgi"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="aracNavigator.pushPage('aractakvim.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-calendar"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["Takvim"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="aracTurSoforHeader"><?php echo $data["Tur"]; ?> (<span id="turToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="aracTurSoforList">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>

                            <ons-template id="aracyolcu.html">
                                <ons-page id="aracyolcu">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-users"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header" id="aracSoforHeader"><?php echo $data["Sofor"]; ?> (<span id="soforToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="aracSoforList">
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="aracHostesHeader"><?php echo $data["Hostes"]; ?> (<span id="hostesToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="aracHostesList">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>

                            <ons-template id="aracyonetici.html">
                                <ons-page id="aracyonetici">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-sitemap"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header" id="aracSYoneticiHeader"><?php echo $data["Yonetici"]; ?> (<span id="yoneticiToplam"></span>)</div>
                                    <ons-list modifier="" class="yonetici-list" id="aracYoneticiList">
                                    </ons-list>
                                </ons-page>
                            </ons-template>

                            <ons-template id="aractakvim.html">
                                <ons-page id="aractakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-calendar"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div id="aracTakvim" class="settings-header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="margin-bottom: 10px"><?php echo $data["Takvim"]; ?> (<b><span id="takvimPlaka"></span></b>)</div>
                                                <div class="row" id="getPartialView">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="kullanicidetay.html">
                                <ons-page class="profileMain" name="pMain" id="kullanicidetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["KullaniciBilgi"]; ?> </div>

                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-user"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="kdetayAd"></span></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="kdetayListTel">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="kdetayTel"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="kdetaymail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="aracNavigator.pushPage('turharita.html', {animation: 'slide'})" id="kdetayListAdres">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="kdetayadres"></span>
                                                    <input type="hidden" name="kdetaylocation" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                </ons-page>
                            </ons-template>

                            <ons-template id="yoneticidetay.html">
                                <ons-page class="profileMain" name="pMain" id="yoneticidetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="aracNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["YoneticiBilgi"]; ?> </div>

                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-sitemap"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="ydetayAd"></span></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="ydetayListTel">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="ydetayTel"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="ydetaymail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="aracNavigator.pushPage('turharita.html', {animation: 'slide'})" id="ydetayListAdres">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="ydetayadres"></span>
                                                    <input type="hidden" name="ydetaylocation" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                </ons-page>
                            </ons-template>

                            <ons-template id="turharita.html">
                                <ons-page id="soforDetayMap">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="console.log(aracNavigator.resetToPage(0, {animation: 'slide'}))"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="turharita.html">
                                <ons-page id="soforYDetayMap">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="aracNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="console.log(aracNavigator.resetToPage(0, {animation: 'slide'}))"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
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