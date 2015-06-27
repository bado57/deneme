<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_adminliste";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminadminajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminadmin-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Admin"]; ?>
                    <small id="smallAdmin"><?php if (count($model[0]['AdminCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminYeni" data-class="admin"><i class="fa fa-plus-square"></i> <?php echo $data['YeniAdmin']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['AdminDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['AdminID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['AdminAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['AdminID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['AdminAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['AdminAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="admin" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["AdminTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="admin" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminKurumBolgeEkleID" name="adminID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="AdminAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="AdminAdi" name="AdminAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="AdminSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="AdminSoyadi" name="AdminSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="AdminSelectAd"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="AdminSelectBolge" name="AdminSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="AdminDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="AdminDurum" name="AdminDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="admin" type="button" data-islemler="adminVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="admin" data-islemler="adminEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AdminLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="AdminTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="AdminTelefon" name="AdminTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="AdminEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="AdminEmail" name="AdminEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="AdminAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="AdminAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AdminUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="AdminUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="AdminSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="AdminIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="AdminSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="AdminMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="AdminSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="AdminPostaKodu" name="postal_code" value="" disabled>
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

<div id="adminDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["AdminDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="adminDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminDetayID" name="adminDetayID" type="hidden" value="" />
                    <input id="adminDetayAdres" name="adminDetayAdres" type="hidden" value="" />
                    <div class="form-group">
                        <label for="AdminDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayAdi" name="AdminDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetaySoyadi" name="AdminDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="AdminDetaySelectBolge" name="AdminDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="AdminDetayDurum" name="AdminDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="adminDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="adminDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="adminDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="AdminDetailDeleteBtn" data-type="svClose"  data-class="adminDetay" type="button" data-islemler="adminDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AdminDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-type="svOpen" data-class="map" class="btn btn-success svToggle dsb" data-islemler="adminSingleMap" type="button" disabled>
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="locationInput form-control dsb" id="KurumLokasyon" name="KurumLokasyon" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayTelefon" name="AdminDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayEmail" name="AdminDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="AdminDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical AdminDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AdminDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="AdminDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="AdminDetayPostaKodu" name="postal_code" value="" disabled>
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



