<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_veliliste";
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Veli"]; ?>
                    <small id="smallVeli"><?php if (count($model[0]['VeliCount']) > 0) { ?>
                            <?php
                            echo $model[0]['VeliCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="veliYeni" data-class="veli"><i class="fa fa-plus-square"></i> <?php echo $data['YeniVeli']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="veliTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="veliRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['VeliDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['VeliID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['VeliAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['VeliID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['VeliAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['VeliAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="veli" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["VeliTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="veli" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminVeliID" name="veliID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="VeliAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="VeliAdi" name="VeliAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="VeliSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="VeliSoyadi" name="VeliSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="VeliSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="VeliSelectBolge" name="VeliSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliOgrenciSelect"><?php echo $data["Ogrenciler"]; ?></label>
                        <select type="text" class="form-control" id="VeliOgrenciSelect" name="VeliOgrenciSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="VeliDurum" name="VeliDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="veli" type="button" data-islemler="veliVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="veli" data-islemler="veliEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical VelidresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="VeliLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="VeliTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="VeliTelefon" name="VeliTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="VeliKurumSelect"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="VeliKurumSelect" name="VeliKurumSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="VeliEmail" name="VeliEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="VeliAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="VeliAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical VeliAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="VeliUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="VeliUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="VeliSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="VeliIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="VeliSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="VeliMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="VeliSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="VeliPostaKodu" name="postal_code" value="" disabled>
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

<div id="VeliDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["VeliDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="VeliDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="veliDetayID" name="veliDetayID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="VeliDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayAdi" name="VeliDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetaySoyadi" name="VeliDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="VeliDetaySelectBolge" name="IsciDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayOgrenciSelect"><?php echo $data["Ogrenciler"]; ?></label>
                        <select type="text" class="form-control" id="VeliDetayOgrenciSelect" name="VeliDetayOgrenciSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="VeliDetayDurum" name="VeliDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="veliDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="veliDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="veliDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="IsciDetailDeleteBtn" data-type="svClose"  data-class="VeliDetay" type="button" data-islemler="veliDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical IsciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="VeliDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="VeliDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayTelefon" name="VeliDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayKurum"><?php echo $data["Kurumlar"]; ?></label>
                        <select type="text" class="form-control" id="VeliDetayKurum" name="VeliDetayKurum" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayEmail" name="VeliDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="VeliDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical IsciDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="VeliDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="VeliDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="VeliDetayPostaKodu" name="postal_code" value="" disabled>
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



