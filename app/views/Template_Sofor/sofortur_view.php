<!DOCTYPE html>
<html>
    <head>
    <title>Shuttle</title>
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
                        <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/turajaxquery.js"></script>
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

                        <ons-navigator title="<?php echo $data["TurListe"]; ?>" var="turNavigator">

                            <ons-page>
                                <ons-toolbar>
                                    <div class="left"><i class="fa fa-reorder"></i> <?php echo $data["TurListe"]; ?></div>
                                </ons-toolbar>
                                <br />
                                <ons-list modifier="" class="person-list" var="listnavigator">
                                    <?php if (count($model) > 0) { ?>
                                        <?php foreach ($model as $turModel) { ?>
                                            <ons-list-item class="person" modifier="chevron" onclick="turNavigator.pushPage('turdetay.html', {animation: 'slide', turID: <?php echo $turModel['ID']; ?>})">
                                                <ons-row>
                                                    <ons-col width="20px"></ons-col>
                                                    <ons-col class="person-name">
                                                        <?php echo $turModel['Ad']; ?>
                                                    </ons-col>
                                                </ons-row>
                                            </ons-list-item>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <ons-list-item class="person">
                                            <ons-row>
                                                <ons-col width="20px"></ons-col>
                                                <ons-col class="person-name">
                                                    <?php echo $data['TurYok']; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    <?php } ?>
                                </ons-list>
                            </ons-page>

                            <ons-template id="turdetay.html" var="detayNavigator">
                                <input type="hidden" name="turListItem" value=""></input>
                                <ons-page id="turdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-info-circle"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["TurBilgi"]; ?></div>
                                    <ons-list modifier="" class="settings-list">
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-info-circle"></i>
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
                                            <input type="hidden" name="turListBolge" value=""></input>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-th"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayBolge"></span>
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
                                            <input type="hidden" name="turListTip" value=""></input>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-mortar-board"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="detayTip"></span>
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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('turyolcu.html', {animation: 'slide'})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-users"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <?php echo $data["YolcuBilgi"]; ?>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('turdetaymap.html', {animation: 'slide'})">
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
                                    <div class="settings-header" id="GidisHeader"><?php echo $data["Gidis"]; ?></div>
                                    <ons-list modifier="" class="settings-list" id="GidisDetay">
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('aracdetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="gidisPlaka"></span>
                                                    <input type="hidden" name="aracGDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('sofordetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-male"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="gidisSofor"></span>
                                                    <input type="hidden" name="soforGDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="detayGidisHostes" modifier="chevron" onclick="turNavigator.pushPage('hostesdetay.html', {animation: 'slide', gidistip: 0})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-female"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="gidisHostes"></span>
                                                    <input type="hidden" name="hostesGDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-clock-o"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="gidisSaat"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="DonusHeader"><?php echo $data["Donus"]; ?></div>
                                    <ons-list modifier="" class="settings-list" id="DonusDetay">
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('aracdetay.html', {animation: 'slide', gidistip: 1})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-bus"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="donusPlaka"></span>
                                                    <input type="hidden" name="aracDDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('sofordetay.html', {animation: 'slide', gidistip: 1})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-male"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="donusSofor"></span>
                                                    <input type="hidden" name="soforDDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item id="detayDonusHostes" modifier="chevron" onclick="turNavigator.pushPage('hostesdetay.html', {animation: 'slide', gidistip: 1})">
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-female"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="donusHostes"></span>
                                                    <input type="hidden" name="hostesDDetayID" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="fa fa-clock-o"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="donusSaat"></span>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                    </ons-list>
                                    <br /><br />
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="turyolcu.html">
                                <ons-page id="turyolcu">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-users"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header" id="turYolcuHeader" style="display:none"><?php echo $data["Yolcu"]; ?> (<span id="yolcuToplam"></span>)</div>
                                    <ons-list modifier="" class="person-list" id="turYolcuList" style="display:none">
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="turSoforHeader" style="display:none"><?php echo $data["Sofor"]; ?> (<span id="soforToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="turSoforList" style="display:none">
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="turHostesHeader" style="display:none"><?php echo $data["Hostes"]; ?> (<span id="hostesToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="turHostesList" style="display:none">
                                    </ons-list>
                                    <br />
                                    <div class="settings-header" id="turYoneticiHeader" style="display:none"><?php echo $data["Yonetici"]; ?> (<span id="yoneticiToplam"></span>)</div>
                                    <ons-list modifier="" class="yolcu-list" id="turYoneticiList" style="display:none">
                                    </ons-list>
                                    <br />
                                    <br />
                                </ons-page>
                            </ons-template>

                            <ons-template id="sofordetay.html">
                                <ons-page class="profileMain" name="pMain" id="sofordetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["SoforBilgi"]; ?> </div>

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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('soforharita.html', {animation: 'slide'})" id="sofordetayListAdres">
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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('sofortakvim.html', {animation: 'slide'})">
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
                                </ons-page>
                            </ons-template>

                            <ons-template id="soforharita.html">
                                <ons-page id="detayMap">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="sofortakvim.html">
                                <ons-page id="sofortakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-calendar"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div id="aracTakvim" class="settings-header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="margin-bottom: 10px"><?php echo $data["Takvim"]; ?> (<b><span id="takvimSofor"></span></b>)</div>
                                                <div class="row" id="getPartialView">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="hostesdetay.html">
                                <ons-page class="profileMain" name="pMain" id="hostesdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["HostesBilgi"]; ?> </div>

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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('hostesharita.html', {animation: 'slide'})" id="hostesdetayListAdres">
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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('hostestakvim.html', {animation: 'slide'})">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="sofor_map">
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="hostestakvim.html">
                                <ons-page id="hostestakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-calendar"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div id="aracTakvim" class="settings-header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="margin-bottom: 10px"><?php echo $data["Takvim"]; ?> (<b><span id="takvimHostes"></span></b>)</div>
                                                <div class="row" id="getPartialView">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="yolcudetay.html">
                                <ons-page class="profileMain" name="pMain" id="yolcudetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-user"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
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
                                                    <input type="hidden" name="yolcuid" value=""></input>
                                                </ons-col>
                                            </ons-row>
                                        </ons-list-item>
                                        <ons-list-item>
                                            <ons-row>
                                                <ons-col width="40px">
                                                    <i class="" id="kdetayIcon"></i>
                                                </ons-col>
                                                <ons-col class="coldty">
                                                    <span id="kdetaytur"></span>
                                                    <input type="hidden" name="inputtur" value=""></input>
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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('turharita.html', {animation: 'slide'})" id="kdetayListAdres">
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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('yolcutakvim.html', {animation: 'slide'})" id="yolcuDetayTakvim">
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
                                    <div class="settings-header" id="vdetayheader" style="display:none"><?php echo $data["VeliBilgi"]; ?></div>
                                    <ons-list modifier="" class="settings-list" id="vdetaylist" style="display:none">
                                    </ons-list>
                                    <br />
                                </ons-page>
                            </ons-template>

                            <ons-template id="yolcutakvim.html">
                                <ons-page id="yolcutakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-calendar"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div id="aracTakvim" class="settings-header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="margin-bottom: 10px"><?php echo $data["Takvim"]; ?> (<b><span id="takvimYolcu"></span></b>)</div>
                                                <div class="row" id="getPartialView">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="aracdetay.html">
                                <ons-page class="profileMain" name="pMain" id="aracdetay">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-bus"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div class="settings-header"><?php echo $data["AracBilgi"]; ?> </div>

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
                                        <ons-list-item modifier="chevron" onclick="turNavigator.pushPage('aractakvim.html', {animation: 'slide'})">
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
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-road"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <div class="google-maps" id="multiple_lokasyon_map">
                                    </div>
                                </ons-page>
                            </ons-template>

                            <ons-template id="aractakvim.html">
                                <ons-page id="aractakvim">
                                    <ons-toolbar>
                                        <div class="left"><ons-button class="back" modifier="quiet" onclick="turNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                        <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-calendar"></i></div>
                                        <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="turNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                    </ons-toolbar>
                                    <br />
                                    <div id="aracTakvim" class="settings-header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="margin-bottom: 10px"><?php echo $data["Takvim"]; ?> (<b><span id="takvimArac"></span></b>)</div>
                                                <div class="row" id="getPartialView">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
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