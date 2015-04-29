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
            <h3><?php echo $data["TurTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="tur" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-vertical">
                    <input id="adminKurumBolgeEkleID" name="adminKurumBolgeEkleID" type="hidden"/>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurAdi"><?php echo $data["TurAdi"]; ?></label>
                        <input type="text" class="form-control" id="TurAdi" name="TurAdi">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSelectBolge"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectBolge" name="TurSelectBolge">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSelectKurum"><?php echo $data["KurumAdi"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectKurum" name="TurSelectKurum">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSaat1"><?php echo $data["Saat"]; ?></label>
                        <select type="text" class="form-control" id="TurSaat1" name="TurSaat1">
                            <option value="-1"><?php echo $data["Seciniz"]; ?></option>
                            <option value="0">00:00</option>
                            <option value="115">01:15</option>
                            <option value="130">01:30</option>
                            <option value="145">01:45</option>
                            <option value="200">02:00</option>
                            <option value="215">02:15</option>
                            <option value="230">02:30</option>
                            <option value="245">02:45</option>
                            <option value="300">03:00</option>
                            <option value="315">03:15</option>
                            <option value="330">03:30</option>
                            <option value="345">03:45</option>
                            <option value="400">04:00</option>
                            <option value="415">04:15</option>
                            <option value="430">04:30</option>
                            <option value="445">04:45</option>
                            <option value="500">05:00</option>
                            <option value="515">05:15</option>
                            <option value="530">05:30</option>
                            <option value="545">05:45</option>
                            <option value="600">06:00</option>
                            <option value="615">06:15</option>
                            <option value="630">06:30</option>
                            <option value="645">06:45</option>
                            <option value="700">07:00</option>
                            <option value="715">07:15</option>
                            <option value="730">07:30</option>
                            <option value="745">07:45</option>
                            <option value="800">08:00</option>
                            <option value="815">08:15</option>
                            <option value="830">08:30</option>
                            <option value="845">08:45</option>
                            <option value="900">09:00</option>
                            <option value="915">09:15</option>
                            <option value="930">09:30</option>
                            <option value="945">09:45</option>
                            <option value="1000">10:00</option>
                            <option value="1015">10:15</option>
                            <option value="1030">10:30</option>
                            <option value="1045">10:45</option>
                            <option value="1100">11:00</option>
                            <option value="1115">11:15</option>
                            <option value="1130">11:30</option>
                            <option value="1145">11:45</option>
                            <option value="1200">12:00</option>
                            <option value="1215">12:15</option>
                            <option value="1230">12:30</option>
                            <option value="1245">12:45</option>
                            <option value="1300">13:00</option>
                            <option value="1315">13:15</option>
                            <option value="1330">13:30</option>
                            <option value="1345">13:45</option>
                            <option value="1400">14:00</option>
                            <option value="1415">14:15</option>
                            <option value="1430">14:30</option>
                            <option value="1445">14:45</option>
                            <option value="1500">15:00</option>
                            <option value="1515">15:15</option>
                            <option value="1530">15:30</option>
                            <option value="1545">15:45</option>
                            <option value="1600">16:00</option>
                            <option value="1615">16:15</option>
                            <option value="1630">16:30</option>
                            <option value="1645">16:45</option>
                            <option value="1700">17:00</option>
                            <option value="1715">17:15</option>
                            <option value="1730">17:30</option>
                            <option value="1745">17:45</option>
                            <option value="1800">18:00</option>
                            <option value="1815">18:15</option>
                            <option value="1830">18:30</option>
                            <option value="1845">18:45</option>
                            <option value="1900">19:00</option>
                            <option value="1915">19:15</option>
                            <option value="1930">19:30</option>
                            <option value="1945">19:45</option>
                            <option value="2000">20:00</option>
                            <option value="2015">20:15</option>
                            <option value="2030">20:30</option>
                            <option value="2045">20:45</option>
                            <option value="2100">21:00</option>
                            <option value="2115">21:15</option>
                            <option value="2130">21:30</option>
                            <option value="2145">21:45</option>
                            <option value="2200">22:00</option>
                            <option value="2215">22:15</option>
                            <option value="2230">22:30</option>
                            <option value="2245">22:45</option>
                            <option value="2300">23:00</option>
                            <option value="2315">23:15</option>
                            <option value="2330">23:30</option>
                            <option value="2345">23:45</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSaat2"><?php echo $data["Saat"]; ?></label>
                        <select type="text" class="form-control" id="TurSaat2" name="TurSaat2">
                            <option value="-1"><?php echo $data["Seciniz"]; ?></option>
                            <option value="0">00:00</option>
                            <option value="115">01:15</option>
                            <option value="130">01:30</option>
                            <option value="145">01:45</option>
                            <option value="200">02:00</option>
                            <option value="215">02:15</option>
                            <option value="230">02:30</option>
                            <option value="245">02:45</option>
                            <option value="300">03:00</option>
                            <option value="315">03:15</option>
                            <option value="330">03:30</option>
                            <option value="345">03:45</option>
                            <option value="400">04:00</option>
                            <option value="415">04:15</option>
                            <option value="430">04:30</option>
                            <option value="445">04:45</option>
                            <option value="500">05:00</option>
                            <option value="515">05:15</option>
                            <option value="530">05:30</option>
                            <option value="545">05:45</option>
                            <option value="600">06:00</option>
                            <option value="615">06:15</option>
                            <option value="630">06:30</option>
                            <option value="645">06:45</option>
                            <option value="700">07:00</option>
                            <option value="715">07:15</option>
                            <option value="730">07:30</option>
                            <option value="745">07:45</option>
                            <option value="800">08:00</option>
                            <option value="815">08:15</option>
                            <option value="830">08:30</option>
                            <option value="845">08:45</option>
                            <option value="900">09:00</option>
                            <option value="915">09:15</option>
                            <option value="930">09:30</option>
                            <option value="945">09:45</option>
                            <option value="1000">10:00</option>
                            <option value="1015">10:15</option>
                            <option value="1030">10:30</option>
                            <option value="1045">10:45</option>
                            <option value="1100">11:00</option>
                            <option value="1115">11:15</option>
                            <option value="1130">11:30</option>
                            <option value="1145">11:45</option>
                            <option value="1200">12:00</option>
                            <option value="1215">12:15</option>
                            <option value="1230">12:30</option>
                            <option value="1245">12:45</option>
                            <option value="1300">13:00</option>
                            <option value="1315">13:15</option>
                            <option value="1330">13:30</option>
                            <option value="1345">13:45</option>
                            <option value="1400">14:00</option>
                            <option value="1415">14:15</option>
                            <option value="1430">14:30</option>
                            <option value="1445">14:45</option>
                            <option value="1500">15:00</option>
                            <option value="1515">15:15</option>
                            <option value="1530">15:30</option>
                            <option value="1545">15:45</option>
                            <option value="1600">16:00</option>
                            <option value="1615">16:15</option>
                            <option value="1630">16:30</option>
                            <option value="1645">16:45</option>
                            <option value="1700">17:00</option>
                            <option value="1715">17:15</option>
                            <option value="1730">17:30</option>
                            <option value="1745">17:45</option>
                            <option value="1800">18:00</option>
                            <option value="1815">18:15</option>
                            <option value="1830">18:30</option>
                            <option value="1845">18:45</option>
                            <option value="1900">19:00</option>
                            <option value="1915">19:15</option>
                            <option value="1930">19:30</option>
                            <option value="1945">19:45</option>
                            <option value="2000">20:00</option>
                            <option value="2015">20:15</option>
                            <option value="2030">20:30</option>
                            <option value="2045">20:45</option>
                            <option value="2100">21:00</option>
                            <option value="2115">21:15</option>
                            <option value="2130">21:30</option>
                            <option value="2145">21:45</option>
                            <option value="2200">22:00</option>
                            <option value="2215">22:15</option>
                            <option value="2230">22:30</option>
                            <option value="2245">22:45</option>
                            <option value="2300">23:00</option>
                            <option value="2315">23:15</option>
                            <option value="2330">23:30</option>
                            <option value="2345">23:45</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurArac"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="TurArac" name="TurArac" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSofor"><?php echo $data["Sofor"]; ?></label>
                        <select type="text" class="form-control" id="TurSofor" name="TurSofor" multiple="multiple" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="TurTuru"><?php echo $data["Tür"]; ?></label>
                        <select type="text" class="form-control" id="TurSelectTip" name="TurSelectTip">
                            <option value="1"><?php echo $data["Gidis"]; ?></option>
                            <option value="0"><?php echo $data["Donus"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="width:80% !important;height:80% !important; margin-left: 420px;">
                    <div id="multiple_map" style="width:100% !important;"></div>
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



