<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/bootstrap.css">
            <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_FONTS; ?>/css/font-awesome.min.css">
                <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS; ?>/shuttle-mobile.min.css">

                    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/jquery-1.11.2.min.js"></script>
                    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/bootstrap.min.js"></script>
                    <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs; ?>/adminajaxmobile.js" type="text/javascript"></script>
                    <script src="<?php echo SITE_PLUGINM_JS; ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
                    <script src="<?php echo SITE_PLUGINMADMIN_JS; ?>/shuttle.app.js"></script>
                    </head>
                    <body>
                        <header class="mobile">
                            <nav class="navbar navbar-default navbar-fixed-bottom top-menu">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="appButton navbar-toggle collapsed" data-toggle="collapse" data-target="#form-actions">
                                            <span class="sr-only"><?php echo $data["İslemler"]; ?></span>
                                            <i class="fa fa-gear"></i> <?php echo $data["İslemler"]; ?>
                                        </button>
                                        <a class="navbar-brand" href="#"><i class="fa fa-building"></i><?php echo $data["Firmaİslem"]; ?></a>
                                    </div>
                                    <?php if ($rutbe != 0) { ?>
                                        <div class="collapse navbar-collapse" id="form-actions">
                                            <ul class="nav navbar-nav navbar-right app-navbar">
                                                <li><button class="btn btn-app"><i class="fa fa-home"></i><?php echo $data["AnaMenuDon"]; ?></button></li>
                                                <li><button type="button" class="btn btn-app" id="editForm" onclick="$.AdminIslemler.adminFirmaDuzenle()"><i class="fa fa-edit"></i><?php echo $data["Duzenle"]; ?></button></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </nav>
                        </header>
                    <div class="wrapper">
                        <section class="detail-section">
                            <div class="col-md-12">
                                <form class="form-vertical">
                                    <h4><?php echo $data["GenelBilgi"]; ?></h4>
                                    <hr />
                                    <input id="FirmaDurum" name="Durum" type="hidden" value="<?php echo $model['60298ee45f6a299875562fff9846cbd0']; ?>" />
                                    <div class="form-group">
                                        <label for="FrmKod"><?php echo $data["FirmaKodu"]; ?></label>
                                        <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="<?php echo $model['00fe1774a569ef59e554731bbee4ea63']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaAdi"><?php echo $data["FirmaAdı"]; ?></label>
                                        <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="<?php echo $model['b396451b1996fa04924f7ba0b8316573']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                                        <textarea name="Aciklama" class="form-control dsb" rows="3" disabled><?php echo $model['1759cc8d99e1bac25f37202ee2a41060']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaDurum"><?php echo $data["Durum"]; ?></label>
                                        <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled>
                                            <?php
                                            if ($model['60298ee45f6a299875562fff9846cbd0'] != 0) {
                                                ;
                                                ?>
                                                <option value="1" selected><?php echo $data["Aktif"]; ?></option>
                                            <?php } else { ?>
                                                <option value="0" selected><?php echo $data["Pasif"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="form-group col-md-6 col-xs-6">
                                            <div class="row">
                                                <label for="OgrenciServis" class="control-label col-md-12 dsb"><input id="OgrenciServis" name="OgrenciServis" type="checkbox" class="dsb" checked disabled <?php echo ($model['0540649c021082d7d1b9038d1964fad8'] != 0 ? checked : ''); ?>/><?php echo $data["OgrenciServisi"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-xs-6">
                                            <div class="row">
                                                <label for="PersonelServis" class="control-label col-md-12 dsb"><input id="PersonelServis" name="PersonelServis" type="checkbox" class="dsb" checked disabled <?php echo ($model['a2cc74afcae8ebd81a31e060ea4a7627'] != 0 ? checked : ''); ?>/><?php echo $data["PersonelServisi"]; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br />

                                    <h4><?php echo $data["Iletisim"]; ?></h4>
                                    <hr />
                                    <div class="form-group">
                                        <label for="FUlke"><?php echo $data["Ulke"]; ?></label>
                                        <select id="FirmaUlke" name="FirmaUlke" class="form-control dsb" disabled>
                                            <option value="38" selected>Türkiye</option>
                                            <option value="34">USA</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaAdres"><?php echo $data["Adres"]; ?></label>
                                        <textarea name="Aciklama" class="form-control dsb" rows="3" disabled><?php echo $model['8840e644fb753306a040eff6eb9de195']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaIl"><?php echo $data["Il"]; ?></label>
                                        <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                            <option value="38" selected>Kayseri</option>
                                            <option value="34">İstanbul</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaIlce"><?php echo $data["Ilce"]; ?></label>
                                        <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                            <option value="1" selected>Talas</option>
                                            <option value="2">Melikgazi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaTelefon"><?php echo $data["Telefon"]; ?></label>
                                        <input type="text" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="<?php echo $model['2ab5b2e998b599e343f7fbaf18227b4d']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaEmail"><?php echo $data["Email"]; ?></label>
                                        <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="<?php echo $model['685bf8d64f11d160c35529a9554900ed']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaWebAdresi"><?php echo $data["WebSite"]; ?></label>
                                        <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="<?php echo $model['4a821589992e93f9a001222cb1709efb']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirmaLokasyon"><?php echo $data["Lokasyon"]; ?></label>
                                        <input type="text" class="form-control dsb" id="FirmaLokasyon" name="FirmaLokasyon" value="<?php echo $model['07bc35c9581aca8a9c4924697a02ed36']; ?>" disabled>
                                    </div>

                                    <div class="form-group submit-group">
                                        <hr />
                                        <button type="button" class="btn btn-default vzg"  onclick="$.AdminIslemler.adminFirmaVazgec()"><?php echo $data["Vazgec"]; ?></button>
                                        <button type="button" class="btn btn-success" onclick="$.AdminIslemler.adminFirmaOzellik()"><?php echo $data["Kaydet"]; ?></button>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                    </body>
                    </html>