<script type="text/javascript">
    var activeMenu = "menu_tur";
    var activeLink = "link_turliste";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminturajaxquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/admintur-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>
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
                <input id="TurGidis" name="TurGidis" type="hidden" value="" />
                <input id="TurDonus" name="TurDonus" type="hidden" value="" />
                <input id="TurID" name="TurID" type="hidden" value="" />
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-vertical" id="turForm">
                    <input id="adminKurumBolgeEkleID" name="adminKurumBolgeEkleID" type="hidden"/>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurAdi"><?php echo $data["TurAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="TurAdi" name="TurAdi" >
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="TurSaat1"><?php echo $data["BasSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurSaat1" name="TurSaat1">
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="TurSaat2"><?php echo $data["BitSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurSaat2" name="TurSaat2">
                            </select>
                        </div>
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
                            <option value="0"><?php echo $data["Gidis"]; ?></option>
                            <option value="1"><?php echo $data["Donus"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 submit-group" style="display:block !important">
                        <button data-type="svClose"  data-class="tur" type="button" data-islemler="adminTurVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="adminTurKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div style=""><?php echo $data["ToplamKm"]; ?> : <span id="totalKm" style="font-weight: bold;color:black"></span></div>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"  id="multiple_tur_map" style="top: 112px; right:10px;border: 2px solid #009933 !important;bottom: 10%">

                </div>
            </div>
        </div>
    </div>
</div>

<div id="turSecim" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurSecim"]; ?> <span class="pull-right"><button data-type="svClose" data-class="turSecim" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <section class="content">

                <!-- Kutular -->
                <div class="row">
                    <input id="adminTurDetayTip" name="adminTurDetayTip" type="hidden" value="" />
                    <input id="adminTurID" name="adminTurID" type="hidden" value="" />
                    <div class="col-lg-4 col-xs-12">
                        <!-- Gidiş İşlemleri -->
                        <input id="adminTurDetayGds" name="adminTurDetayGds" type="hidden" value="" />
                        <a id="adminTurDetayGds" class="svToggle small-box bg-green" data-type="svOpen" data-islemler="adminTurDetayGidis" data-class="turDetayGidis">
                            <div class="inner">
                                <h3>
                                    <?php echo $data["Gidis"]; ?>
                                </h3>
                                <p>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-hand-o-right"></i>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-xs-12">
                        <!-- Dönüş İşlemleri -->
                        <input id="adminTurDetayDns" name="adminTurDetayDns" type="hidden" value="" />
                        <a id="turDetayDonus" class="small-box bg-green">
                            <div class="inner">
                                <h3>
                                    <?php echo $data["Donus"]; ?>
                                </h3>
                                <p>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-hand-o-left"></i>
                            </div>
                        </a>
                    </div>

            </section>
        </div>
    </div>
</div>

<div id="turDetayGidis" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurGidis"]; ?> <span class="pull-right"><button data-type="svClose" data-class="turDetayGidis" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <input id="TurGidis" name="TurGidis" type="hidden" value="" />
                <input id="TurDonus" name="TurDonus" type="hidden" value="" />
                <input id="TurID" name="TurID" type="hidden" value="" />
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-vertical" id="turDetayGidisForm">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurDetayGidisAd"><?php echo $data["TurAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="TurDetayGidisAd" name="TurDetayGidisAd" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="TurDetayGidisBolgeID" name="TurDetayGidisBolgeID" type="hidden" value="" />
                        <label for="TurDetayGidisBolge"><?php echo $data["BolgeAd"]; ?></label>
                        <input type="text" class="form-control" id="TurDetayGidisBolge" name="TurDetayGidisBolge" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="TurDetayGidisKurumID" name="TurDetayGidisKurumID" type="hidden" value="" />
                        <input id="TurDetayGidisKurumLocation" name="TurDetayGidisKurumLocation" type="hidden" value="" />
                        <label for="TurDetayGidisKurum"><?php echo $data["KurumAdi"]; ?></label>
                        <input type="text" class="form-control" id="TurDetayGidisKurum" name="TurDetayGidisKurum" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurDetayGidisGun"><?php echo $data["Gunler"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayGidisGun" name="TurDetayGidisGun" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input id="gidisSaat1" name="gidisSaat1" type="hidden" value="" />
                            <label for="TurDetayGidisSaat1"><?php echo $data["BasSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurDetayGidisSaat1" name="TurDetayGidisSaat1">
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input id="gidisSaat2" name="gidisSaat2" type="hidden" value="" />
                            <label for="TurDetayGidisSaat2"><?php echo $data["BitSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurDetayGidisSaat2" name="TurDetayGidisSaat2">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurDetayGidisArac"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayGidisArac" name="TurDetayGidisArac">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="GidisSoforInput" name="GidisSoforInput" type="hidden" value="" />
                        <input id="GidisSoforID" name="GidisSoforID" type="hidden" value="" />
                        <input id="GidisSoforAd" name="GidisSoforAd" type="hidden" value="" />
                        <label for="TurDetayGidisSofor"><?php echo $data["Sofor"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayGidisSofor" name="TurDetayGidisSofor">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="TurDetayGidisAciklama" class="form-control dsb" rows="3" disabled></textarea>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group submit-group">
                            <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="turGidisDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                            <button type="button" class="btn btn-success save" data-Saveislem="turGidisDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" data-Editislem="adminTurDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                            <button data-type="svClose"  data-class="turDetayGidis" type="button" data-islemler="turGidisDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                        </div>
                    </div>
                </div>
                <div style=""><?php echo $data["ToplamKm"]; ?> : <span id="totalGidisKm" style="font-weight: bold;color:black"></span></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="multiple_gidis_map" style="top: 112px; right:10px;border: 2px solid #009933 !important;bottom: 10%">

                </div>

            </div>
        </div>
    </div>
</div>

<div id="turDetayDonus" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurDonus"]; ?> <span class="pull-right"><button data-type="svClose" data-class="turDetayDonus" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <input id="TurGidis" name="TurGidis" type="hidden" value="" />
                <input id="TurDonus" name="TurDonus" type="hidden" value="" />
                <input id="TurID" name="TurID" type="hidden" value="" />
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-vertical" id="turForm">
                    <input id="adminKurumBolgeEkleID" name="adminKurumBolgeEkleID" type="hidden"/>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurAdi"><?php echo $data["TurAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="TurAdi" name="TurAdi" >
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="TurSaat1"><?php echo $data["BasSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurSaat1" name="TurSaat1">
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="TurSaat2"><?php echo $data["BitSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurSaat2" name="TurSaat2">
                            </select>
                        </div>
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
                            <option value="0"><?php echo $data["Gidis"]; ?></option>
                            <option value="1"><?php echo $data["Donus"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 submit-group" style="display:block !important">
                        <button data-type="svClose"  data-class="tur" type="button" data-islemler="adminTurVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="adminTurKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="infobox-wrapper">
    <div id="infobox">
    </div>
</div>
<div class="infobox-gidis-wrapper">
    <div id="infoboxGidis">
    </div>
</div>

