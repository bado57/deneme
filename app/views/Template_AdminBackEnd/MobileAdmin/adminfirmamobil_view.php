<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title>Deneme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS;?>/bootstrap.css">
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_FONTS;?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PLUGINMADMIN_CSS;?>/shuttle-mobile.min.css">
</head>
<body>
    <header class="mobile">
        <nav class="navbar navbar-default navbar-fixed-bottom top-menu">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="appButton navbar-toggle collapsed" data-toggle="collapse" data-target="#form-actions">
                            <span class="sr-only"><?php echo $data["AdminFirmaİslemler"];?></span>
                            <i class="fa fa-gear"></i> <?php echo $data["AdminFirmaİslemler"];?>
                        </button>
                        <a class="navbar-brand" href="#"><i class="fa fa-building"></i><?php echo $data["AdminFirmaİslem"];?></a>
                    </div>
                    <div class="collapse navbar-collapse" id="form-actions">
                        <ul class="nav navbar-nav navbar-right app-navbar">
                            <li><button class="btn btn-app"><i class="fa fa-home"></i><?php echo $data["AdminFirmaAnaMenuDon"];?></button></li>
                            <li><button class="btn btn-app" id="editForm"><i class="fa fa-edit"></i><?php echo $data["AdminFirmaDuzenle"];?></button></li>
                        </ul>
                    </div>
                </div>
        </nav>
    </header>
    <div class="wrapper">
        <section class="detail-section">
                <div class="col-md-12">
                    <form class="form-vertical" method="post">
                        <h4><?php echo $data["AdminFirmaGenelBilgi"];?></h4>
                        <hr />
                        <input id="FirmaID" name="FirmaID" type="hidden" value="" />
                        <input id="FirmaKodu" name="FirmaKodu" type="hidden" value="" />
                        <input id="FirmaDurum" name="FirmaDurum" type="hidden" value="" />
                        <div class="form-group">
                            <label for="FrmKod"><?php echo $data["AdminFirmaGenelBilgi"];?></label>
                            <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaAdi"><?php echo $data["AdminFirmaGenelBilgi"];?></label>
                            <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="Aciklama"><?php echo $data["AdminFirmaGenelBilgi"];?></label>
                            <textarea name="Aciklama" class="form-control dsb" rows="3" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label for="FirmaDurum"><?php echo $data["AdminFirmaDurum"];?></label>
                            <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled>
                                <option value="1" selected><?php echo $data["AdminFirmaDurumAktif"];?></option>
                                <option value="0"><?php echo $data["AdminFirmaDurumPasif"];?></option>
                            </select>
                        </div>
                        <br />
                        <div class="row">
                            <div class="form-group col-md-6 col-xs-6">
                                <div class="row">
                                    <label for="OgrenciServis" class="control-label col-md-12 dsb"><input id="OgrenciServis" name="OgrenciServis" type="checkbox" class="dsb" checked disabled /><?php echo $data["AdminFirmaOgrenciServisi"];?></label>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-xs-6">
                                <div class="row">
                                    <label for="PersonelServis" class="control-label col-md-12 dsb"><input id="PersonelServis" name="PersonelServis" type="checkbox" class="dsb" checked disabled /><?php echo $data["AdminFirmaPersonelServisi"];?></label>
                                </div>
                            </div>
                        </div>
                        <br />
                        
                        <h4><?php $data["AdminFirmaIletisim"];?></h4>
                        <hr />
                        <div class="form-group">
                            <label for="FirmaAdres"><?php echo $data["AdminFirmaAdres"];?></label>
                            <textarea name="Aciklama" class="form-control dsb" rows="3" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label for="FirmaIl"><?php echo $data["AdminFirmaIl"];?></label>
                            <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                <option value="38" selected>Kayseri</option>
                                <option value="34">İstanbul</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="FirmaIlce"><?php echo $data["AdminFirmaIlce"];?></label>
                            <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                <option value="1" selected>Talas</option>
                                <option value="2">Melikgazi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="FirmaTelefon"><?php echo $data["AdminFirmaTelefon"];?></label>
                            <input type="text" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaEmail"><?php echo $data["AdminFirmaEmail"];?></label>
                            <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaWebAdresi"><?php echo $data["AdminFirmaWebSite"];?></label>
                            <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaLokasyon"><?php echo $data["AdminFirmaLokasyon"];?></label>
                            <input type="text" class="form-control dsb" id="FirmaLokasyon" name="FirmaLokasyon" value="" disabled>
                        </div>
                        
                        <div class="form-group submit-group">
                            <hr />
                            <button type="button" class="btn btn-default vzg"  onclick="$.adminFirmaIslem()"><?php echo $data["AdminFirmaBtnVazgec"];?></button>
                            <button type="submit" class="btn btn-success" onclick="$.AdminIslemler.adminFirmaOzellik()"><?php echo $data["AdminFirmaBtnKaydet"];?></button>
                        </div>
                    </form>
                </div>
        </section>
    </div>
    
    <script src="<?php echo SITE_PLUGINMADMIN_JS;?>/jquery-1.11.2.min.js"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_JS;?>/bootstrap.min.js"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_JS;?>/shuttle.app.js"></script>
    <script src="<?php echo SITE_PLUGINMADMIN_AjaxJs;?>/adminajaxquery.js" type="text/javascript"></script>
</body>
</html>