<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_soforliste";
</script>
<link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/calendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/calendar/cal_custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminsoforajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminsofor-web.app.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/moment.min.js"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/fullcalendar.js"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/lang-all.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Sofor"]; ?>
                    <small id="smallSofor"><?php if (count($model[0]['SoforCount']) > 0) { ?>
                            <?php
                            echo $model[0]['SoforCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="soforYeni" data-class="sofor"><i class="fa fa-plus-square"></i> <?php echo $data['YeniSofor']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="soforTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="soforRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['SoforDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['SoforID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['SoforAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['SoforID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['SoforAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['SoforAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="sofor" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["SoforTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="sofor" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminKurumBolgeEkleID" name="soforID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="SoforAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="SoforAdi" name="SoforAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="SoforSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="SoforSoyadi" name="SoforSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="SoforSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="SoforSelectBolge" name="SoforSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoforDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="SoforDurum" name="SoforDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="sofor" type="button" data-islemler="soforVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="sofor" data-islemler="soforEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="SoforLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="SoforTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="SoforTelefon" name="SoforTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="SoforAracSelect"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="SoforAracSelect" name="SoforAracSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoforEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="SoforEmail" name="SoforEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="SoforAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="SoforAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="SoforUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="SoforUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="SoforSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="SoforIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="SoforSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="SoforMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="SoforSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="SoforPostaKodu" name="postal_code" value="" disabled>
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

<div id="soforDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["SoforDetay"]; ?> <span class="pull-right"><button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="soforTakvim" data-islemler="adminSoforTakvim"><i class="fa fa-calendar"></i> <?php echo $data["Takvim"]; ?></button><button data-type="svClose" data-class="soforDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="soforDetayID" name="soforDetayID" type="hidden" value="" />
                    <input id="soforDetayAdres" name="soforDetayAdres" type="hidden" value="" />
                    <div class="form-group">
                        <label for="SoforDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayAdi" name="SoforDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetaySoyadi" name="SoforDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="SoforDetaySelectBolge" name="SoforDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="SoforDetayDurum" name="SoforDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="soforDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="soforDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="soforDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="AdminDetailDeleteBtn" data-type="svClose"  data-class="soforDetay" type="button" data-islemler="soforDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="SoforDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-type="svOpen" data-class="map" class="btn btn-success svToggle dsb" data-islemler="adminSingleMap" type="button" disabled>
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="locationInput form-control" id="KurumLokasyon" name="KurumLokasyon" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayTelefon" name="SoforDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayArac"><?php echo $data["Arac"]; ?></label>
                        <select type="text" class="form-control" id="SoforDetayArac" name="SoforDetayArac" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayEmail" name="SoforDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="SoforDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical SoforDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="SoforDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="SoforDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="SoforDetayPostaKodu" name="postal_code" value="" disabled>
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

<div id="soforTakvim" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <input name="takvimLang" type="hidden" value="<?php echo Session::get("dil"); ?>" />
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["Takvim"]; ?> (<span id="takvimSofor"></span>)<span class="pull-right"><button data-type="svClose" data-class="soforTakvim" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div id='loading'><?php echo $data["Yukle"]; ?>...</div>
                <div id="calendar"></div>
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



