<!DOCTYPE html>
<html>
    <head>
    <title>Shuttle</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/onsenui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/font_awesome/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/onsen-css-components-blue-basic-theme.css">
                <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/timeline.css">
                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/checkbox_list.css">
                        <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/shuttle-mobile-app.min.css">
                            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PLUGINMVELI_CSS ?>/shuttle-mobile-app.css.map">

                                <script src="<?php echo SITE_PLUGINMVELI_JS ?>/angular/angular.js"></script>
                                <script src="<?php echo SITE_PLUGINMVELI_JS ?>/jquery-2.1.4.min.js"></script>
                                <script src="<?php echo SITE_PLUGINMVELI_JS ?>/onsenui.js"></script>
                                <script src="<?php echo SITE_PLUGINMVELI_JS ?>/duyuruajaxquery.js"></script>
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
                                    <ons-page id="anasayfa.html">
                                        <ons-toolbar>
                                            <div class="left"><i class="fa fa-bullhorn"></i> <?php echo $data["DuyuruIslem"]; ?></div>
                                        </ons-toolbar>
                                        <br />
                                        <ons-list modifier="" class="person-list" var="listnavigator">
                                            <ons-list-item class="person" modifier="chevron" onclick="duyuruNavigator.pushPage('duyuruyolcu.html', {animation: 'slide'})">
                                                <ons-row>
                                                    <ons-col width="40px"><i class="fa fa-paper-plane"></i></ons-col>
                                                    <ons-col class="person-name">
                                                        <?php echo $data["DuyuruGonder"]; ?>
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
                                        <br />
                                        <div class="settings-header" id="GidisHeader"><?php echo $data["DuyuruAyar"]; ?></div>
                                        <ons-list modifier="" class="edit-list">
                                            <ons-list-item modifier="chevron" onclick="duyuruNavigator.pushPage('duyuruayar.html', {animation: 'slide'})">
                                                <ons-row>
                                                    <ons-col width="40px">
                                                        <i class="fa fa-bell"></i>
                                                    </ons-col>
                                                    <ons-col class="coldty">
                                                        <?php echo $data["DuyuruBilAyar"]; ?>
                                                    </ons-col>
                                                </ons-row>
                                            </ons-list-item>
                                        </ons-list>
                                    </ons-page>
                                    <ons-template id="duyuruyolcu.html">
                                        <ons-page id="duyuruyolcu">
                                            <input type="hidden" name="veliAd" value=""></input>
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;position: absolute; left: 50%;"><i class="fa fa-users"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br/>
                                            <div class="settings-header" id="ogrenciHeader" style="display:none;overflow: hidden;"><?php echo $data["Ogrenci"]; ?> (<span id="ogrenciToplam"></span>)</div><label class="checkbox" id="ogrenciChechk" style="display:none;"><input type="checkbox" checked="checked" id="ogrenciSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="ogrenciList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div class="settings-header" id="yoneticiHeader" style="display:none;overflow: hidden;"><?php echo $data["Yonetici"]; ?> (<span id="yoneticiToplam"></span>)</div><label class="checkbox" id="yoneticiChechk" style="display:none"><input type="checkbox" checked="checked" id="yoneticiSign"><div class="checkbox__checkmark"></div></label>
                                            <ons-list id="yoneticiList" style="display:none">
                                            </ons-list>
                                            <br />
                                            <div style="padding: 10px 9px; display: none" id="duyuruYzbtn">
                                                <ons-button modifier="large" style="margin: 0 auto;" onclick="$.VeliIslemler.veliDuyuruSec()">
                                                    <?php echo $data["DuyuruYaz"]; ?>
                                                </ons-button>
                                            </div>
                                        </ons-page>
                                    </ons-template>
                                    <ons-template id="duyurugonder.html">
                                        <ons-page id="duyurugonder">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;position: absolute; left: 50%;"><i class="fa fa-paper-plane"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                            </ons-toolbar>
                                            <ons-list-item>
                                                <input type="text" name="toplamKisi" class="text-input text-input--transparent" style="width: 100%" value="">
                                            </ons-list-item>

                                            <ons-list-item>
                                                <textarea class="textarea textarea--transparent" placeholder="<?php echo $data["Mesaj"]; ?>" style="width: 100%; height: 100px;" id="duyuruText"></textarea>
                                            </ons-list-item>

                                            <div style="padding: 10px 9px">
                                                <ons-button modifier="large" style="margin: 0 auto;" onclick="$.VeliIslemler.veliDuyuruGonder()">
                                                    <?php echo $data["DuyuruGonder"]; ?>
                                                </ons-button>
                                            </div>
                                        </ons-page>
                                    </ons-template>
                                    <ons-template id="duyurugecmis.html">
                                        <ons-page id="duyurugecmis">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center" style="font-size:24px; color:#007427;position: absolute;left: 50%;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
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
                                                <div class="center" style="font-size:24px; color:#007427;position: absolute;left: 50%;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
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
                                                <div class="center" style="font-size:24px; color:#007427;position: absolute;left: 50%;"><i class="fa fa-reorder"></i></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <ons-list class="timeline" modifier="inset" id="gonderilenduyuruList">
                                            </ons-list>
                                        </ons-page>
                                    </ons-template>
                                    <ons-template id="duyuruayar.html">
                                        <ons-page id="duyuruayar">
                                            <ons-toolbar>
                                                <div class="left"><ons-button class="back" modifier="quiet" onclick="duyuruNavigator.popPage()"><i class="top-icon fa fa-chevron-left"></i></ons-button></div>
                                                <div class="center"><b><i class="fa fa-cog"></i> <?php echo $data["DuyuruAyar"]; ?></b></div>
                                                <div class="right"><ons-button class="resetpage" modifier="quiet" onclick="duyuruNavigator.resetToPage(0, {animation: 'slide'})"><i class="top-icon fa fa-home"></i></ons-button></div>
                                            </ons-toolbar>
                                            <br />
                                            <ons-list id="veliDuyrAyarList">
                                                <ons-list-item modifier="tappable">
                                                    <label class="radio-button radio-button--list-item">
                                                        <input type="radio" name="a" id="duyral1">
                                                            <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                            <?php echo $data["DuyuruAl"]; ?>
                                                    </label>
                                                </ons-list-item>
                                                <ons-list-item modifier="tappable">
                                                    <label class="radio-button radio-button--list-item">
                                                        <input type="radio" name="a" id="duyral0">
                                                            <div class="radio-button__checkmark radio-button--list-item__checkmark"></div>
                                                            <?php echo $data["DuyuruAlma"]; ?>
                                                    </label>
                                                </ons-list-item>
                                            </ons-list>
                                            <br />
                                            <br />
                                            <ons-bottom-toolbar>
                                                <ons-row>
                                                    <ons-col width="49%" style="text-align:left;">
                                                        <button class="button button--large" onclick="duyuruNavigator.popPage()"><i class="fa fa-times"></i></button>
                                                    </ons-col>
                                                    <ons-col width="2%">
                                                    </ons-col>
                                                    <ons-col width="49%" style="text-align:right;">
                                                        <button class="button button--large" onclick="$.VeliIslemler.duyrAyarKaydet()"><i class="fa fa-check"></i></button>
                                                    </ons-col>
                                                </ons-row>
                                            </ons-bottom-toolbar>
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