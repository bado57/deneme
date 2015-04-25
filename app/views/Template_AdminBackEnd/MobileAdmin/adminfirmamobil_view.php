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
<div data-role="page" id="firmaMain" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul class="pgTopNavbar">
                <li><a href="#" class="ui-btn-active" ><i class="fa fa-info-circle lIcon"></i> <?php echo $data["GenelBilgi"]; ?></a></li>
                <li><a href="#firmaLokasyon" ><i class="fa fa-map-marker lIcon"></i>  <?php echo $data["Lokasyon"]; ?></a></li>
            </ul>
        </div>
    </div>
    <div data-role="content" class="p10">
        <input id="FirmaDurum" name="Durum" type="hidden" value="<?php echo $model['60298ee45f6a299875562fff9846cbd0']; ?>" />
        <label for="FrmKod"><?php echo $data["FirmaKodu"]; ?></label>
        <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="<?php echo $model['00fe1774a569ef59e554731bbee4ea63']; ?>" disabled>
        
        <label for="FirmaAdi"><?php echo $data["FirmaAdı"]; ?></label>
        <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="<?php echo $model['b396451b1996fa04924f7ba0b8316573']; ?>" disabled>

        <label for="FirmaTelefon"><?php echo $data["Telefon"]; ?></label>
        <input type="text" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="<?php echo $model['2ab5b2e998b599e343f7fbaf18227b4d']; ?>" disabled>
        
        <label for="FirmaEmail"><?php echo $data["Email"]; ?></label>
        <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="<?php echo $model['685bf8d64f11d160c35529a9554900ed']; ?>" disabled>
        
        <label for="FirmaWebAdresi"><?php echo $data["WebSite"]; ?></label>
        <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="<?php echo $model['4a821589992e93f9a001222cb1709efb']; ?>" disabled>
            
        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
        <textarea name="Aciklama" class="form-control dsbtext" rows="3" disabled><?php echo $model['1759cc8d99e1bac25f37202ee2a41060']; ?></textarea>
        
        <label for="FirmaDurum"><?php echo $data["Durum"]; ?></label>
        <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled style="text-align: left;">
            <?php
            if ($model['60298ee45f6a299875562fff9846cbd0'] != 0) {
            ;
            ?>
            <option value="1" selected><?php echo $data["Aktif"]; ?></option>
            <?php } else { ?>
                <option value="0" selected><?php echo $data["Pasif"]; ?></option>
            <?php } ?>
        </select>
        <fieldset data-role="controlgroup">
                <input type="checkbox" name="OgrenciServis" id="OgrenciServis" class="dsb" checked disabled <?php echo ($model['0540649c021082d7d1b9038d1964fad8'] != 0 ? checked : ''); ?> />
                <label for="OgrenciServis" style="padding-left: 2.5em;"><?php echo $data["OgrenciServisi"]; ?></label>

                <input type="checkbox" name="PersonelServis" id="PersonelServis" class="dsb" checked disabled <?php echo ($model['a2cc74afcae8ebd81a31e060ea4a7627'] != 0 ? checked : ''); ?> />
                <label for="PersonelServis" style="padding-left: 2.5em;"><?php echo $data["PersonelServisi"]; ?></label>
         </fieldset>
    </div>
    <div data-position="fixed" data-tap-toggle="false" data-role="footer" data-theme='b'>
	<div data-role="navbar" class="edit-group">
            <ul>
                <li><a id="editForm" class="wtext oi" data-Editislem="adminKurumDetailEdit"><i class="fa fa-edit"></i></a></li>
            </ul>
        </div>
        <div data-role="navbar" class="submit-group">
            <ul>
                <li><a class="vzg wtext oi" data-Vzgislem="adminBolgeDetailVazgec"><i class="fa fa-times"></i></a></li>
                <li><a class="save wtext oi" data-Saveislem="adminBolgeDetailKaydet"><i class="fa fa-save"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="firmaLokasyon" data-theme="b">
    <div data-role="header" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul class="pgTopNavbar">
                <li><a href="#firmaMain" ><i class="fa fa-info-circle lIcon"></i> <?php echo $data["GenelBilgi"]; ?></a></li>
                <li><a href="#" class="ui-btn-active"><i class="fa fa-map-marker lIcon"></i>  <?php echo $data["Lokasyon"]; ?></a></li>
            </ul>
        </div>
    </div>
    <div data-role="content" class="p10">            
        <label for="KurumLokasyon"><?php echo $data["Lokasyon"]; ?></label>
        <table class="w100">
            <tr>
                <td><button type="button" data-destination="#firmaLokasyonEkle" class="jmSingleValue ui-btn-active dsb" disabled="disabled"><i class="fa fa-map-marker"></i></button></td>
                <td><input type="text" name="KurumLokasyon" id="KurumLokasyon" class="locationInput" disabled /></td>
            </tr>
        </table>
        
        <label for="FirmaUlke"><?php echo $data["Ulke"]; ?></label>
        <input type="text" name="country" id="FirmaUlke" disabled>

        <label for="FirmaSehir"><?php echo $data["Il"]; ?></label>
        <input type="text" name="administrative_area_level_1" id="FirmaSehir" disabled>

        <label for="FirmaIlce"><?php echo $data["Ilce"]; ?></label>
        <input type="text" name="administrative_area_level_2" id="FirmaIlce" disabled>

        <label for="FirmaSemt"><?php echo $data["Semt"]; ?></label>
        <input type="text" name="locality" id="FirmaSemt" disabled>

        <label for="FirmaMahalle"><?php echo $data["Mahalle"]; ?></label>
        <input type="text" name="neighborhood" id="FirmaMahalle" disabled>

        <label for="FirmaSokak"><?php echo $data["CaddeSokak"]; ?></label>
        <input type="text" name="route" id="FirmaSokak" disabled>

        <label for="street_number"><?php echo $data["No"]; ?></label>
        <input type="text" name="street_number" id="street_number" disabled>

        <label for="FirmaPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
        <input type="text" name="postal_code" id="FirmaPostaKodu" disabled>
    </div>
    <div data-position="fixed" data-tap-toggle="false" data-role="footer" data-theme='b'>
	<div data-role="navbar" class="edit-group">
            <ul>
                <li><a id="editForm" class="wtext oi" data-Editislem="adminFirmaDetailEdit"><i class="fa fa-edit"></i></a></li>
            </ul>
        </div>
        <div data-role="navbar" class="submit-group">
            <ul>
                <li><a class="vzg wtext oi" data-Vzgislem="adminFirmaDetailVazgec"><i class="fa fa-times"></i></a></li>
                <li><a class="save wtext oi" data-Saveislem="adminFirmaDetailKaydet"><i class="fa fa-save"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div data-role="page" id="firmaLokasyonEkle" class="singleMap" data-theme="b">
    <div data-role="content" style="padding: 0;">
        <div id="single_map" style="width:100% !important;"></div>
    </div>
    <div id="mapFooter" data-role="footer" data-position="fixed" data-tap-toggle="false" data-theme="b">
        <div data-role="navbar">
            <ul>
                <li><a href="#" data-transition="slide" class="wtext oi" data-rel="back"><i class="fa fa-chevron-circle-left"></i></a></li>
                <li><a id="saveMap" href="#firmaLokasyon" class="wtext oi save" data-rel="back" data-Saveislem="adminFirmaHaritaKaydet"><i class="fa fa-save"></i></a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>