<script type="text/javascript">
    //$.adminFirmaIslem = function(args) {alert("hi");};
    $(window).on('load', function () {
        $.adminFirmaIslem();
    });

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <form class="form-vertical" method="post">
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h1>
                            <i class="fa fa-building"></i> <?php echo $data["AdminFirmaİslem"]; ?>
                            <small><?php echo $data["AdminKategoriKontrolPanel"]; ?></small>
                        </h1>
                    </div>
                    <div class="col-md-6" style="text-align:right; padding-right:15px; padding-top:15px;">
                        <div class="form-group submit-group">
                            <button type="button" class="btn btn-default vzg"><?php echo $data["AdminFirmaBtnVazgec"]; ?></button>
                            <button type="submit" class="btn btn-success" onclick="$.AdminIslemler.adminFirmaOzellik()"><?php echo $data["AdminFirmaBtnKaydet"]; ?></button>
                        </div>
                        <div class="form-group edit-group">
                            <button type="button" id="editForm" class="btn btn-primary"><?php echo $data["AdminFirmaDuzenle"]; ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr />
        <!-- Main content -->
        <section class="content">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <h4><?php echo $data["AdminFirmaGenelBilgi"]; ?></h4>
                <hr />
                <input id="FirmaID" name="FirmaID" type="hidden" value="" />
                <input id="FirmaKodu" name="FirmaKodu" type="hidden" value="" />
                <input id="FirmaDurum" name="FirmaDurum" type="hidden" value="" />
                <div class="form-group">
                    <label for="FrmKod"><?php echo $data["AdminFirmaKodu"]; ?></label>
                    <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="" disabled>
                </div>
                <div class="form-group">
                    <label for="FirmaAdi"><?php echo $data["AdminFirmaAdı"]; ?></label>
                    <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="" disabled>
                </div>
                <div class="form-group">
                    <label for="Aciklama"><?php echo $data["AdminFirmaAciklama"]; ?></label>
                    <textarea name="Aciklama" class="form-control dsb" rows="3" disabled></textarea>
                </div>
                <div class="form-group">
                    <label for="FirmaDurum"><?php echo $data["AdminFirmaDurum"]; ?></label>
                    <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled>
                        <option value="1" selected><?php echo $data["AdminFirmaDurumAktif"]; ?></option>
                        <option value="0"><?php echo $data["AdminFirmaDurumPasif"]; ?></option>
                    </select>
                </div>
                <br />
                <div class="row">
                    <div class="form-group col-md-6 col-xs-6">
                        <div class="row">
                            <label for="OgrenciServis" class="control-label col-md-12 dsb"><input id="OgrenciServis" name="OgrenciServis" type="checkbox" class="dsb" checked disabled /><?php echo $data["AdminFirmaOgrenciServisi"]; ?></label>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-xs-6">
                        <div class="row">
                            <label for="PersonelServis" class="control-label col-md-12 dsb">
                                <input id="PersonelServis" name="PersonelServis" type="checkbox" class="dsb" checked disabled /><?php echo $data["AdminFirmaPersonelServisi"]; ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <h4><?php echo $data["AdminFirmaIletisim"]; ?></h4>
                <hr />
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="FirmaUlke"><?php echo $data["AdminFirmaUlke"]; ?></label>
                            <select id="FirmaUlke" name="FirmaUlke" class="form-control dsb" disabled>
                                <option value="38" selected>Türkiye</option>
                                <option value="34">USA</option>
                            </select>
                        </div>      
                        <div class="form-group">
                            <label for="FirmaIl"><?php echo $data["AdminFirmaIl"]; ?></label>
                            <select id="FirmaIl" name="FirmaIl" class="form-control dsb" disabled>
                                <option value="38" selected>Kayseri</option>
                                <option value="34">İstanbul</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="FirmaIlce"><?php echo $data["AdminFirmaIlce"]; ?></label>
                            <select id="FirmaIlce" name="FirmaIlce" class="form-control dsb" disabled>
                                <option value="1" selected>Talas</option>
                                <option value="2">Melikgazi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="FirmaAdres"><?php echo $data["AdminFirmaAdres"]; ?></label>
                            <textarea name="FirmaAdres" class="form-control dsb" rows="3" disabled></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="FirmaTelefon"><?php echo $data["AdminFirmaTelefon"]; ?></label>
                            <input type="text" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaEmail"><?php echo $data["AdminFirmaEmail"]; ?></label>
                            <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaWebAdresi"><?php echo $data["AdminFirmaWebSite"]; ?></label>
                            <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="FirmaLokasyon"><?php echo $data["AdminFirmaLokasyon"]; ?></label>
                            <input type="text" class="form-control dsb" id="FirmaLokasyon" name="FirmaLokasyon" value="" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </form>
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
