<!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <form class="form-vertical" method="post">
                <section class="content-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <h1>
                                    <i class="fa fa-building"></i> Firma İşlemleri
                                    <small>Kontrol Paneli</small>
                                </h1>
                            </div>
                            <div class="col-md-6" style="text-align:right; padding-right:15px; padding-top:15px;">
                                <div class="form-group submit-group">
                                    <button type="button" class="btn btn-default vzg">Vazgeç</button>
                                    <button type="submit" class="btn btn-success">Kaydet</button>
                                </div>
                                <div class="form-group edit-group">
                                    <button type="button" id="editForm" class="btn btn-primary">Düzenle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <hr />
                <!-- Main content -->
                <section class="content">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <h4>Genel Bilgiler</h4>
                            <hr />
                            <input id="FirmaID" name="FirmaID" type="hidden" value="" />
                            <input id="FirmaKodu" name="FirmaKodu" type="hidden" value="" />
                            <div class="form-group">
                                <label for="FrmKod">Firma Kodu</label>
                                <input type="text" class="form-control" id="FrmKod" name="FrmKod" value="FRM-4850" disabled>
                            </div>
                            <div class="form-group">
                                <label for="FirmaAdi">Firma Adı</label>
                                <input type="text" class="form-control dsb" id="FirmaAdi" name="FirmaAdi" value="Sevis Amca" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Aciklama">Açıklama</label>
                                <textarea name="Aciklama" class="form-control dsb" rows="3" disabled>Servis Firması</textarea>
                            </div>
                            <div class="form-group">
                                <label for="FirmaDurum">Durum</label>
                                <select id="FirmaDurum" name="FirmaDurum" class="form-control" disabled>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                            <br />
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-6">
                                    <div class="row">
                                        <label for="OgrenciServis" class="control-label col-md-12 dsb"><input id="OgrenciServis" name="OgrenciServis" type="checkbox" class="dsb" checked disabled /> Öğrenci Servisi</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-xs-6">
                                    <div class="row">
                                        <label for="PersonelServis" class="control-label col-md-12 dsb"><input id="PersonelServis" name="PersonelServis" type="checkbox" class="dsb" checked disabled /> Personel Servisi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <h4>İletişim Bilgileri</h4>
                            <hr />
                            <div class="form-group">
                                <label for="FirmaAdres">Adres</label>
                                <textarea name="Aciklama" class="form-control dsb" rows="3" disabled>Mevlana Mah. Turgut Özal Bulv. Talas Beğendik Karşısı.</textarea>
                            </div>
                            <div class="form-group">
                                <label for="FirmaIl">İl</label>
                                <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                    <option value="38" selected>Kayseri</option>
                                    <option value="34">İstanbul</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="FirmaIlce">İlçe</label>
                                <select id="FirmaDurum" name="FirmaDurum" class="form-control dsb" disabled>
                                    <option value="1" selected>Talas</option>
                                    <option value="2">Melikgazi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="FirmaTelefon">Telefon</label>
                                <input type="text" class="form-control dsb" id="FirmaTelefon" name="FirmaTelefon" value="+90 352 226 85 76" disabled>
                            </div>
                            <div class="form-group">
                                <label for="FirmaEmail">Email</label>
                                <input type="email" class="form-control dsb" id="FirmaEmail" name="FirmaEmail" value="info@servisamca.com" disabled>
                            </div>
                            <div class="form-group">
                                <label for="FirmaWebAdresi">Web Sitesi</label>
                                <input type="text" class="form-control dsb" id="FirmaWebAdresi" name="FirmaWebAdresi" value="www.servisamca.com" disabled>
                            </div>
                            <div class="form-group">
                                <label for="FirmaLokasyon">Lokasyon</label>
                                <input type="text" class="form-control dsb" id="FirmaLokasyon" name="FirmaLokasyon" value="38.693693, 35.549510" disabled>
                            </div>


                        </div>
                </section><!-- /.content -->
            </form>
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->