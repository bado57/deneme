<script type="text/javascript">

    var activeMenu = "menu_firma";
    var activeLink = "link_firmislem";

</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-building"></i> <?php echo $data["Firmaİslem"]; ?>

                </h3>
            </div>
            <?php if (Session::get("userRutbe") != 0) { ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right">
                    <div class="form-group submit-group">
                        <button type="button" class="btn btn-default vzg btn-sm" data-Vzgislem="adminFirmaDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success  btn-sm save" data-Saveislem="adminFirmaDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button type="button" id="editForm" class="btn btn-primary btn-sm" data-Editislem="adminFirmaDetailEdit"><?php echo $data["Duzenle"]; ?></button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h4><?php echo $data["GenelBilgi"]; ?></h4>
            <hr />
            <input id="FirmaDurum" name="Durum" type="hidden" value="<?php echo $model['60298ee45f6a299875562fff9846cbd0']; ?>" />
            <div class="form-group">
                <label for="FrmKod"><?php echo $data["FirmaKodu"]; ?></label>
                <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="<?php echo $model['00fe1774a569ef59e554731bbee4ea63']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="FirmaAdi"><?php echo $data["FirmaAdı"]; ?></label>
                <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="<?php echo $model['b396451b1996fa04924f7ba0b8316573']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                <textarea name="Aciklama" class="form-control dsb" rows="3" disabled><?php echo $model['1759cc8d99e1bac25f37202ee2a41060']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="FirmaDurum"><?php echo $data["Durum"]; ?></label>
                <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled>
                    <?php if ($model['60298ee45f6a299875562fff9846cbd0'] != 0) { ?>
                        <option value="1" selected><?php echo $data["Aktif"]; ?></option>
                    <?php } else { ?>
                        <option value="0" selected><?php echo $data["Pasif"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <br/>
            <div class="form-group">
                <div class="row">
                    <label for="OgrenciServis" class="control-label col-md-12">
                        <input id="OgrenciServis" name="OgrenciServis" type="checkbox" class="dsb" disabled <?php echo ($model['0540649c021082d7d1b9038d1964fad8'] != 0 ? checked : ''); ?> /> <?php echo $data["OgrenciServisi"]; ?></label>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="PersonelServis" class="control-label col-md-12">
                        <input id="PersonelServis" name="PersonelServis" type="checkbox" class="dsb" disabled <?php echo ($model['a2cc74afcae8ebd81a31e060ea4a7627'] != 0 ? checked : ''); ?>/> <?php echo $data["PersonelServisi"]; ?>
                    </label>
                </div>
            </div>
            <hr />
            <h4><?php echo $data["Iletisim"]; ?></h4>
            <hr />
            <div class="form-group">
                <label for="FirmaTelefon"><?php echo $data["Telefon"]; ?></label>
                <input type="number" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="<?php echo $model['2ab5b2e998b599e343f7fbaf18227b4d']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="FirmaEmail"><?php echo $data["Email"]; ?></label>
                <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="<?php echo $model['685bf8d64f11d160c35529a9554900ed']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="FirmaWebAdresi"><?php echo $data["WebSite"]; ?></label>
                <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="<?php echo $model['4a821589992e93f9a001222cb1709efb']; ?>" disabled>
            </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h4>Adres Bilgileri</h4>
            <hr />
            <div class="form-vertical KurumAdresForm">
                <div class="form-group">
                    <label for="FirmaLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button data-type="svOpen" data-class="map" class="btn btn-success svToggle dsb" data-islemler="adminFirmaSingleMap" type="button" disabled>
                                <i class="fa fa-map-marker"></i>
                            </button>
                        </span>
                        <input type="text" class="locationInput form-control" id="FirmaLokasyon" name="FirmaLokasyon" value="<?php echo $model['07bc35c9581aca8a9c4924697a02ed36']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="FirmaUlke"><?php echo $data["Ulke"]; ?></label>
                    <input type="text" class="form-control" id="FirmaUlke" name="country" value="<?php echo $model['a331eabe21f30d41dd44394a620361ac']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaSehir"><?php echo $data["Il"]; ?></label>
                    <input type="text" class="form-control" id="FirmaSehir" name="administrative_area_level_1" value="<?php echo $model['15ad378ae15264b6b249593c6a251e17']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaIlce"><?php echo $data["Ilce"]; ?></label>
                    <input type="text" class="form-control" id="FirmaIlce" name="administrative_area_level_2" value="<?php echo $model['fe0f2983e65c84fbf7a47145b065714c']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaSemt"><?php echo $data["Semt"]; ?></label>
                    <input type="text" class="form-control" id="FirmaSemt" name="locality" value="<?php echo $model['0d6f40007ceb507e16dd749fc74a4fd7']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaMahalle"><?php echo $data["Mahalle"]; ?></label>
                    <input type="text" class="form-control" id="FirmaMahalle" name="neighborhood" value="<?php echo $model['adbb14b35b2ba779c9981bee8286015c']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaSokak"><?php echo $data["CaddeSokak"]; ?></label>
                    <input type="text" class="form-control" id="FirmaSokak" name="route" value="<?php echo $model['91231e690f9e463990bf5252811ff4fb']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="street_number"><?php echo $data["CaddeNo"]; ?></label>
                    <input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo $model['2f23559b1ac9300e02601f2a61671d9e']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                    <input type="text" class="form-control" id="FirmaPostaKodu" name="postal_code" value="<?php echo $model['207b9110413e9bb55f71a47dc36c1054']; ?>" disabled>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

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