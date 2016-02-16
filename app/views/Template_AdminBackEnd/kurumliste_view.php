<script type="text/javascript">
    var activeMenu = "menu_kurum";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminkurumajaxquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminkurum-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-building-o"></i> <?php echo $data["Kurumlar"]; ?>
                    <small id="smallKurum"><?php if (count($model[0]['AdminKurumCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminKurumCount'];
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
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminKurumYeni" data-class="kurum"><i class="fa fa-plus-square"></i> <?php echo $data['KurumYeni']; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminKurumTable">
                    <thead>
                        <tr>
                            <th><?php echo $data["KurumAdi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeAd"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["TurSayi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Tür"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminKurumRow">
                        <?php foreach ($model as $kurumModel) { ?>
                            <tr>
                        <input id="adminKurumRow" name="adminKurumRow" type="hidden" value="<?php echo $kurumModel['AdminKurumID']; ?>" />
                        <td>
                            <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $kurumModel['AdminKurumID']; ?>">
                                <i class="fa fa-search"></i> <?php echo $kurumModel['AdminKurum']; ?>
                            </a>
                        </td>
                        <td class="hidden-xs" value="<?php echo $kurumModel['AdminKurumBolgeID']; ?>"><?php echo $kurumModel['AdminKurumBolge']; ?></td>
                        <td class="hidden-xs"><?php echo $kurumModel['AdminKurumTur']; ?></td>
                        <?php if ($kurumModel['AdminKurumTip'] == 0) { ?>
                            <td class="hidden-xs"><?php echo $data["Ogrenci"]; ?></td>
                        <?php } else if ($kurumModel['AdminKurumTip'] == 1) { ?>
                            <td class="hidden-xs"><?php echo $data["Isci"]; ?></td>
                        <?php } else { ?>
                            <td class="hidden-xs"><?php echo $data["OgrenciPersonel"]; ?></td>
                        <?php } ?>
                        <td class="hidden-xs"><?php echo $kurumModel['AdminKurumAciklama']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="kurum" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["KurumTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="kurum" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input id="adminKurumBolgeEkleID" name="adminKurumBolgeEkleID" type="hidden" value="" />
                    <div class="form-group">
                        <label for="KurumAdi"><?php echo $data["KurumAdi"]; ?></label>
                        <input type="text" class="form-control" id="KurumAdi" name="KurumAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="BolgeAdi"><?php echo $data["BolgeAdi"]; ?></label>
                        <select type="text" class="form-control" id="KurumBolgeSelect" name="KurumSelect">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="KurumTip"><?php echo $data["KurumTip"]; ?></label>
                        <select type="text" class="form-control" id="KurumTip" name="KurumTip">
                            <?php if (Session::get("OgrServis") == 1) { ?>
                                <option value="0"><?php echo $data["Ogrenci"]; ?></option>
                            <?php } ?>
                            <?php if (Session::get("PersServis") == 1) { ?>
                                <option value="1"><?php echo $data["Isci"]; ?></option>
                            <?php } ?>
                            <?php if (Session::get("OgrServis") == 1 && Session::get("PersServis") == 1) { ?>
                                <option value="2"><?php echo $data["OgrenciPersonel"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="KurumLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-type="svOpen" data-class="map" class="btn btn-success svToggle" data-islemler="adminBolgeSingleMap" type="button">
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="locationInput form-control" id="KurumLokasyon" name="KurumLokasyon" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="KurumTelefon"><?php echo $data["Telefon"]; ?></label>
                        <input type="text" class="form-control" id="KurumTelefon" name="KurumTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumEmail"><?php echo $data["Email"]; ?></label>
                        <input type="text" class="form-control" id="KurumEmail" name="KurumEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumWebSite"><?php echo $data["WebSite"]; ?></label>
                        <input type="text" class="form-control" id="KurumWebSite" name="KurumWebSite" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="KurumAdresDetay" class="form-control" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="kurum" type="button" data-islemler="adminKurumVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="kurum" data-islemler="adminKurumEkle"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="form-vertical KurumAdresForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="KurumUlke"><?php echo $data["Ulke"]; ?></label>
                        <input type="text" class="form-control" id="KurumUlke" name="country" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumSehir"><?php echo $data["Il"]; ?></label>
                        <input type="text" class="form-control" id="KurumSehir" name="administrative_area_level_1" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumIlce"><?php echo $data["Ilce"]; ?></label>
                        <input type="text" class="form-control" id="KurumIlce" name="administrative_area_level_2" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumSemt"><?php echo $data["Semt"]; ?></label>
                        <input type="text" class="form-control" id="KurumSemt" name="locality" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumMahalle"><?php echo $data["Mahalle"]; ?></label>
                        <input type="text" class="form-control" id="KurumMahalle" name="neighborhood" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumSokak"><?php echo $data["CaddeSokak"]; ?></label>
                        <input type="text" class="form-control" id="KurumSokak" name="route" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="KurumPostaKodu"><?php echo $data["PostaKodu"]; ?></label>
                        <input type="text" class="form-control" id="KurumPostaKodu" name="postal_code" value="" disabled>
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
                        <input id="kurumDetayBolgeID" name="kurumDetayBolgeID" type="hidden" value="" />
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
                            <label for="KurumDetayTip"><?php echo $data["KurumTip"]; ?></label>
                            <select type="text" class="form-control dsb" id="KurumDetayTip" name="KurumDetayTip" disabled>
                                <?php if (Session::get("OgrServis") == 1) { ?>
                                    <option value="0"><?php echo $data["Ogrenci"]; ?></option>
                                <?php } ?>
                                <?php if (Session::get("PersServis") == 1) { ?>
                                    <option value="1"><?php echo $data["Isci"]; ?></option>
                                <?php } ?>
                                <?php if (Session::get("OgrServis") == 1 && Session::get("PersServis") == 1) { ?>
                                    <option value="2"><?php echo $data["OgrenciPersonel"]; ?></option>
                                <?php } ?>
                            </select>
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
                            <textarea name="KurumDetailAdres" class="form-control dsb" rows="3" disabled="" style="resize:none"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                            <textarea name="KurumDetailAciklama" class="form-control dsb" rows="3" disabled="" style="resize:none"></textarea>
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
                        <h4><?php echo $data["Turlar"]; ?> <button  type="button" class="svToggle btn btn-success btn-sm pull-right addNewButton" data-type="svOpen" data-class="tur" data-islemler="adminKurumTurYeni"><i class="fa fa-plus-square"></i> <?php echo $data["YeniEkle"]; ?></button> <button class="btn btn-success btn-sm pull-right seeAllButton" onclick="location.href = '<?php echo SITE_PLUGINADMIN_Tur; ?>'"><?php echo $data["TumunuGor"]; ?></button></h4>
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
                        <label for="KurumTurBolgeAdi"><?php echo $data["BolgeAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="KurumTurBolgeAdi" name="KurumTurBolgeAdi" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="KurumTurKurumAdi"><?php echo $data["KurumAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="KurumTurKurumAdi" name="KurumTurKurumAdi" disabled>
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="TurArac"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="TurArac" name="TurArac" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurHostes"><?php echo $data["Hostes"]; ?></label>
                        <select type="text" class="form-control" id="TurHostes" name="TurHostes" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurSofor"><?php echo $data["Sofor"]; ?></label>
                        <select type="text" class="form-control" id="TurSofor" name="TurSofor" style="display: none;">
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
                        <textarea name="TurAciklama" class="form-control dsb" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 submit-group" style="display:block !important">
                        <button data-type="svClose"  data-class="tur" type="button" data-islemler="adminKurumTurVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="adminKurumTurKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["ToplamKm"]; ?> : <span id="totalKm" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["AracKapasite"]; ?> : <span id="totalKapasite" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["TurKisi"]; ?> : <span id="totalKisi" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"  id="multiple_kurum_tur_map" style="top: 18%; right:10px;border: 2px solid #009933 !important;bottom: 10%">

                </div>
            </div>
        </div>
    </div>
</div>


<div id="turSecim" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["TurSecim"]; ?> <span class="pull-right"><button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="turRaporDiv" data-islemler="turDetailRapor"><i class="fa fa-line-chart"></i> <?php echo $data["Rapor"]; ?></button><button data-type="svClose" data-class="turSecim" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
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
                        <a id="turDetayDns" class="svToggle small-box bg-green" data-type="svOpen" data-islemler="adminTurDetayDonus" data-class="turDetayDonus">
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="GidisHostesInput" name="GidisHostesInput" type="hidden" value="" />
                        <input id="GidisHostesID" name="GidisHostesID" type="hidden" value="" />
                        <input id="GidisHostesAd" name="GidisHostesAd" type="hidden" value="" />
                        <label for="TurDetayGidisHostes"><?php echo $data["Hostes"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayGidisHostes" name="TurDetayGidisHostes">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="TurDetayGidisAciklama" class="form-control dsb" rows="3" disabled style="resize:none"></textarea>
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
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["ToplamKm"]; ?> : <span id="totalGidisKm" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["AracKapasite"]; ?> : <span id="totalGidisKapasite" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["TurKisi"]; ?> : <span id="totalGidisKisi" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="multiple_kurum_gidis_map" style="top: 18%; right:10px;border: 2px solid #009933 !important;bottom: 10%">

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
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-vertical" id="turDetayDonusForm">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurDetayDonusAd"><?php echo $data["TurAdi"]; ?></label>
                        <input type="text" class="form-control dsb" id="TurDetayDonusAd" name="TurDetayDonusAd" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="TurDetayGidisBolgeID" name="TurDetayDonusBolgeID" type="hidden" value="" />
                        <label for="TurDetayDonusBolge"><?php echo $data["BolgeAd"]; ?></label>
                        <input type="text" class="form-control" id="TurDetayDonusBolge" name="TurDetayDonusBolge" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="TurDetayDonusKurumID" name="TurDetayDonusKurumID" type="hidden" value="" />
                        <input id="TurDetayDonusKurumLocation" name="TurDetayDonusKurumLocation" type="hidden" value="" />
                        <label for="TurDetayDonusKurum"><?php echo $data["KurumAdi"]; ?></label>
                        <input type="text" class="form-control" id="TurDetayDonusKurum" name="TurDetayDonusKurum" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="TurDetayDonusGun"><?php echo $data["Gunler"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayDonusGun" name="TurDetayDonusGun" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input id="donusSaat1" name="donusSaat1" type="hidden" value="" />
                            <label for="TurDetayDonusSaat1"><?php echo $data["BasSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurDetayDonusSaat1" name="TurDetayDonusSaat1">
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input id="donusSaat2" name="donusSaat2" type="hidden" value="" />
                            <label for="TurDetayDonusSaat2"><?php echo $data["BitSaat"]; ?></label>
                            <select type="text" class="form-control" id="TurDetayDonusSaat2" name="TurDetayDonusSaat2">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="TurDetayDonusArac"><?php echo $data["Araclar"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayDonusArac" name="TurDetayDonusArac">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="DonusSoforInput" name="DonusSoforInput" type="hidden" value="" />
                        <input id="DonusSoforID" name="DonusSoforID" type="hidden" value="" />
                        <input id="DonusSoforAd" name="DonusSoforAd" type="hidden" value="" />
                        <label for="TurDetayDonusSofor"><?php echo $data["Sofor"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayDonusSofor" name="TurDetayDonusSofor">
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="DonusHostesInput" name="DonusHostesInput" type="hidden" value="" />
                        <input id="DonusHostesID" name="DonusHostesID" type="hidden" value="" />
                        <input id="DonusHostesAd" name="DonusHostesAd" type="hidden" value="" />
                        <label for="TurDetayDonusHostes"><?php echo $data["Hostes"]; ?></label>
                        <select type="text" class="form-control" id="TurDetayDonusHostes" name="TurDetayDonusHostes">
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="TurDetayDonusAciklama" class="form-control dsb" rows="3" disabled style="resize:none"></textarea>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group submit-group">
                            <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="turDonusDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                            <button type="button" class="btn btn-success save" data-Saveislem="turDonusDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" data-Editislem="adminTurDetailEditDonus" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                            <button data-type="svClose"  data-class="turDetayDonus" type="button" data-islemler="turDonusDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["ToplamKm"]; ?> : <span id="totalDonusKm" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["AracKapasite"]; ?> : <span id="totalDonusKapasite" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div style=""><?php echo $data["TurKisi"]; ?> : <span id="totalDonusKisi" style="font-weight: bold;color:black"></span></div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="multiple_kurum_donus_map" style="top: 18%; right:10px;border: 2px solid #009933 !important;bottom: 10%">

                </div>

            </div>
        </div>
    </div>
</div>
<div id="turRaporDiv" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><i class="fa fa-refresh"></i>    <span id="turRaporAd"></span> <b id="turAdSoyad"></b> <span class="pull-right"><button data-type="svClose" data-class="turRaporDiv" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addOgrenciForm col-lg-12 col-md-12 col-sm-6 col-xs-6">
                    <table id="turRaporTable"  class="table table-responsive display table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Km</th>
                                <th><?php echo $data["ToplamSaat"]; ?></th>
                                <th><?php echo $data["BasSaat"]; ?></th>
                                <th><?php echo $data["BitSaat"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Tip"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["TurKisi"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Gun"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Tarih"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Tür"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["İslemler"]; ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="turRaporDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><i class="fa fa-refresh"></i>    <span id="turRaporDAd"></span> <b id="turAdSoyad"></b> <span class="pull-right"><button data-type="svClose" data-class="turRaporDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="form-vertical addOgrenciForm col-lg-12 col-md-12 col-sm-6 col-xs-6">
                        <h5><i class="fa fa-thumbs-o-up"></i>    <span><?php echo $data["Gelenler"]; ?></span></h5>
                        <table id="turRaporGelen"  class="table table-responsive display table-hover table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $data["Ad"]; ?></th>
                                    <th><?php echo $data["Soyad"]; ?></th>
                                    <th class="hidden-xs"><?php echo $data["Tip"]; ?></th>
                                    <th class="hidden-xs"><?php echo $data["Saat"]; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-vertical addOgrenciForm col-lg-12 col-md-12 col-sm-6 col-xs-6">
                        <h5><i class="fa fa-thumbs-o-down"></i>    <span><?php echo $data["Gelmeyenler"]; ?></span></h5>
                        <table id="turRaporGelmeyen"  class="table table-responsive display table-hover table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $data["Ad"]; ?></th>
                                    <th><?php echo $data["Soyad"]; ?></th>
                                    <th class="hidden-xs"><?php echo $data["Tip"]; ?></th>
                                </tr>
                            </thead>
                        </table>
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

<div class="infobox-wrapper">
    <div id="infobox">
    </div>
</div>
<div class="infobox-gidis-wrapper">
    <div id="infoboxGidis">
    </div>
</div>
<div class="infobox-donus-wrapper">
    <div id="infoboxDonus">
    </div>
</div>