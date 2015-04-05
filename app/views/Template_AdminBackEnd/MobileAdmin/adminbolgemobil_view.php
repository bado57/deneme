<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_FONTS; ?>/css/font-awesome.min.css">
            <!-- Bootstrap wysihtml5 - text editor -->
            <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
            <!-- Theme style -->
            <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/shuttle.css" rel="stylesheet" type="text/css" />
            <!-- jQuery 2.0.2 -->
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/jquery.min.js" type="text/javascript"></script>
            <!-- jQuery UI 1.10.3 -->
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
            <!-- Page Scroll -->
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/jquery.nicescroll.min.js" type="text/javascript"></script>


            <!-- Bootstrap -->
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/bootstrap.min.js" type="text/javascript"></script>

            <!-- Datatables & Bootstrap -->
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/dataTables.bootstrap.js" type="text/javascript"></script>
            <script type="text/javascript" src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/adminajax.mobile.js" ></script>
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

            </head>
            <body>
            <div class="wrapper">
                <input type="hidden" name="adminUserID" value="<?php echo $model[0]['AdminUserID']; ?>">
                    <input type="hidden" name="adminRutbe" value="<?php echo $rutbe; ?>">
                        <input type="hidden" name="adminUsername" value="<?php echo $model[0]['AdminUsername']; ?>">
                            <input type="hidden" name="adminFirmId" value="<?php echo $model[0]['AdminFirmaId']; ?>">
                                <input type="hidden" name="enlem" value="<?php echo $model[0]['enlem']; ?>">
                                    <input type="hidden" name="boylam" value="<?php echo $model[0]['boylam']; ?>">
                                        <aside class="">
                                            <section class="content-header">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                                                            <h3>
                                                                <i class="fa fa-th"></i> <?php echo $data["Bolgeler"]; ?>
                                                                <small id="smallBolge"><?php echo $model[0]['AdminBolgeCount']; ?></small>&nbsp<small><?php echo $data["Toplam"]; ?></small>
                                                            </h3>
                                                        </div>
                                                        <?php if ($rutbe != 0) { ?>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right" style="text-align:right;">
                                                                <div class="form-group">
                                                                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminBolgeYeni" data-class="bolge"><i class="fa fa-plus-square"></i> <?php echo $data['BolgeYeni']; ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </section>
                                            <section class="content">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <table class="table table-responsive table-bordered table-hover" id="adminBolgeTable">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo $data["BolgeAd"]; ?></th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="adminBolgeRow">

                                                                <?php for ($v = 0; $v < count($model); $v++) { ?>
                                                                    <tr>
                                                                <input id="adminBolgeRow" name="adminBolgeRow" type="hidden" value="<?php echo $model[$v]['AdminBolgeID']; ?>" />
                                                                <td>
                                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $model[$v]['AdminBolgeID']; ?>">
                                                                        <i class="fa fa-search"></i> <?php echo $model[$v]['AdminBolge']; ?>
                                                                    </a>
                                                                </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </section>
                                        </aside>

                                        <div id="bolge" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
                                            <div class="row">
                                                <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3><?php echo $data["BolgeTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="bolge"  type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
                                                    <hr/>
                                                    <div class="row" id="getPartialView">
                                                        <form class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                                                            <div class="form-group">
                                                                <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                                                                <input type="text" class="form-control" id="BolgeAdi" name="BolgeAdi" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                                                                <textarea name="BolgeAciklama" class="form-control dsb" rows="3"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <button data-type="svClose"  data-class="bolge" type="button" data-islemler="adminBolgeCancel" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                                                                <button type="button" data-type="svClose"  data-islemler="adminBolgeKayit" data-class="bolge" class="svToggle btn btn-success"><?php echo $data["Kaydet"]; ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="kurum" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
                                            <div class="row">
                                                <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3><?php echo $data["KurumTanimlama"]; ?> <span class="pull-right"><button data-type="svClose" data-class="kurum" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
                                                    <hr/>
                                                    <div class="row" id="getPartialView">
                                                        <div class="form-vertical addKurumForm col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                            <input id="adminBolgeKurumEkleID" name="adminBolgeKurumEkleID" type="hidden" value="" />
                                                            <div class="form-group">
                                                                <label for="KurumAdi"><?php echo $data["KurumAdi"]; ?></label>
                                                                <input type="text" class="form-control" id="KurumAdi" name="KurumAdi" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="KurumLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <button data-type="svOpen" data-class="map" class="btn btn-success svToggle" data-islemler="adminBolgeMobilSingleMap" type="button">
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
                                                                <button data-type="svClose"  data-class="kurum" type="button" data-islemler="adminBolgeKurumVazgec" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                                                                <button type="button" class="svToggle btn btn-success" data-type="svClose"  data-class="kurum" data-islemler="adminBolgeKurumKaydet"><?php echo $data["Kaydet"]; ?></button>
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

                                        <div id="bolgeDetay" class="svClose col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
                                            <div class="row">
                                                <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3><?php echo $data["BolgeDetay"]; ?> <span class="pull-right"><button data-type="svClose" data-class="bolgeDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
                                                    <hr/>
                                                    <div class="row" id="getPartialView">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="generalInfo col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                <h4><?php echo $data["GenelBilgi"]; ?></h4>
                                                                <hr/>
                                                                <input id="adminBolgeDetailID" name="adminBolgeDetailID" type="hidden" value="" />
                                                                <div class="form-group">
                                                                    <label for="BolgeAdi"><?php echo $data["BolgeAd"]; ?></label>
                                                                    <input type="text" class="form-control dsb" id="BolgeAdi" name="BolgeDetailAdi" value="" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                                                                    <textarea name="BolgeDetailAciklama" class="form-control dsb" rows="3" disabled=""></textarea>
                                                                </div>
                                                                <div class="form-group submit-group">
                                                                    <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="adminBolgeDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                                                                    <button type="button" class="btn btn-success save" data-Saveislem="adminBolgeDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                                                                </div>
                                                                <div class="form-group edit-group">
                                                                    <button id="editForm" type="button" data-Editislem="adminBolgeDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                                                                    <button id="BolgeDetailDeleteBtn" data-type="svClose"  data-class="bolgeDetay" type="button" data-islemler="adminBolgeDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                <h4><?php echo $data["Kurumlar"]; ?> <button id="addNew" type="button" class="svToggle btn btn-success btn-sm pull-right addNewButton" data-type="svOpen" data-class="kurum" data-islemler="adminBolgeKurumEkle"><i class="fa fa-plus-square"></i> <?php echo $data["YeniEkle"]; ?></button> <button class="btn btn-success btn-sm pull-right seeAllButton"><?php echo $data["TumunuGor"]; ?></button></h4>
                                                                <hr/>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <table class="table table-responsive table-bordered table-hover table-condensed" id="adminBolgeKurumTable">
                                                                            <thead>
                                                                                <tr >
                                                                                    <th><?php echo $data["KurumAdi"]; ?></th>
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
                                                    <span class="pull-right"><button id="saveMap" data-islemler="adminKurumHaritaKaydet" data-type="svClose" data-class="map" type="button" class="svToggle btn btn-success"><i class="fa fa-map-marker"></i>&nbsp<?php echo $data["KonumuKaydet"]; ?></button></span>
                                                </h3>
                                                <hr/>
                                            </div>
                                            <div id="multiple_map" style="width:100% !important;"></div>
                                        </div>

                                        </div>
                                        <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/icheck.min.js" type="text/javascript"></script>
                                        <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/shuttle-web.app.js" type="text/javascript"></script>
                                        </body>
                                        </html>
