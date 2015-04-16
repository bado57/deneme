<script type="text/javascript">
    var activeMenu = "menu_kurum";
    var activeLink = "link_kurumliste";
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Kurumlar"]; ?>
                    <small id="smallKurum"><?php echo $model[0]['AdminKurumCount']; ?></small>&nbsp<small><?php echo $data["Toplam"]; ?></small>
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
                        <textarea name="KurumAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
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



