<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Jquery Mobile CSS -->
    <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css" />
    <!-- Jquery Mobile Icons CSS -->
    <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquery.mobile.icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Shuttle Mobile CSS -->
    <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/shuttle.mobile.css" rel="stylesheet" type="text/css" />

    <!-- Jquery -->
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/jquery.min.js" type="text/javascript"></script>
    <!-- Jquery Mobile JS-->
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/jquery.mobile-1.4.5.min.js" type="text/javascript"></script>
    <!-- Shuttle Mobile JS-->
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/shuttle-mobile-app.js" type="text/javascript"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/adminajax.mobile.js" type="text/javascript"></script>

    <!-- Google Maps Api -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

</head>
<body>
<div data-role="page" id="bolgeMain">
    <input type="hidden" name="adminUserID" value="<?php echo $model[0]['AdminUserID']; ?>">
        <input type="hidden" name="adminRutbe" value="<?php echo $rutbe; ?>">
            <input type="hidden" name="adminUsername" value="<?php echo $model[0]['AdminUsername']; ?>">
                <input type="hidden" name="adminFirmId" value="<?php echo $model[0]['AdminFirmaId']; ?>">
                    <input type="hidden" name="enlem" value="<?php echo $model[0]['enlem']; ?>">
                        <input type="hidden" name="boylam" value="<?php echo $model[0]['boylam']; ?>">
                            <div data-role="header" data-position="fixed">
                                <form class="ui-filterable" style="">
                                    <input id="bolgeFilter" data-type="search">
                                </form>
                            </div>
                            <div data-role="main" class="ui-content">
                                <ul id="bolgeList" data-role="listview" data-filter="true" data-input="#bolgeFilter">
                                    <?php foreach ($model as $bolgeModel) { ?>
                                        <li><a data-destination="#bolgeDetay" class="jmID" data-transition="slide" value="<?php echo $bolgeModel['AdminBolgeID']; ?>"><?php echo $bolgeModel['AdminBolge']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div data-role="footer" data-position="fixed">
                                <a href="#yeniBolge" class="ui-btn ui-inline ui-corner-all ui-icon-plus ui-btn-icon-notext" data-transition="slide">Yeni Ekle</a>
                            </div>
                            </div>

                            <div data-role="page" id="yeniBolge" class="jmRun" data-islemler="adminBolgeYeni">
                                <div data-role="header">
                                    <h1><?php echo $data["BolgeYeni"]; ?></h1>
                                </div>
                                <div data-role="main" class="ui-content">
                                    <label for="bolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                                    <input type="text" name="bolgeAdi" id="bolgeAdi" required>
                                        <label for="bolgeAciklama"><?php echo $data["Aciklama"]; ?></label>
                                        <textarea type="text" name="bolgeAciklama" id="bolgeAciklama"></textarea>
                                        <div data-role="controlgroup" data-type="horizontal">
                                            <a data-islemler="adminBolgeKaydet" class="ui-btn ui-inline ui-corner-all fs-13 jmToggle"  data-transition="slide"  data-theme="b" ><?php echo $data["Kaydet"]; ?></a>
                                            <a class="ui-btn ui-inline ui-corner-all fs-13" data-rel="back" data-transition="slide"><?php echo $data["Vazgec"]; ?></a>
                                        </div>
                                </div>
                                <div data-role="footer" data-position="fixed">
                                    <a href="" class="ui-btn ui-inline ui-corner-all ui-icon-carat-l ui-btn-icon-notext" data-rel="back" data-transition="slide"></a>
                                    <a href="#bolgeMain" class="ui-btn ui-inline ui-corner-all ui-icon-home ui-btn-icon-notext" data-transition="slide"></a>
                                </div>
                            </div>

                            <div data-role="page" id="bolgeDetay" class="jmRun" data-islemler="adminBolgeDetail">
                                <div data-role="header" data-position="fixed">
                                    <div data-role="navbar">
                                        <ul>
                                            <li><a href="#" class="ui-btn ui-icon-info ui-btn-icon-left ui-btn-active" ><?php echo $data["GenelBilgi"]; ?></a></li>
                                            <li><a href="#bolgeKurum" class="ui-btn ui-icon-grid ui-btn-icon-left" ><?php echo $data["Kurumlar"]; ?></a></li>
                                            <li><a href="#bolgeKurumEkle" class="ui-btn ui-icon-plus ui-btn-icon-left"><?php echo $data["KurumEkle"]; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div data-role="main" class="ui-content">
                                    <input id="adminBolgeDetailID" name="adminBolgeDetailID" type="hidden" value="" />
                                    <div class="form-group">
                                        <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                                        <input type="text" class="form-control dsb" id="BolgeAdi" name="BolgeDetailAdi" value="" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                                        <textarea name="BolgeDetailAciklama" class="form-control dsbtext" rows="3" disabled=""></textarea>
                                    </div>

                                </div>
                                <div data-role="footer" data-position="fixed">
                                    <a href="#" class="ui-btn ui-inline ui-corner-all ui-icon-carat-l ui-btn-icon-notext" data-rel="back" data-transition="slide"></a>
                                    <div class="form-group submit-group">
                                        <button type="button" class="btn btn-default vzg" data-Vzgislem="adminBolgeDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                                        <button type="button" class="btn btn-success save" data-Saveislem="adminBolgeDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                                    </div>
                                    <div class="form-group edit-group">
                                        <button id="editForm" type="button" data-Editislem="adminBolgeDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                                        <button id="adminBolgeDetailSil" type="button" class="btn btn-danger jmToggle" data-transition="slide"  data-islemler="adminBolgeDetailSil"><?php echo $data["Sil"]; ?></button>
                                    </div>
                                    <a href="#bolgeMain" class="ui-btn ui-inline  ui-corner-all ui-icon-home ui-btn-icon-notext" data-transition="slide"></a>
                                </div>
                            </div>

                            <div data-role="page" id="bolgeKurum" class="jmRun" data-islemler="adminBolgeKurum">
                                <div data-role="header" data-position="fixed">
                                    <div data-role="navbar">
                                        <ul>
                                            <li><a href="#bolgeDetay" class="ui-btn ui-icon-info ui-btn-icon-left"><?php echo $data["GenelBilgi"]; ?></a></li>
                                            <li><a href="#" class="ui-btn ui-icon-grid ui-btn-icon-left ui-btn-active" ><?php echo $data["Kurumlar"]; ?></a></li>
                                            <li><a href="#bolgeKurumEkle" class="ui-btn ui-icon-plus ui-btn-icon-left" ><?php echo $data["KurumEkle"]; ?></a></li>
                                        </ul>
                                    </div>
                                    <form class="ui-filterable">
                                        <input id="bolgeKurumFilter" data-type="search">
                                    </form>
                                </div>
                                <div data-role="main" class="ui-content">
                                    <ul id="bolgeKurumList" data-role="listview" data-filter="true" data-input="#bolgeKurumFilter">
                                    </ul>
                                </div>
                                <div data-role="footer" data-position="fixed">
                                    <a href="#" class="ui-btn ui-inline ui-corner-all ui-icon-carat-l ui-btn-icon-notext" data-rel="back" data-transition="slide"></a>
                                    <a href="#bolgeMain" class="ui-btn ui-inline ui-corner-all ui-icon-home ui-btn-icon-notext" data-transition="slide"></a>
                                </div>
                            </div>

                            <div data-role="page" id="bolgeKurumEkle" class="jmRun" data-islemler="adminBolgeDetailYeniEkle">
                                <div data-role="header" data-position="fixed">
                                    <div data-role="navbar">
                                        <ul>
                                            <li><a href="#bolgeDetay" class="ui-btn ui-icon-info ui-btn-icon-left"><?php echo $data["GenelBilgi"]; ?><</a></li>
                                            <li><a href="#bolgeKurum" class="ui-btn ui-icon-grid ui-btn-icon-left"><?php echo $data["Kurumlar"]; ?></a></li>
                                            <li><a href="#" class="ui-btn ui-icon-plus ui-btn-icon-left ui-btn-active"><?php echo $data["KurumEkle"]; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div data-role="main" class="ui-content">
                                    <form>
                                        <input id="adminBolgeKurumEkleID" name="adminBolgeKurumEkleID" type="hidden" value="" />
                                        <label for="KurumAdi"><?php echo $data["KurumAdi"]; ?></label>
                                        <input type="text" name="KurumAdi" id="KurumAdi" required>
                                            <label for="KurumLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                                            <div class="ui-field-contain">
                                                <fieldset data-role="controlgroup">
                                                    <legend><a data-destination="#bolgeKurumLokasyonEkle" class="jmSingleValue ui-btn ui-inline ui-corner-all ui-icon-location ui-btn-icon-notext"></a></legend>   
                                                    <input type="text" name="KurumLokasyon" id="KurumLokasyon" class="locationInput" disabled>	
                                                </fieldset>
                                            </div>

                                            <label for="KurumTelefon"><?php echo $data["Telefon"]; ?></label>
                                            <input type="number" name="KurumTelefon" id="KurumTelefon">

                                                <label for="KurumEmail"><?php echo $data["Email"]; ?></label>
                                                <input type="email" name="KurumEmail" id="KurumEmail">

                                                    <label for="KurumWebSite"><?php echo $data["WebSite"]; ?></label>
                                                    <input type="text" name="KurumWebSite" id="KurumWebSite">
                                                        <label for="KurumAdresDetay"><?php echo $data["Adres"]; ?></label>
                                                        <textarea name="KurumAdresDetay" id="KurumAdresDetay"></textarea>
                                                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                                                        <textarea name="Aciklama" id="Aciklama"></textarea>

                                                        <label for="KurumUlke"><?php echo $data["Ulke"]; ?></label>
                                                        <input type="text" name="country" id="KurumUlke" disabled>

                                                            <label for="KurumSehir"><?php echo $data["Il"]; ?></label>
                                                            <input type="text" name="administrative_area_level_1" id="KurumSehir" disabled>

                                                                <label for="KurumIlce"><?php echo $data["Ilce"]; ?></label>
                                                                <input type="text" name="administrative_area_level_2" id="KurumIlce" disabled>

                                                                    <label for="KurumSemt"><?php echo $data["Semt"]; ?></label>
                                                                    <input type="text" name="locality" id="KurumSemt" disabled>

                                                                        <label for="KurumMahalle"><?php echo $data["Mahalle"]; ?></label>
                                                                        <input type="text" name="neighborhood" id="KurumMahalle" disabled>

                                                                            <label for="KurumSokak"><?php echo $data["Sokak"]; ?></label>
                                                                            <input type="text" name="route" id="KurumSokak" disabled>

                                                                                <label for="street_number"><?php echo $data["CaddeNo"]; ?></label>
                                                                                <input type="text" name="street_number" id="street_number" disabled>

                                                                                    <label for="KurumPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                                                                                    <input type="text" name="postal_code" id="KurumPostaKodu" disabled>
                                                                                        </form>
                                                                                        </div>
                                                                                        <div data-role="footer" data-position="fixed">
                                                                                            <a href="#" class="ui-btn ui-inline ui-corner-all ui-icon-carat-l ui-btn-icon-notext" data-rel="back" data-transition="slide"></a>
                                                                                            <button type="button" class="btn btn-success save" data-Saveislem="adminBolgeKurumKaydet"><?php echo $data["Kaydet"]; ?></button>
                                                                                            <a href="#bolgeMain" class="ui-btn ui-inline ui-corner-all ui-icon-home ui-btn-icon-notext" data-transition="slide"></a>
                                                                                        </div>
                                                                                        </div>

                                                                                        <div data-role="page" id="bolgeKurumLokasyonEkle" class="singleMap">
                                                                                            <div data-role="main" class="ui-content" style="padding: 0;">
                                                                                                <div id="single_map" style="width:100% !important;"></div>
                                                                                            </div>
                                                                                            <div id="mapFooter" data-role="footer" data-position="fixed">
                                                                                                <a id="saveMap" href="#bolgeKurumEkle" class="ui-btn ui-inline ui-corner-all" data-mini="true" data-theme="c"><?php echo $data["Kaydet"]; ?></a>
                                                                                                <a href="#" class="ui-btn ui-inline ui-corner-all" data-mini="true"  data-rel="back" data-transition="slide"><?php echo $data["Vazgec"]; ?></a>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div data-role="page" id="bolgeKurumLokasyon" class="multiMap">
                                                                                            <div data-role="main" class="ui-content" style="padding: 0;">
                                                                                                <div id="multiple_map" style="width:100% !important;"></div>
                                                                                            </div>
                                                                                            <div id="multiMapFooter" data-role="footer" data-position="fixed">
                                                                                                <a href="#" class="ui-btn ui-inline ui-corner-all ui-icon-carat-l ui-btn-icon-notext" data-rel="back" data-transition="slide"></a>
                                                                                                <a href="#bolgeMain" class="ui-btn ui-inline ui-corner-all ui-icon-home ui-btn-icon-notext" data-transition="slide"></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        </body>
                                                                                        </html>
