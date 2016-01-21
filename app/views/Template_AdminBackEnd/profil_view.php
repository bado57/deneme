<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminprofilajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminprofil-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-user"></i> <?php echo $data["ProfilBilgi"]; ?>

                </h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right">
                <div class="form-group submit-group">
                    <button type="button" class="btn btn-default vzg btn-sm" data-Vzgislem="profilVazgec"><?php echo $data["Vazgec"]; ?></button>
                    <button type="button" class="btn btn-success  btn-sm save" data-Saveislem="profilKaydet"><?php echo $data["Kaydet"]; ?></button>
                </div>
                <div class="form-group edit-group">
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="sifreDuzenle" data-class="sifreDuzenle"><i class="fa fa-key"></i> <?php echo $data["SifreDegistir"]; ?></button>
                    <button type="button" id="editForm" class="btn btn-primary btn-sm" data-Editislem="profilEdit"><i class="fa fa-pencil-square-o"></i> <?php echo $data["Duzenle"]; ?></button>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h4><?php echo $data["KisiselBilgi"]; ?></h4>
            <hr />
            <input id="ID" name="ID" type="hidden" value="<?php echo $model['ID']; ?>" />
            <div class="form-group">
                <label for="Ad"><?php echo $data["Ad"]; ?></label>
                <input type="text" class="form-control dsb" id="Ad" name="Ad" value="<?php echo $model['Ad']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Soyad"><?php echo $data["Soyad"]; ?></label>
                <input type="text" class="form-control dsb" id="Soyad" name="Soyad" value="<?php echo $model['Soyad']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Kadi"><?php echo $data["Kadi"]; ?></label>
                <input type="text" class="form-control" id="Kadi" name="Kadi" value="<?php echo $model['Kadi']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                <textarea name="Aciklama" class="form-control dsb" rows="3" disabled style="resize:none"><?php echo $model['Aciklama']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="Sifre"><?php echo $data["Durum"]; ?></label>
                <input type="text" class="form-control" id="Durum" name="Durum" value="<?php echo $model['Durum'] == 1 ? $data["Aktif"] : $data["Pasif"]; ?>" disabled>
            </div>
            <hr />
            <h4><?php echo $data["Iletisim"]; ?></h4>
            <hr />
            <div class="form-group">
                <label for="Telefon"><?php echo $data["Telefon"]; ?></label>
                <input type="number" class="form-control dsb" id="Telefon" name="Telefon" value="<?php echo $model['Phone']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Email"><?php echo $data["Email"]; ?></label>
                <input type="email" class="form-control dsb" id="Email" name="Email" value="<?php echo $model['Email']; ?>" disabled>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h4><?php echo $data["AdresBilgi"]; ?></h4>
            <hr />
            <div class="form-vertical KurumAdresForm">
                <div class="form-group">
                    <label for="Lokasyon"><?php echo $data["Lokasyon"]; ?></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button data-type="svOpen" data-class="map" class="btn btn-success svToggle dsb" data-islemler="adminFirmaSingleMap" type="button" disabled>
                                <i class="fa fa-map-marker"></i>
                            </button>
                        </span>
                        <input type="text" class="locationInput form-control" id="KurumLokasyon" name="KurumLokasyon" value="<?php echo $model['Location']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Ulke"><?php echo $data["Ulke"]; ?></label>
                    <input type="text" class="form-control" id="FirmaUlke" name="country" value="<?php echo $model['Ulke']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Sehir"><?php echo $data["Il"]; ?></label>
                    <input type="text" class="form-control" id="FirmaSehir" name="administrative_area_level_1" value="<?php echo $model['Il']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Ilce"><?php echo $data["Ilce"]; ?></label>
                    <input type="text" class="form-control" id="FirmaIlce" name="administrative_area_level_2" value="<?php echo $model['Ilce']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Semt"><?php echo $data["Semt"]; ?></label>
                    <input type="text" class="form-control" id="Semt" name="locality" value="<?php echo $model['Semt']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Mahalle"><?php echo $data["Mahalle"]; ?></label>
                    <input type="text" class="form-control" id="Mahalle" name="neighborhood" value="<?php echo $model['Mahalle']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Sokak"><?php echo $data["CaddeSokak"]; ?></label>
                    <input type="text" class="form-control" id="Sokak" name="route" value="<?php echo $model['Sokak']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="street_number"><?php echo $data["CaddeNo"]; ?></label>
                    <input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo $model['CaddeNo']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="PostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                    <input type="text" class="form-control" id="PostaKodu" name="postal_code" value="<?php echo $model['PostaKodu']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="Adres"><?php echo $data["AdresDetay"]; ?></label>
                    <textarea name="Adres" class="form-control dsb" rows="3" disabled><?php echo $model['Adres']; ?></textarea>
                </div>
            </div>
        </div>

    </section>
</aside>
</div>
<div id="sifreDuzenle" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["SifreDegistir"]; ?> <span class="pull-right"><button data-type="svClose" data-class="sifreDuzenle" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="generalInfo col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="EskiSifre"><?php echo $data["EskiSifre"]; ?></label>
                            <input type="text" class="form-control" id="eskiSifre" name="eskiSifre" value="">
                        </div>
                        <div class="form-group">
                            <label for="YeniSifre"><?php echo $data["YeniSifre"]; ?></label>
                            <input type="text" class="form-control dsb" id="yeniSifre" name="yeniSifre" value="">
                        </div>
                        <div class="form-group">
                            <label for="YeniSifreTekrar"><?php echo $data["YeniSifreTekrar"]; ?></label>
                            <input type="text" class="form-control dsb" id="yeniSifreTekrar" name="yeniSifreTekrar" value="">
                        </div>
                        <div class="form-group">
                            <button data-type="svClose"  data-class="sifreDuzenle" type="button" data-islemler="adminSifreVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                            <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="sifreDuzenle" data-islemler="sifreKaydet"><?php echo $data["Kaydet"]; ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="map" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div id="mapHeader">
        <h3><b id="singleMapBaslik"><?php echo $data["LokasyonTanimlama"]; ?> </b><b id="multiMapBaslik"></b>
            <span class="pull-right"><button data-type="svClose" data-class="map" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span>
            <span class="pull-right"><button id="saveMap" data-islemler="adminHaritaKaydet" data-type="svClose" data-class="map" type="button" class="svToggle btn btn-success"><i class="fa fa-map-marker"></i><th>&nbsp<?php echo $data["KonumuKaydet"]; ?></th></button></span>
        </h3>
        <hr/>
    </div>
    <div id="multiple_map" style="width:100% !important;"></div>
</div>