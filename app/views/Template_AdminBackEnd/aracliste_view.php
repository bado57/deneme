<script type="text/javascript">
    var activeMenu = "menu_arac";
    var activeLink = "link_aracliste";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminaracajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminarac-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Araclar"]; ?>
                    <small id="smallArac"><?php if (count($model[0]['AdminAracCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminAracCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminAracYeni" data-class="arac"><i class="fa fa-plus-square"></i> <?php echo $data['YeniArac']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminAracTable">
                    <thead>
                        <tr>
                            <th ><?php echo $data["Plaka"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Marka"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["ModelYil"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Kapasite"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["AracKm"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Durum"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminAracRow">
                        <?php foreach ($model as $aracModel) { ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $aracModel['AdminAracID']; ?>">
                                        <i class="fa fa-bus" style="<?php echo $aracModel['AdminAracDurum'] == 1 ? 'color:green' : 'color:red'; ?>"></i> <?php echo $aracModel['AdminAracPlaka']; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs"><?php echo $aracModel['AdminAracMarka']; ?></td>
                                <td class="hidden-xs"><?php echo $aracModel['AdminAracYil']; ?></td>
                                <td class="hidden-xs"><?php echo $aracModel['AdminAracKapasite']; ?></td>
                                <td class="hidden-xs"><?php echo $aracModel['AdminAracKm']; ?></td>
                                <td class="hidden-xs"><?php echo $aracModel['AdminAracDurum'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="arac" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["AracTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="arac" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addAracForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AracPlaka"><?php echo $data["Plaka"]; ?></label>
                        <input type="text" class="form-control" id="AracPlaka" name="AracPlaka" value="" style="text-transform:uppercase">
                    </div>
                    <div class="form-group">
                        <label for="BolgeAdi"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="AracBolgeSelect" name="AracBolgeSelect" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Marka"><?php echo $data["Marka"]; ?></label>
                        <input type="text" class="form-control" id="AracMarka" name="AracMarka" value="">
                    </div>
                    <div class="form-group">
                        <label for="ModelYil"><?php echo $data["ModelYil"]; ?></label>
                        <input type="text" class="form-control" id="AracYil" name="AracYil" value="">
                    </div>
                    <div class="form-group">
                        <label for="AracAciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="AracAciklama" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="arac" type="button" data-islemler="adminAracVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="arac" data-islemler="adminAracEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="AracKapasite"><?php echo $data["Kapasite"]; ?></label>
                        <input type="text" class="form-control" id="AracKapasite" name="AracKapasite" value="">
                    </div>
                    <div class="form-group">
                        <label for="AracSurucu"><?php echo $data["Surucu"]; ?></label>
                        <select type="text" class="form-control" id="AracSurucu" name="AracSurucu" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="AracSurucu"><?php echo $data["Hostes"]; ?></label>
                        <select type="text" class="form-control" id="AracHostes" name="AracHostes" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="AracDurum"><?php echo $data["Durum"]; ?></label>
                        <select type="text" class="form-control" id="AracDurum" name="AracDurum">
                            <option value="0"><?php echo $data["Pasif"]; ?></option>
                            <option value="1"><?php echo $data["Aktif"]; ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="aracDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["AracDetay"]; ?> <span class="pull-right"><button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="aracDetayTur" data-islemler="adminAracDetailTur"><i class="fa fa-refresh"></i> <?php echo $data["Turlar"]; ?></button><button data-type="svClose" data-class="aracDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input id="adminAracDetailDeger" name="adminAracDetailDeger" type="hidden" value="" />
                            <label for="AracDetayPlaka"><?php echo $data["Plaka"]; ?></label>
                            <div class="input-group">
                                <span  class="input-group-btn" type="hidden">
                                    <button id="AracAktifTur" data-type="svOpen" data-class="map" class="btn btn-danger svToggle" data-islemler="adminAracMap" type="button" disabled>
                                        <i class="fa fa-map-marker"></i>
                                    </button>
                                </span>
                                <input type="text" class="form-control dsb" id="AracPlaka" name="AracDetayPlaka" value="" style="text-transform:uppercase" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayBolgeAdi"><?php echo $data["BolgeAdi"]; ?></label>
                            <select type="text" class="form-control" id="AracDetayBolgeSelect" name="AracDetayBolgeSelect" multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayMarka"><?php echo $data["Marka"]; ?></label>
                            <input type="text" class="form-control dsb" id="AracDetayMarka" name="AracDetayMarka" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayModelYil"><?php echo $data["ModelYil"]; ?></label>
                            <input type="text" class="form-control dsb" id="AracDetayModelYil" name="AracDetayModelYil" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayAciklama"><?php echo $data["Aciklama"]; ?></label>
                            <textarea name="AracDetayAciklama" class="form-control dsb" rows="3" disabled></textarea>
                        </div>
                        <div class="form-group submit-group">
                            <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="adminAracDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                            <button type="button" class="btn btn-success save" data-Saveislem="adminAracDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" data-Editislem="adminAracDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                            <button id="AracDetailDeleteBtn" data-type="svClose"  data-class="aracDetay" type="button" data-islemler="adminAracDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                        </div>
                    </div>
                    <div class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="AracDetayKm"><?php echo $data["AracKm"]; ?></label>
                            <input type="text" class="form-control" id="AracDetayKm" name="AracDetayKm" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="AracDetaySurucu"><?php echo $data["Surucu"]; ?></label>
                            <select type="text" class="form-control" id="AracDetaySurucu" name="AracDetaySurucu" multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayHostes"><?php echo $data["Hostes"]; ?></label>
                            <select type="text" class="form-control" id="AracDetayHostes" name="AracDetayHostes" multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayKapasite"><?php echo $data["Kapasite"]; ?></label>
                            <input type="text" class="form-control dsb" id="AracDetayKapasite" name="AracDetayKapasite" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="AracDetayDurum"><?php echo $data["Durum"]; ?></label>
                            <select type="text" class="form-control dsb" id="AracDetayDurum" name="AracDetayDurum" disabled>
                                <option value="0"><?php echo $data["Pasif"]; ?></option>
                                <option value="1"><?php echo $data["Aktif"]; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="aracDetayTur" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurListe"]; ?> <span class="pull-right"><button class="btn btn-success mr10 seeAllButton" onclick="location.href = '<?php echo SITE_PLUGINADMIN_Tur; ?>'"><?php echo $data["TumunuGor"]; ?></button> <button data-type="svClose" data-class="aracDetayTur" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="generalInfo col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminAracTurTable">
                                    <thead>
                                        <tr >
                                            <th><?php echo $data["TurAdi"]; ?></th>
                                            <th><?php echo $data["Tür"]; ?></th>
                                            <th><?php echo $data["Aciklama"]; ?></th>
                                            <th><?php echo $data["Kurum"]; ?></th>
                                            <th><?php echo $data["Bolge"]; ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
            <span class="pull-right"><button id="saveMap" data-islemler="adminKurumHaritaKaydet" data-type="svClose" data-class="map" type="button" class="svToggle btn btn-success"><i class="fa fa-map-marker"></i> Konumu Kaydet</button></span>
        </h3>
        <hr/>
    </div>
    <div id="multiple_map" style="width:100% !important;"></div>
</div><!-- ./wrapper -->



