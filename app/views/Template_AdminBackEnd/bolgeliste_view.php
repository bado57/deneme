<script type="text/javascript">
    var activeMenu = "menu_bolge";
    var activeLink = "link_bolgeliste";
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["Bolgeler"]; ?>
                    <small id="smallBolge"><?php echo $model[0]['AdminBolgeCount']; ?></small><small> Toplam </small>
                </h3>
            </div>
            <?php if (Session::get("userRutbe") != 0) { ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right" style="text-align:right;">
                    <div class="form-group">
                        <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svAdd" data-class="bolge"><i class="fa fa-plus-square"></i> Yeni Bölge</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover" id="adminBolgeTable">
                    <thead>
                        <tr>
                            <th><?php echo $data["BolgeAd"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeKurumSayi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeAciklama"]; ?></th>
                        </tr>
                    </thead>
                    <tbody id="adminBolgeRow">

                        <?php for ($v = 0; $v < count($model); $v++) { ?>
                            <tr>
                        <input id="adminBolgeRow" name="adminBolgeRow" type="hidden" value="<?php echo $model[$v]['AdminBolgeID']; ?>" />
                        <td>
                            <a class="" data-type="svDetail" role="button" data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $model[$v]['AdminBolgeID']; ?>">
                                <i class="fa fa-search"></i> <?php echo $model[$v]['AdminBolge']; ?>
                            </a>
                        </td>
                        <td class="hidden-xs"><?php echo $model[$v]['AdminKurum']; ?></td>
                        <td class="hidden-xs"><?php echo $model[$v]['AdminBolgeAciklama']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section><!-- /.content -->
</aside><!-- /.right-side -->

<div id="bolge" class="svAdd col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["BolgeTanımlama"]; ?> <span class="pull-right"><button data-type="svAdd" data-class="bolge" type="button" class="svToggle btn btn-danger" onclick="$.AdminIslemler.adminAddBolgeVazgec()"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <form class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                    <div class="form-group">
                        <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                        <input type="text" class="form-control" id="BolgeAdi" name="BolgeAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["AdminFirmaAciklama"]; ?></label>
                        <textarea name="BolgeAciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svAdd"  data-class="bolge" type="button" class="svToggle btn btn-default" onclick="$.AdminIslemler.adminAddBolgeVazgec()"><?php echo $data["AdminFirmaBtnVazgec"]; ?></button>
                        <button type="button" class="btn btn-success" onclick="$.AdminIslemler.adminBolgeKaydet()"><?php echo $data["AdminFirmaBtnKaydet"]; ?></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="kurum" class="svAdd col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["KurumTanımlama"]; ?> <span class="pull-right"><button data-type="svAdd" data-class="kurum" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="KurumAdi"><?php echo $data["KurumAdı"]; ?></label>
                        <input type="text" class="form-control" id="KurumAdi" name="KurumAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumLokasyon"><?php echo $data["AdminFirmaLokasyon"]; ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" id="openMap">
                                    <i class="fa fa-map-marker"></i>
                                </button>
                            </span>
                            <input type="text" class="form-control" id="KurumLokasyon" name="KurumLokasyon" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="KurumTelefon"><?php echo $data["AdminFirmaTelefon"]; ?></label>
                        <input type="text" class="form-control" id="KurumTelefon" name="KurumTelefon" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumEmail"><?php echo $data["AdminFirmaEmail"]; ?></label>
                        <input type="text" class="form-control" id="KurumEmail" name="KurumEmail" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumWebSite"><?php echo $data["AdminFirmaWebSite"]; ?></label>
                        <input type="text" class="form-control" id="KurumWebSite" name="KurumWebSite" value="">
                    </div>
                    <div class="form-group">
                        <label for="KurumAdresDetay"><?php echo $data["AdresDetay"]; ?></label>
                        <textarea name="KurumAdresDetay" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["AdminFirmaAciklama"]; ?></label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svAdd" data-class="kurum" type="button" class="svToggle btn btn-default"><?php echo $data["AdminFirmaBtnVazgec"]; ?></button>
                        <button type="button" class="btn btn-success" ><?php echo $data["AdminFirmaBtnKaydet"]; ?></button>
                    </div>

                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div id="map_div" style="width: 100%; height: 400px; display:none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="svDetail col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["BolgeDetay"]; ?> <span class="pull-right"><button data-type="svDetail" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="generalInfo col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <h4><?php echo $data["AdminFirmaGenelBilgi"]; ?></h4>
                        <hr/>
                        <input id="adminBolgeDetailID" name="adminBolgeDetailID" type="hidden" value="" />
                        <div class="form-group">
                            <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                            <input type="text" class="form-control dsb" id="BolgeAdi" name="BolgeDetailAdi" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="Aciklama"><?php echo $data["AdminFirmaAciklama"]; ?></label>
                            <textarea name="BolgeDetailAciklama" class="form-control dsb" rows="3" disabled=""></textarea>
                        </div>
                        <div class="form-group submit-group">
                            <button data-type="svDetail" type="button" class="btn btn-default vzg" onclick="$.AdminIslemler.adminBolgeDetailVazgec()"><?php echo $data["AdminFirmaBtnVazgec"]; ?></button>
                            <button type="button" class="btn btn-success" onclick="$.AdminIslemler.adminBolgeDetailKaydet()">Kaydet</button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" class="btn btn-success" onclick="$.AdminIslemler.adminBolgeDetailDuzenle()"><?php echo $data["AdminFirmaDuzenle"]; ?></button>
                            <button id="BolgeDetailDeleteBtn" type="button" class="btn btn-danger" onclick="$.AdminIslemler.adminBolgeDetailSil()"><?php echo $data["Sil"]; ?></button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h4><?php echo $data["Kurumlar"]; ?> <button id="addNew" type="button" class="svToggle btn btn-success btn-sm pull-right addNewButton" data-type="svAdd" data-class="kurum"><i class="fa fa-plus-square"></i> <?php echo $data["YeniEkle"]; ?></button> <button class="btn btn-success btn-sm pull-right seeAllButton"><?php echo $data["TumunuGor"]; ?></button></h4>
                        <hr/>
                        <ul class="list-group" id="adminBolgeKurumDetail">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- ./wrapper -->



