<!DOCTYPE html>
<html lang="tr">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/font-awesome.min.css" />

    <!-- jQueryMobileCSS - original without styling -->
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquery.mobile-1.4.5.min.css" />

    <!-- nativeDroid core CSS -->
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquerymobile.nativedroid.css" />

    <!-- nativeDroid: Light/Dark -->
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquerymobile.nativedroid.light.css"  id='jQMnDTheme' />

    <!-- nativeDroid: Color Schemes -->
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/jquerymobile.nativedroid.color.green.css" id='jQMnDColor' />
    
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/shuttle.mobile.css" />

    <!-- jQuery / jQueryMobile Scripts -->
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/jquery-1.9.1.min.js"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/jquery.mobile-1.4.5.min.js"></script>

    <!-- Shuttle Mobile JS-->
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/shuttle-mobile-app.js" type="text/javascript"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/adminajax.mobile.js" type="text/javascript"></script>

    <!-- Google Maps Api -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

</head>
<body>
<div data-role="page" id="bolgeMain" data-theme="b">
    <input type="hidden" name="adminUserID" value="<?php echo $model[0]['AdminUserID']; ?>">
    <input type="hidden" name="adminRutbe" value="<?php echo $rutbe; ?>">
    <input type="hidden" name="adminUsername" value="<?php echo $model[0]['AdminUsername']; ?>">
    <input type="hidden" name="adminFirmId" value="<?php echo $model[0]['AdminFirmaId']; ?>">
    <input type="hidden" name="enlem" value="<?php echo $model[0]['enlem']; ?>">
    <input type="hidden" name="boylam" value="<?php echo $model[0]['boylam']; ?>">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme='b'>
        <form class="ui-filterable" style="margin-bottom: 0; padding-left: 10px;">
            <input id="bolgeFilter" data-type="search">
        </form>
    </div>
    <div data-role="content">
        <ul id="bolgeList" data-role="listview" data-filter="true" data-input="#bolgeFilter" data-inset="false" data-icon="false" data-divider-theme="b">
            <?php foreach ($model as $bolgeModel) { ?>
                <li><a data-destination="#bolgeDetay" class="jmID" data-transition="slide" value="<?php echo $bolgeModel['AdminBolgeID']; ?>"><i class='fa fa-angle-right'></i> <?php echo $bolgeModel['AdminBolge']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div data-position="fixed" data-tap-toggle="false" data-role="footer" data-theme='b'>
	<div data-role="navbar">
            <ul>
                <li class="br0"><a href="#yeniBolge" class="notext"><i class='blIcon fa fa-plus-circle'></i></a></li>
            </ul>
	</div>
    </div>
</div>

<div data-role="page" id="yeniBolge" class="jmRun" data-islemler="adminBolgeYeni" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme='b'>
         <h1><?php echo $data["BolgeYeni"]; ?></h1>
    </div>
    <div data-role="content" class="p10">
            <label for="bolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
            <input type="text" name="bolgeAdi" id="bolgeAdi" required />
            <label for="bolgeAciklama"><?php echo $data["Aciklama"]; ?></label>
            <textarea type="text" name="bolgeAciklama" id="bolgeAciklama"></textarea>
    </div>
    <div data-position="fixed" data-tap-toggle="false" data-role="footer" data-theme='b'>
        <div data-role="navbar">
            <ul>
                <li><a class="wtext oi" data-rel="back" data-transition="slide"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a data-islemler="adminBolgeKaydet" class="wtext jmToggle oi" data-transition="slide" ><i class="fa fa-save"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="bolgeDetay" class="jmRun" data-islemler="adminBolgeDetail" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul class="pgTopNavbar">
                <li><a href="#" class="ui-btn-active" ><i class="fa fa-info-circle lIcon"></i> <?php echo $data["GenelBilgi"]; ?></a></li>
                <li><a href="#bolgeKurum" ><i class="fa fa-building lIcon"></i>  <?php echo $data["Kurumlar"]; ?></a></li>
                <li><a href="#bolgeKurumEkle"><i class="fa fa-plus-circle lIcon"></i> <?php echo $data["KurumEkle"]; ?></a></li>
            </ul>
        </div>
    </div>
    <div data-role="content" class="p10">
        <input id="adminBolgeDetailID" name="adminBolgeDetailID" type="hidden" value="" />
        <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
        <input type="text" class="dsb" id="BolgeAdi" name="BolgeDetailAdi" value="" disabled />
        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
        <textarea name="BolgeDetailAciklama" class="form-control dsbtext" rows="3" disabled></textarea>
    </div>
    <div data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar" class="edit-group">
            <ul>
                <li><a href="#" data-rel="back" data-transition="slide" class="wtext oi"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a id="editForm" class="wtext oi" data-Editislem="adminBolgeDetailEdit"><i class="fa fa-edit"></i></a></li>
                <li><a id="adminBolgeDetailSil" class="jmToggle wtext oi" data-transition="slide" data-islemler="adminBolgeDetailSil"><i class="fa fa-trash"></i></a></li>
                <li><a href="#bolgeMain" data-transition="slide" class="wtext oi"><i class="fa fa-home"></i></a></li>
            </ul>
        </div>
        <div data-role="navbar" class="submit-group">
            <ul>
                <li><a href="#" data-rel="back" data-transition="slide" class="wtext oi"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a class="vzg wtext oi" data-Vzgislem="adminBolgeDetailVazgec"><i class="fa fa-times"></i></a></li>
                <li><a class="save wtext oi" data-Saveislem="adminBolgeDetailKaydet"><i class="fa fa-save"></i></a></li>
                <li><a href="#bolgeMain" data-transition="slide" class="wtext oi"><i class="fa fa-home"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="bolgeKurum" class="jmRun" data-islemler="adminBolgeKurum" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul class="pgTopNavbar">
                <li><a href="#bolgeDetay" ><i class="fa fa-info-circle lIcon"></i> <?php echo $data["GenelBilgi"]; ?></a></li>
                <li><a href="#" class="ui-btn-active"><i class="fa fa-building lIcon"></i>  <?php echo $data["Kurumlar"]; ?></a></li>
                <li><a href="#bolgeKurumEkle"><i class="fa fa-plus-circle lIcon"></i> <?php echo $data["KurumEkle"]; ?></a></li>
            </ul>
        </div>
        <form class="ui-filterable" style="margin-bottom: 0; padding-left: 15px; border-top: 1px solid #009933;">
            <input id="bolgeKurumFilter" data-type="search">
        </form>
    </div>
    <div data-role="content">
        <ul id="bolgeKurumList" data-role="listview" data-filter="true" data-input="#bolgeKurumFilter" data-inset="false" data-icon="false" data-divider-theme="b"></ul>
    </div>
    <div data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul>
                <li><a href="#" data-transition="slide" class="wtext oi" data-rel="back"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a href="#bolgeMain" data-transition="slide" class="wtext oi"><i class="fa fa-home"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="bolgeKurumEkle" class="jmRun" data-islemler="adminBolgeDetailYeniEkle" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul class="pgTopNavbar">
                <li><a href="#bolgeDetay" ><i class="fa fa-info-circle lIcon"></i> <?php echo $data["GenelBilgi"]; ?></a></li>
                <li><a href="#bolgeKurum"><i class="fa fa-building lIcon"></i>  <?php echo $data["Kurumlar"]; ?></a></li>
                <li><a href="#" class="ui-btn-active"><i class="fa fa-plus-circle lIcon"></i> <?php echo $data["KurumEkle"]; ?></a></li>
            </ul>
        </div>
    </div>
    <div data-role="content" class="p10">
        <input id="adminBolgeKurumEkleID" name="adminBolgeKurumEkleID" type="hidden" value="" />
        <label for="KurumAdi"><?php echo $data["KurumAdi"]; ?></label>
        <input type="text" name="KurumAdi" id="KurumAdi" required>
            
        <label for="KurumLokasyon"><?php echo $data["Lokasyon"]; ?></label>
        <table class="w100">
            <tr>
                <td><button type="button" data-destination="#bolgeKurumLokasyonEkle" class="jmSingleValue ui-btn-active"><i class="fa fa-map-marker"></i></button></td>
                <td><input type="text" name="KurumLokasyon" id="KurumLokasyon" class="locationInput" disabled /></td>
            </tr>
        </table>

        <label for="KurumTelefon"><?php echo $data["Telefon"]; ?></label>
        <input type="text" name="KurumTelefon" id="KurumTelefon">

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

        <label for="KurumSokak"><?php echo $data["CaddeSokak"]; ?></label>
        <input type="text" name="route" id="KurumSokak" disabled>

        <label for="street_number"><?php echo $data["No"]; ?></label>
        <input type="text" name="street_number" id="street_number" disabled>

        <label for="KurumPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
        <input type="text" name="postal_code" id="KurumPostaKodu" disabled>
                                                                                      
    </div>
    <div data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul>
                <li><a href="#" data-transition="slide" class="wtext oi" data-rel="back"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a class="wtext oi save" data-rel="back" data-Saveislem="adminBolgeKurumKaydet"><i class="fa fa-save"></i></a></li>
                <li><a href="#bolgeMain" data-transition="slide" class="wtext oi"><i class="fa fa-home"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="bolgeKurumLokasyonEkle" class="singleMap" data-theme="b">
    <div data-role="content" style="padding: 0;">
        <div id="single_map" style="width:100% !important;"></div>
    </div>
    <div id="mapFooter" data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul>
                <li><a href="#" data-transition="slide" class="wtext oi" data-rel="back"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a id="saveMap" href="#bolgeKurumEkle" class="wtext oi save" data-rel="back" data-Saveislem="adminBolgeKurumKaydet"><i class="fa fa-save"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="bolgeKurumLokasyon" class="multiMap" data-theme="b">
    <div data-role="main" class="ui-content" style="padding: 0;">
        <div id="multiple_map" style="width:100% !important;"></div>
    </div>
    <div id="multiMapFooter" data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul>
                <li><a href="#" data-transition="slide" class="wtext oi" data-rel="back"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a href="#bolgeMain" data-transition="slide" class="wtext oi"><i class="fa fa-home"></i></a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
