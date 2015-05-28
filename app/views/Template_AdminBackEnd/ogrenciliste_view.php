<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_ogrenciliste";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminogrenciajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminogrenci-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Ogrenci"]; ?>
                    <small id="smallOgrenci"><?php if (count($model[0]['OgrenciCount']) > 0) { ?>
                            <?php
                            echo $model[0]['OgrenciCount'];
                        } else {
                            ?>
                            <?php
                            echo '0 ';
                        }
                        ?></small>&nbsp;<small><?php echo $data["Toplam"]; ?></small>
                </h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right" style="text-align:right;">
                <div class="form-group">
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="ogrenciYeni" data-class="ogrenci"><i class="fa fa-plus-square"></i> <?php echo $data['YeniOgrenci']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="ogrenciTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="ogrenciRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['OgrenciDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['OgrenciID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['OgrenciAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['OgrenciID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['OgrenciAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['OgrenciAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="ogrenci" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["OgrenciTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="ogrenci" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addÖğrenciForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="ogrenciVeliID" name="ogrenciID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="OgrenciAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciAdi" name="OgrenciAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="OgrenciSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciSoyadi" name="OgrenciSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="OgrenciSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciSelectBolge" name="OgrenciSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciVeliSelect"><?php echo $data["Veliler"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciVeliSelect" name="OgrenciVeliSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciDurum" name="OgrenciDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="ogrenci" type="button" data-islemler="ogrenciVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="ogrenci" data-islemler="ogrenciEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical VelidresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="OgrenciLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-type="svOpen" data-class="map" class="btn btn-success svToggle" data-islemler="adminSingleMap" type="button">
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="locationInput form-control" id="KurumLokasyon" name="KurumLokasyon" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciTelefon" name="OgrenciTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="OgrenciKurumSelect"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciKurumSelect" name="OgrenciKurumSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciEmail" name="OgrenciEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="OgrenciAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="OgrenciAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical OgrenciAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="OgrenciUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="OgrenciPostaKodu" name="postal_code" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="street_number"><?php echo $data["CaddeNo"]; ?></label>
                        <input type="text" class="form-control" id="street_number" name="street_number" value="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="OgrenciDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["OgrenciDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="OgrenciDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addOgrenciForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="ogrenciDetayID" name="ogrenciDetayID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="OgrenciDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayAdi" name="OgrenciDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetaySoyadi" name="OgrenciDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="OgrenciDetaySelectBolge" name="OgrenciDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayVeliSelect"><?php echo $data["Veliler"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciDetayVeliSelect" name="OgrenciDetayVeliSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="OgrenciDetayDurum" name="OgrenciDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="ogrenciDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="ogrenciDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="ogrenciDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="OgrenciDetailDeleteBtn" data-type="svClose"  data-class="OgrenciDetay" type="button" data-islemler="ogrenciDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical IsciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="OgrenciDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-type="svOpen" data-class="map" class="btn btn-success svToggle" data-islemler="adminSingleMap" type="button" disabled>
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="locationInput form-control dsb" id="KurumLokasyon" name="KurumLokasyon" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayTelefon" name="OgrenciDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayKurum"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="OgrenciDetayKurum" name="OgrenciDetayKurum" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayEmail" name="OgrenciDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="OgrenciDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical OgrenciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="OgrenciDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="OgrenciDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="OgrenciDetayPostaKodu" name="postal_code" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="street_number"><?php echo $data["CaddeNo"]; ?></label>
                        <input type="text" class="form-control dsb" id="street_number" name="street_number" value="" disabled>
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
</div><!-- ./wrapper -->



