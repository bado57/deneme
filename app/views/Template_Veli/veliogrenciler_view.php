<!DOCTYPE html>
<html>
    <head>
    <title>Shuttle</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/onsenui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/font_awesome/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/onsen-css-components-blue-basic-theme.css">
                <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/shuttle-mobile-app.min.css">
                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/shuttle-mobile-app.css.map">
                        <script src="<?php echo SITE_PLUGINMVELI_JS ?>/angular/angular.js"></script>
                        <script src="<?php echo SITE_PLUGINMVELI_JS ?>/jquery-2.1.4.min.js"></script>
                        <script src="<?php echo SITE_PLUGINMVELI_JS ?>/onsenui.js"></script>
                        <script src="<?php echo SITE_PLUGINMVELI_JS ?>/ogrenciajaxquery.js"></script>
                        <script src="<?php echo MLANGUAGE_JS . $model[0][0]['dil']; ?>.js"></script>
                        <script src="<?php echo SITE_MPLUGIN_JS; ?>/validation.js"></script>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                        <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
                        <script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>
                        <script type="text/javascript">
                            ons.bootstrap();
                        </script>
                        </head>
                        <body>
                        <input type="hidden" name="id" value="<?php echo $model[0][0]['id']; ?>"></input>
                        <input type="hidden" name="firmaId" value="<?php echo $model[0][0]['FirmaId']; ?>"></input>
                        <input type="hidden" name="lang" value="<?php echo $model[0][0]['dil']; ?>"></input>
                        <input type="hidden" name="emailUnut" value="<?php echo $model[0][0]['Email']; ?>"></input>
                        <input type="hidden" name="enlem" value="<?php echo $model[0][0]['enlem']; ?>"></input>
                        <input type="hidden" name="boylam" value="<?php echo $model[0][0]['boylam']; ?>"></input>
                        <input type="hidden" name="location" value="<?php echo $model[0][0]['Location']; ?>"></input>
                        <input type="hidden" name="android_id" value="<?php echo $model[0][0]['android_id']; ?>"></input>
                        <!--harita bilgileri-->
                        <input type="hidden" name="country" value=""></input>
                        <input type="hidden" name="administrative_area_level_1" value=""></input>
                        <input type="hidden" name="administrative_area_level_2" value=""></input>
                        <input type="hidden" name="locality" value=""></input>
                        <input type="hidden" name="neighborhood" value=""></input>
                        <input type="hidden" name="route" value=""></input>
                        <input type="hidden" name="postal_code" value=""></input>
                        <input type="hidden" name="street_number" value=""></input>
                        <input type="hidden" name="ogrenciLokasyon" value=""></input>
                        <ons-navigator title="Ogrenci" var="ogrenciNavigator">
                            <ons-page class="ogrenciMain" name="pMain">
                                <ons-toolbar>
                                    <div class="left"><b><i class="fa fa-user"></i> <?php echo $data["Ogrenci"]; ?></b></div>
                                </ons-toolbar>
                                <br />
                                <ons-list modifier="" class="edit-list">
                                    <?php foreach ($model[1] as $veliModel) { ?>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('islemliste.html', {animation: 'slide', ogrenciID: <?php echo $veliModel['ID']; ?>})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-child"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $veliModel["Ad"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    <?php } ?>
                                </ons-list>
                                <br />
                            </ons-page>
                            <ons-template id="islemliste.html">
                                <input type="hidden" name="islemListItem" id="islemListe" value=""></input>
                                <ons-page id="islemlistepage">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;position: absolute; left: 50%;"><i class="fa fa-reorder"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="edit-list">
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('profilliste.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-child"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["ProfilDetay"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('kurumliste.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-building-o"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["KurumDetay"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('turliste.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-refresh"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["TurIslem"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('aracLocTurListe.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["LokasyonGor"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('islemliste.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-line-chart"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["Raporlar"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('islemliste.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-money"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["BakiyeBilgi"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                </ons-page>
                            </ons-template>
                            <ons-template id="profilliste.html">
                                <ons-page class="profileMain" id="profilListe" name="pMain">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-user"></i> <?php echo $data["Bilgi"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px"> 
                                                    <i class="fa fa-mortar-board"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b id="profilAd"></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="profilTelefon"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="profilEmail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item  modifier="chevron" onclick="ogrenciNavigator.pushPage('map.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <input type="hidden" name="profilLoc" value=""></input>
                                                    <span id="profilAdres"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="" id="veliogrStatus"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="profilDurum"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="veli_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                            <ons-template id="kurumliste.html">
                                <ons-page class="kurumMain" id="kurumListe" name="tMain">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-refresh"></i> <?php echo $data["KurumListe"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list" id="kurumListNone">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-close"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="kurumListNo"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <ons-list modifier="" class="edit-list" id="ogrKurumList" style="display:none">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="kurumdetay.html">
                                <ons-page class="kurumMain" id="kurumDetay" name="pMain">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa fa-building-o"></i> <?php echo $data["Bilgi"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px"> 
                                                    <i class="fa fa-mortar-board"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b id="kurumAd"></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="kurumTelefon"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="kurumEmail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-server"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="kurumWebSite"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item  modifier="chevron" onclick="ogrenciNavigator.pushPage('kurummap.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <input type="hidden" name="kurumLoc" value=""></input>
                                                    <span id="kurumAdres"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                </ons-page>
                            </ons-template>
                            <ons-template id="kurummap.html">
                                <ons-page id="kurummappage">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-map-marker"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                            <ons-template id="turliste.html">
                                <ons-page class="turMain" id="turListe" name="tMain">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-refresh"></i> <?php echo $data["TurListe"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list" id="turListNone">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-close"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="turListNo"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <ons-list modifier="" class="edit-list" id="turList" style="display:none">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="turdetayliste.html">
                                <input type="hidden" name="turListItem" value=""></input>
                                <input type="hidden" name="turListTip" value=""></input>
                                <ons-page class="turDetayMain" id="turDetayListe" name="tDMain">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-refresh"></i> <?php echo $data["TurDetay"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-refresh"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b id="detayTurAd"></b>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="" id="turListAktif"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayAktif"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <input type="hidden" name="turKurumID" value=""></input>
                                            <input type="hidden" name="turKurumLoc" value=""></input>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-building-o"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayKurum"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-calendar"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayGunler"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="detayListAciklama">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-align-justify"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="detayAciklama"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('turdetaymap.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-road"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayKm"></span> KM
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <ons-list modifier="" class="edit-list" id="turDetayList" style="display:none">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="turdetaymap.html">
                                <ons-page id="turDetayMap">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><i class="fa fa-road"></i>           ( <span id="totalKm"></span> )</div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="multiple_lokasyon_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                            <ons-template id="turgiddon.html">
                                <ons-page class="turGidDonMain" id="turGidDon" name="tGDMain">
                                    <input type="hidden" name="turGidisDonusID" value=""></input>
                                    <input type="hidden" name="turGidisDonus" value=""></input>
                                    <ons-toolbar id="gidDonToolBar">
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b id="turgidisBaslik" style="display: none"><i class="fa fa-refresh"></i> <?php echo $data["TurGDetay"]; ?></b><b id="turdonusBaslik" style="display: none"><i class="fa fa-refresh"></i> <?php echo $data["TurDDetay"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list" id="GidDonDetay">
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('aracdetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="giddonPlaka"></span>
                                                    <input type="hidden" name="aracGDID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('sofordetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-male"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="giddonSofor"></span>
                                                    <input type="hidden" name="soforGDID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="detayGidisHostes" modifier="chevron" onclick="ogrenciNavigator.pushPage('hostesdetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-female"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="giddonHostes"></span>
                                                    <input type="hidden" name="hostesGDID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-clock-o"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="giddonSaat"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="GidisHeader"><?php echo $data["TurAyar"]; ?></div>
                                    <ons-list modifier="" class="edit-list">
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('turbildirim.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bell"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["BildirimAlma"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('haftaliktakvim.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-calendar"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["HftlikGun"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('turbildirimmesafe.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-road"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["BildirimMesafe"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="aracdetay.html">
                                <ons-page class="profileMain" name="pMain" id="aracdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-bus"></i> <?php echo $data["AracBilgi"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="aracPlaka"></span></b>
                                                    <input type="hidden" name="aracDetayID" value=""></input>
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
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="sofordetay.html">
                                <ons-page class="profileMain" name="pMain" id="sofordetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-user"></i> <?php echo $data["SoforBilgi"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="sofordetayAd"></span></b>
                                                    <input type="hidden" name="soforDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="sofordetayListTel">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="sofordetayTel"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="sofordetaymail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('soforharita.html', {animation: 'slide'})" id="sofordetayListAdres">
                                            <ons-row >
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="sofordetayadres"></span>
                                                    <input type="hidden" name="sofordetaylocation" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="soforharita.html">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                            <ons-template id="hostesdetay.html">
                                <ons-page class="profileMain" name="pMain" id="hostesdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-user"></i> <?php echo $data["HostesBilgi"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-info"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <b><span id="hostesdetayAd"></span></b>
                                                    <input type="hidden" name="hostesDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="hostesdetayListTel">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-phone-square"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <a href="" id="hostesdetayTel"></a>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-envelope"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="hostesdetaymail"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="ogrenciNavigator.pushPage('hostesharita.html', {animation: 'slide'})" id="hostesdetayListAdres">
                                            <ons-row >
                                                <ons-col width="40px">
                                                    <i class="fa fa-map-marker"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="hostesdetayadres"></span>
                                                    <input type="hidden" name="hostesdetaylocation" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="hostesharita.html">
                                <ons-page id="hostesDetayMap">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;position: absolute; left: 50%;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                            <ons-template id="turbildirimmesafe.html">
                                <ons-page id="turbildirimmesafe">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-cog"></i> <?php echo $data["MesafeAyar"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list id="veliBildAyarList">
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar200" value="200">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    200 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar400" value="400">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    400 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar600" value="600">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    600 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar800" value="800">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    800 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar1000" value="1000">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    1000 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar1200" value="1200">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    1200 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar1400" value="1400">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    1400 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar1600" value="1600">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    1600 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar1800" value="1800">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    1800 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar2000" value="2000">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    2000 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar2200" value="2200">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    2200 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar2400" value="2400">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    2400 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar2600" value="2600">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    2600 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar2800" value="2800">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    2800 m
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="radio-button radio-button--list-item">
                                                <input type="radio" name="a" id="bildayar3000" value="3000">
                                                    <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                    3000 m
                                            </label>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <br />
                                    <ons-bottom-toolbar>
                                        <ons-row>
                                            <ons-col width="49%" style="text-align:left;">
                                                <button class="button button--large" onclick="ogrenciNavigator.popPage()"><i class="fa fa-times"></i></button>
                                            </ons-col>
                                            <ons-col width="2%">
                                            </ons-col>
                                            <ons-col width="49%" style="text-align:right;">
                                                <button class="button button--large" onclick="$.VeliIslemler.bildAyarKaydet()"><i class="fa fa-check"></i></button>
                                            </ons-col>
                                        </ons-row>
                                    </ons-bottom-toolbar>
                                </ons-page>
                            </ons-template>
                            <ons-template id="haftaliktakvim.html">
                                <ons-page id="haftaliktakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-calendar"></i> <?php echo $data["HaftalikTkvm"]; ?></b><b id="haftabasbit" style="margin-left:2%"></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list id="veliTakvimList">
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimPzt" value="1">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Pazartesi"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimSli" value="2">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Sali"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimCrs" value="3">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Carsamba"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimPrs" value="4">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Persembe"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimCma" value="5">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Cuma"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimCmt" value="6">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Cumartesi"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="tkvimPzr" value="7">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["Pazar"]; ?>
                                            </label>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <br />
                                    <ons-bottom-toolbar>
                                        <ons-row>
                                            <ons-col width="49%" style="text-align:left;">
                                                <button class="button button--large" onclick="ogrenciNavigator.popPage()"><i class="fa fa-times"></i></button>
                                            </ons-col>
                                            <ons-col width="2%">
                                            </ons-col>
                                            <ons-col width="49%" style="text-align:right;">
                                                <button class="button button--large" onclick="$.VeliIslemler.hftlikTakvimKaydet()"><i class="fa fa-check"></i></button>
                                            </ons-col>
                                        </ons-row>
                                    </ons-bottom-toolbar>
                                </ons-page>
                            </ons-template>
                            <ons-template id="turbildirim.html">
                                <ons-page id="turbildirim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-refresh"></i> <?php echo $data["TurBildirim"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list id="turBildirimList">
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="bilBasla" value="1">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["TurBslmaBild"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="bildYaklas" value="2">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    &nbsp;&nbsp;<?php echo $data["AracYklstiBild"]; ?>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="bildInmeBinme" value="3">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    <span id="bilYaziBnInGid">&nbsp;&nbsp;<?php echo $data["AracaBinmeBild"]; ?></span>
                                                    <span id="bilYaziBnInDon" style="display:none">&nbsp;&nbsp;<?php echo $data["AracaInmeBild"]; ?></span>
                                            </label>
                                        </ons-list-item>
                                        <ons-list-item modifier="tappable">
                                            <label class="checkbox checkbox--list-item">
                                                <input type="checkbox" name="a" id="bildBitis" value="4">
                                                    <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                                    <span id="bilYaziBtsGid">&nbsp;&nbsp;<?php echo $data["AracKrmaVBild"]; ?></span>
                                                    <span id="bilYaziBtsDon" style="display:none">&nbsp;&nbsp;<?php echo $data["TurBitti"]; ?></span>
                                            </label>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <br />
                                    <ons-bottom-toolbar>
                                        <ons-row>
                                            <ons-col width="49%" style="text-align:left;">
                                                <button class="button button--large" onclick="ogrenciNavigator.popPage()"><i class="fa fa-times"></i></button>
                                            </ons-col>
                                            <ons-col width="2%">
                                            </ons-col>
                                            <ons-col width="49%" style="text-align:right;">
                                                <button class="button button--large" onclick="$.VeliIslemler.turBildirimKydt()"><i class="fa fa-check"></i></button>
                                            </ons-col>
                                        </ons-row>
                                    </ons-bottom-toolbar>
                                </ons-page>
                            </ons-template>
                            <ons-template id="aracLocTurListe.html">
                                <ons-page class="turMain" id="aracLocTurListe" name="tMain">
                                    <input type="hidden" name="aktifTurKurumId" value=""></input>
                                    <input type="hidden" name="aktifTurKurumAd" value=""></input
                                    <input type="hidden" name="aktifTurKurmAd" value=""></input>
                                    <input type="hidden" name="aktifTurAracId" value=""></input>
                                    <input type="hidden" name="aktifTurAracPlaka" value=""></input>
                                    <input type="hidden" name="aktifTurId" value=""></input>
                                    <input type="hidden" name="aktifTurTip" value=""></input>
                                    <input type="hidden" name="aktifTurSfrID" value=""></input>
                                    <input type="hidden" name="aktifTurSfrAd" value=""></input>
                                    <input type="hidden" name="aktifTurSfrLoc" value=""></input>
                                    <input type="hidden" name="aktifTurKm" value=""></input>
                                    <input type="hidden" name="aktifTurGidDon" value=""></input>
                                    <input type="hidden" name="aktifTurKurumLoc" value=""></input>
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="ogrenciNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><b><i class="fa fa-refresh"></i> <?php echo $data["AktifTurListe"]; ?></b></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <ons-list modifier="" class="settings-list" id="aktifTurListNone">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-close"></i>
                                                </ons-col>
                                                <ons-col class="coldty adressbar">
                                                    <span id="aktifTurListNo"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <ons-list modifier="" class="edit-list" id="turAktifList" style="display:none">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>
                            <ons-template id="araclokasyon.html">
                                <ons-page id="aracLokasyon">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="$.VeliIslemler.anlikLocStop()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center"><i class="fa fa-road"></i> <b id="anlikLocGidDon"></b>      ( <span id="totalKm"></span> )</div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="ogrenciNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="multiple_aracloc_map">
                                    </div>
                                </ons-page>
                            </ons-template>
                        </ons-navigator>
                        <ons-modal var="modal" style="text-align:center;">
                            <div class="load">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </ons-modal>
                        <div class="infobox-wrapper">
                            <div id="infobox">
                            </div>
                        </div>
                        </body>
                        </html>