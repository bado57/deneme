<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_isciliste";
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["TitleIsci"]; ?>
                    <small id="smallIsci"><?php if (count($model[0]['IsciCount']) > 0) { ?>
                            <?php
                            echo $model[0]['IsciCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="isciYeni" data-class="isci"><i class="fa fa-plus-square"></i> <?php echo $data['YeniIsci']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="isciTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="isciRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['IsciDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['IsciID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['IsciAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['IsciID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['IsciAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['IsciAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="isci" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["IsciTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="isci" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="IsciAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="IsciAdi" name="IsciAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="IsciSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="IsciSoyadi" name="IsciSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="IsciSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="IsciSelectBolge" name="IsciSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="IsciDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="IsciDurum" name="IsciDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="isci" type="button" data-islemler="isciVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="isci" data-islemler="isciEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="IsciLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="IsciTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="IsciTelefon" name="IsciTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="IsciKurumSelect"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="IsciKurumSelect" name="IsciKurumSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="IsciEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="IsciEmail" name="IsciEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="IsciAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="IsciAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical IsciAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="IsciUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="IsciUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="IsciSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="IsciIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="IsciSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="IsciMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciSokak"><?php echo $data["IsciSokak"]; ?></label>
                        <input type="text" class="form-control" id="IsciSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="IsciPostaKodu" name="postal_code" value="" disabled>
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

<div id="IsciDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["IsciDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="IsciDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="isciDetayID" name="isciDetayID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="IsciDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayAdi" name="IsciDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetaySoyadi" name="IsciDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="IsciDetaySelectBolge" name="IsciDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="IsciDetayDurum" name="IsciDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="isciDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="isciDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="isciDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="IsciDetailDeleteBtn" data-type="svClose"  data-class="IsciDetay" type="button" data-islemler="isciDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical IsciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="IsciDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="IsciDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayTelefon" name="IsciDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayKurum"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="IsciDetayKurum" name="IsciDetayKurum" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayEmail" name="IsciDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="IsciDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical IsciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="IsciDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="IsciDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="IsciDetayPostaKodu" name="postal_code" value="" disabled>
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



