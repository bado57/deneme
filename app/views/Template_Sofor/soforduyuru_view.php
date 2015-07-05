<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsenui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/font_awesome/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/onsen-css-components-blue-basic-theme.css">
                <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/timeline.css">
                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/checkbox_list.css">
                        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.min.css">
                            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMSOFOR_CSS ?>/shuttle-mobile-app.css.map">

                                <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/angular/angular.js"></script>
                                <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/jquery-2.1.4.min.js"></script>
                                <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/onsenui.js"></script>
                                <script src="<?php echo SITE_PLUGINMSOFOR_JS ?>/duyuruajaxquery.js"></script>
                                <script src="<?php echo MLANGUAGE_JS . $model['dil']; ?>.js"></script>
                                <script src="<?php echo SITE_MPLUGIN_JS; ?>/validation.js"></script>
                                <script type="text/javascript">
                                    ons.bootstrap();</script>
                                </head>
                                <body>
                                <input type="hidden" name="id" value="<?php echo $model['id']; ?>"></input>
                                <input type="hidden" name="firmaId" value="<?php echo $model['FirmaId']; ?>"></input>
                                <input type="hidden" name="lang" value="<?php echo $model['dil']; ?>"></input>
                                <input type="hidden" name="enlem" value="<?php echo $model['enlem']; ?>"></input>
                                <input type="hidden" name="boylam" value="<?php echo $model['boylam']; ?>"></input>
                                <input type="hidden" name="location" value="<?php echo $model['Location']; ?>"></input>

                                <ons-navigator title="<?php echo $data["DuyuruIslem"]; ?>" var="duyuruNavigator">

                                    <ons-page>
                                        <ons-toolbar>
                                            <div class="left"><i class="fa fa-bullhorn"></i> <?php echo $data["DuyuruIslem"]; ?></div>
                                        </ons-toolbar>
                                        <br />
                                        <ons-list modifier="" class="person-list" var="listnavigator">
                                            <ons-list-item class="person" modifier="chevron" onclick="duyuruNavigator.pushPage('duyurutur.html', {animation: 'slide'})">
                                                <ons-row>
                                                    <ons-col width="40px"><i class="fa fa-reorder"></i></ons-col>
                                                    <ons-col class="person-name">
                                                        <?php echo $data["TurListe"]; ?>
                                                    </ons-col>
                                                </ons-row>
                                            </ons-list-item>
                                            <ons-list-item class="person" modifier="chevron" onclick="duyuruNavigator.pushPage('duyurugecmis.html', {animation: 'slide'})">
                                                <ons-row>
                                                    <ons-col width="40px"><i class="fa fa-history"></i></ons-col>
                                                    <ons-col class="person-name">
                                                        <?php echo $data["DuyuruGecmis"]; ?>
                                                    </ons-col>
                                                </ons-row>
                                            </ons-list-item>
                                        </ons-list>
                                    </ons-page>

                                    <ons-template id="duyurutur.html">
                                        <ons-page id="duyurutur">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <div class="settings-header" id="turHeader" style="display:none"><?php echo $data["TurListe"]; ?> (<span id="turToplam"></span>)</div>
                                            <ons-list id="turList" style="display:none">
                                            </ons-list>
                                        </ons-page>
                                    </ons-template>

                                    <ons-template id="duyuruyolcu.html">
                                        <ons-page id="duyuruyolcu">
                                            <input type="hidden" name="soforAd" value=""></input>
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-users"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <div class="right"><ons-button class="back" modifier="quiet" onclick="$.SoforIslemler.soforDuyuruSec()"><i class="top-icon fa fa-paper-plane"></i></ons-button></div>
                                            <br/>
                                            <br />
                                            <div class="settings-header" id="turYolcuHeader" style="display:none"><?php echo $data["Yolcu"]; ?> (<span id="yolcuToplam"></span>)</div><label class="checkbox" id="yolcuChechk" style="display:none"><input type="checkbox" checked="checked" id="yolcuSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="turYolcuList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div class="settings-header" id="turVeliHeader" style="display:none"><?php echo $data["Veli"]; ?> (<span id="veliToplam"></span>)</div><label class="checkbox" id="veliChechk" style="display:none"><input type="checkbox" checked="checked" id="veliSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="turVeliList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div class="settings-header" id="turSoforHeader" style="display:none"><?php echo $data["Sofor"]; ?> (<span id="soforToplam"></span>)</div><label class="checkbox" id="soforChechk" style="display:none"><input type="checkbox" checked="checked" id="soforSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="turSoforList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div class="settings-header" id="turHostesHeader" style="display:none"><?php echo $data["Hostes"]; ?> (<span id="hostesToplam"></span>)</div><label class="checkbox" id="hostesChechk" style="display:none"><input type="checkbox" checked="checked" id="hostesSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="turHostesList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div class="settings-header" id="turYoneticiHeader" style="display:none"><?php echo $data["Yonetici"]; ?> (<span id="yoneticiToplam"></span>)</div><label class="checkbox" id="yoneticiChechk" style="display:none"><input type="checkbox" checked="checked" id="yoneticiSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="turYoneticiList" style="display:none">
                                            </ons-list>
                                            <br />
                                        </ons-page>
                                    </ons-template>

                                    <ons-template id="duyurugonder.html">
                                        <ons-page id="duyurugonder">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <ons-list-item>
                                                <input type="text" name="toplamKisi" class="text-input text-input--transparent" style="width: 100%" value="">
                                            </ons-list-item>

                                            <ons-list-item>
                                                <textarea class="textarea textarea--transparent" placeholder="<?php echo $data["Mesaj"]; ?>" style="width: 100%; height: 100px;" id="duyuruText"></textarea>
                                            </ons-list-item>

                                            <div style="padding: 10px 9px">
                                                <ons-button modifier="large" style="margin: 0 auto;" onclick="$.SoforIslemler.soforDuyuruGonder()">
                                                    <?php echo $data["DuyuruGonder"]; ?>
                                                </ons-button>
                                            </div>
                                        </ons-page>
                                    </ons-template>

                                    <ons-template id="duyurugecmis.html">
                                        <ons-page id="duyurugecmis">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <ons-list modifier="" class="person-list" var="listnavigator">
                                                <ons-list-item class="person" modifier="chevron" onclick="duyuruNavigator.pushPage('gelenduyuru.html', {animation: 'slide'})">
                                                    <ons-row>
                                                        <ons-col width="40px"><i class="fa fa-arrow-left"></i></ons-col>
                                                        <ons-col class="person-name">
                                                            <?php echo $data["GelDuyuru"]; ?>
                                                        </ons-col>
                                                    </ons-row>
                                                </ons-list-item>
                                                <ons-list-item class="person" modifier="chevron" onclick="duyuruNavigator.pushPage('gonderilenduyuru.html', {animation: 'slide'})">
                                                    <ons-row>
                                                        <ons-col width="40px"><i class="fa fa-arrow-right"></i></ons-col>
                                                        <ons-col class="person-name">
                                                            <?php echo $data["GonDuyuru"]; ?>
                                                        </ons-col>
                                                    </ons-row>
                                                </ons-list-item>
                                            </ons-list>
                                        </ons-page>
                                    </ons-template>

                                    <ons-template id="gelenduyuru.html">
                                        <ons-page id="gelenduyuru">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <ons-list class="timeline" modifier="inset" id="gelenduyuruList">
                                            </ons-list>
                                        </ons-page>
                                    </ons-template>

                                    <ons-template id="gonderilenduyuru.html">
                                        <ons-page id="gonderilenduyuru">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-reorder"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <ons-list class="timeline" modifier="inset" id="gonderilenduyuruList">
                                            </ons-list>
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