<script type="text/javascript">
    var activeMenu = "menu_kullanici";
    var activeLink = "link_hostesliste";
</script>
<link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/calendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_PLUGINADMIN_CSS; ?>/calendar/cal_custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminhostesajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminhostes-web.app.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/moment.min.js"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/fullcalendar.js"></script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/calendar/lang-all.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Hostes"]; ?>
                    <small id="smallHostes"><?php if (count($model[0]['HostesCount']) > 0) { ?>
                            <?php
                            echo $model[0]['HostesCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="hostesYeni" data-class="hostes"><i class="fa fa-plus-square"></i> <?php echo $data['YeniHostes']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="hostesTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Telefon"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Email"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="hostesRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <?php if ($adminModel['HostesDurum'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['HostesID']; ?>">
                                            <i class="glyphicon glyphicon-user"></i> <?php echo $adminModel['HostesAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['HostesID']; ?>">
                                            <i class="glyphicon glyphicon-user" style="color:red !important"></i> <?php echo $adminModel['HostesAdi']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesSoyad']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesTelefon']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesEmail']; ?></td>
                                    <td class="hidden-xs"><?php echo $adminModel['HostesAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="hostes" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["HostesTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="hostes" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminKurumBolgeEkleID" name="soforID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="HostesAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control" id="HostesAdi" name="HostesAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="HostesSoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control" id="HostesSoyadi" name="HostesSoyadi" value="">
                    </div>
                    <div class="form-group">
                        <label for="HostesSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="HostesSelectBolge" name="HostesSelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="HostesDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="HostesDurum" name="HostesDurum">
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="hostes" type="button" data-islemler="hostesVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="hostes" data-islemler="hostesEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="HostesLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="HostesTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="HostesTelefon" name="HostesTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="HostesAracSelect"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="HostesAracSelect" name="HostesAracSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="HostesEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="HostesEmail" name="HostesEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="HostesAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="HostesAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-vertical AdminAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="HostesUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="HostesUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="HostesSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="HostesIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="HostesSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="HostesMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="HostesSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="HostesPostaKodu" name="postal_code" value="" disabled>
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

<div id="hostesDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["HostesDetay"]; ?> <span class="pull-right"><button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="hostesTakvim" data-islemler="adminHostesTakvim"><i class="fa fa-calendar"></i> <?php echo $data["Takvim"]; ?></button><button data-type="svClose" data-class="hostesDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="hostesDetayID" name="hostesDetayID" type="hidden" value="" />
                    <input id="hostesDetayAdres" name="hostesDetayAdres" type="hidden" value="" />
                    <div class="form-group">
                        <label for="HostesDetayAdi"><?php echo $data["Adi"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayAdi" name="HostesDetayAdi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetaySoyadi"><?php echo $data["Soyadi"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetaySoyadi" name="HostesDetaySoyadi" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetaySelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control dsb" id="HostesDetaySelectBolge" name="HostesDetaySelectBolge" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control dsb" id="HostesDetayDurum" name="HostesDetayDurum" disabled>
                            <option value="0">Pasif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="DetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="DetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="hostesDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="hostesDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="hostesDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button id="AdminDetailDeleteBtn" data-type="svClose"  data-class="hostesDetay" type="button" data-islemler="hostesDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical AdminDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="HostesDetayLokasyon"><?php echo $data["Lokasyon"]; ?></label>
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
                        <label for="HostesDetayTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayTelefon" name="HostesDetayTelefon" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayArac"><?php echo $data["Arac"]; ?></label>
                        <select type="text" class="form-control" id="HostesDetayArac" name="HostesDetayArac" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayEmail" name="HostesDetayEmail" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="HostesDetayAdresDetay" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="form-vertical SoforDetailAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="HostesDetayUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetaySehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetaySehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetaySemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetaySemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetaySokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetaySokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="HostesDetayPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control dsb" id="HostesDetayPostaKodu" name="postal_code" value="" disabled>
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

<div id="hostesTakvim" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["Takvim"]; ?> (<span id="takvimHostes"></span>)<span class="pull-right"><button data-type="svClose" data-class="hostesTakvim" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
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



