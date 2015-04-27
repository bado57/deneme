<script type="text/javascript">
    var activeMenu = "menu_tur";
    var activeLink = "link_turliste";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminturajaxquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/admintur-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Turlar"]; ?>
                    <small id="smallTur"><?php if (count($model[0]['AdminTurCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminTurCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminTurYeni" data-class="tur"><i class="fa fa-plus-square"></i> <?php echo $data['TurYeni']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminTurTable">
                    <thead>
                        <tr>
                            <th><?php echo $data["TurAdi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeAdi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["KurumAdi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Tür"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminTurRow">
                        <?php foreach ($model as $turModel) { ?>
                            <?php if ($turModel['AdminTurAktiflik'] != 0) { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $turModel['AdminTurID']; ?>">
                                            <i class="glyphicon glyphicon-refresh"></i> <?php echo $turModel['AdminTur']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurBolgeAd']; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurKurumAd']; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurTip'] != 0 ? 'İşçi' : 'Öğrenci'; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurAciklama']; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $turModel['AdminTurID']; ?>">
                                            <i class="glyphicon glyphicon-refresh" style="color: red"></i> <?php echo $turModel['AdminTur']; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurBolgeAd']; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurKurumAd']; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurTip'] != 0 ? 'İşçi' : 'Öğrenci'; ?></td>
                                    <td class="hidden-xs"><?php echo $turModel['AdminTurAciklama']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="tur" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurTanimlama"]; ?> <span class="pull-right"><button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="#" data-islemler="#"><i class="glyphicon glyphicon-map-marker"></i> <?php echo $data["HaritaGor"]; ?></button><button data-type="svClose" data-class="tur" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <input id="adminKurumBolgeEkleID" name="adminKurumBolgeEkleID" type="hidden"/>
                        <div class="form-group">
                            <label for="TurAdi"><?php echo $data["TurAdi"]; ?></label>
                            <input type="text" class="form-control" id="TurAdi" name="TurAdi">
                        </div>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectBolge" name="TurSelectBolge">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurSelectKurum"><?php echo $data["KurumAdi"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectKurum" name="TurSelectKurum">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurGun"><?php echo $data["Gunler"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectGun" name="TurSelectGun" multiple="multiple">
                            <option value="Pzt"><?php echo $data["Pazartesi"]; ?></option>
                            <option value="Sli"><?php echo $data["Sali"]; ?></option>
                            <option value="Crs"><?php echo $data["Carsamba"]; ?></option>
                            <option value="Prs"><?php echo $data["Persembe"]; ?></option>
                            <option value="Cma"><?php echo $data["Cuma"]; ?></option>
                            <option value="Cmt"><?php echo $data["Cumartesi"]; ?></option>
                            <option value="Pzr"><?php echo $data["Pazar"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurSaat1"><?php echo $data["Saat"]; ?></label>
                        <select type="text" class="form-control" id="TurSaat1" name="TurSaat1">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurSaat2"><?php echo $data["Saat"]; ?></label>
                        <select type="text" class="form-control" id="TurSaat2" name="TurSaat2">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurArac"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="TurArac" name="TurArac">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurSofor"><?php echo $data["Sofor"]; ?></label>
                        <select type="text" class="form-control" id="TurSofor" name="TurSofor">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="TurTuru"><?php echo $data["Tür"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectTip" name="TurSelectTip" multiple="multiple">
                            <option value="1"><?php echo $data["Gidis"]; ?></option>
                            <option value="0"><?php echo $data["Donus"]; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-vertical col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                    <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kurumDetay" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["KurumDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="kurumDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="generalInfo col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <h4><?php echo $data["GenelBilgi"]; ?></h4>
                        <hr/>
                        <input id="adminKurumDetailID" name="adminKurumDetailID" type="hidden" value="" />
                        <input id="adminKurumDetailLocation" name="adminKurumDetailLocation" type="hidden" value="" />
                        <div class="form-group">
                            <label for="KurumAdi"><?php echo $data["KurumAdi"]; ?></label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button data-type="svOpen" data-class="map" class="btn btn-success svToggle" data-islemler="adminKurumMap" type="button">
                                        <i class="fa fa-map-marker"></i>
                                    </button>
                                </span>
                                <input type="text" class="form-control dsb" id="KurumAdi" name="KurumDetailAdi" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="KurumBolge"><?php echo $data["Bolge"]; ?></label>
                            <input type="text" class="form-control" id="KurumBolgeAdi" name="KurumDetailBolge" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="KurumTel"><?php echo $data["Telefon"]; ?></label>
                            <input type="text" class="form-control dsb" id="KurumBolgeTelefon" name="KurumDetailTelefon" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="KurumEmail"><?php echo $data["Email"]; ?></label>
                            <input type="text" class="form-control dsb" id="KurumBolgeEmail" name="KurumDetailEmail" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="KurumAdres"><?php echo $data["Adres"]; ?></label>
                            <textarea name="KurumDetailAdres" class="form-control dsb" rows="3" disabled=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                            <textarea name="KurumDetailAciklama" class="form-control dsb" rows="3" disabled=""></textarea>
                        </div>
                        <div class="form-group submit-group">
                            <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="adminKurumDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                            <button type="button" class="btn btn-success save" data-Saveislem="adminKurumDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" data-Editislem="adminKurumDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                            <button id="KurumDetailDeleteBtn" data-type="svClose"  data-class="kurumDetay" type="button" data-islemler="adminKurumDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h4><?php echo $data["Turlar"]; ?> <button id="addNew" type="button" class="svToggle btn btn-success btn-sm pull-right addNewButton" data-type="svOpen" data-class="kurum" data-islemler="adminKurumTurEkle"><i class="fa fa-plus-square"></i> <?php echo $data["YeniEkle"]; ?></button> <button class="btn btn-success btn-sm pull-right seeAllButton" onclick="location.href = '<?php echo SITE_PLUGINADMIN_Tur; ?>'"><?php echo $data["TumunuGor"]; ?></button></h4>
                        <hr/>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminKurumTurTable">
                                    <thead>
                                        <tr >
                                            <th><?php echo $data["TurAdi"]; ?></th>
                                            <th><?php echo $data["Tür"]; ?></th>
                                            <th><?php echo $data["Aciklama"]; ?></th>
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
            <span class="pull-right"><button id="saveMap" data-islemler="adminHaritaKaydet" data-type="svClose" data-class="map" type="button" class="svToggle btn btn-success"><i class="fa fa-map-marker"></i> Konumu Kaydet</button></span>
        </h3>
        <hr/>
    </div>
    <div id="multiple_map" style="width:100% !important;"></div>
</div><!-- ./wrapper -->



