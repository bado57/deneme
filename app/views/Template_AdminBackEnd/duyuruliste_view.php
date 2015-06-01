<script type="text/javascript">
    var activeMenu = "menu_bolge";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminduyuruajaxquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminduyuru-web.app.js" type="text/javascript"></script> 

<style type="text/css">
    .kurumFiltre, .turFiltre, .DuyuruFiltre{
        display: none;
    }
    .bolgeKullanici, .bolgeIslem, .kurumKullanici, .kurumIslem, .turKullanici, .turIslem{
        display: none;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-bullhorn"></i> Duyurular
                </h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right" style="text-align:right;">
                <div class="form-group">
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminDuyuruYeni" data-class="duyuru"><i class="fa fa-plus-square"></i> Yeni Duyuru</button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><i class='fa fa-clock-o'></i> Tarih</th>
                    <th><i class='fa fa-envelope'></i> İçerik</th>
                    <th><i class='fa fa-users'></i> Hedef</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>23/05/2015</td>
                            <td>Vakıf Bank İlkokulu giriş saatleri değiştiğinden yarından itibaren servis başlangıç saatleri sabah 07:00'den 07:30'a alınmıştır.</td>
                            <td>143 Kullanıcı</td>
                        </tr>
                        <tr>
                            <td>22/05/2015</td>
                            <td>Yarınki hava koşulları nedeniyle okullar tatil olduğundan servis yapılmayacaktır.</td>
                            <td>265 Kullanıcı</td>
                        </tr>
                        <tr>
                            <td>23/05/2015</td>
                            <td>Vakıf Bank İlkokulu giriş saatleri değiştiğinden yarından itibaren servis başlangıç saatleri sabah 07:00'den 07:30'a alınmıştır.</td>
                            <td>143 Kullanıcı</td>
                        </tr>
                        <tr>
                            <td>23/05/2015</td>
                            <td>Vakıf Bank İlkokulu giriş saatleri değiştiğinden yarından itibaren servis başlangıç saatleri sabah 07:00'den 07:30'a alınmıştır.</td>
                            <td>143 Kullanıcı</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="duyuru" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Yeni Duyuru <span class="pull-right"><button data-type="svClose" data-class="duyuru"  type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <!-- Sol Menü Filtreleme -->
                <div class='form-horizontal col-lg-9 col-md-9 col-sm-8 col-xs-12'>
                    <div class="row">
                        <!-- Bölge Filtreleme -->
                        <div class="bolgeFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruBolge">Bölge</label>
                                <select type="text" class="form-control" id="DuyuruBolge" name="DuyuruBolge" multiple required="required">
                                    <option value="1">Akdeniz</option>
                                    <option value="2">Karadeniz</option>
                                </select>
                            </div>
                            <div class="bolgeKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label for="bolgeAdmin" class="control-label col-md-2">
                                    <input id="bolgeAdmin" name="bolgeAdmin" type="checkbox" class="bolgeKullaniciCheck" /> Admin</label>
                                <label for="bolgeSofor" class="control-label col-md-2">
                                    <input id="bolgeSofor" name="bolgeSofor" type="checkbox" class="bolgeKullaniciCheck" /> Şoför</label>
                                <label for="bolgeHostes" class="control-label col-md-2">
                                    <input id="bolgeHostes" name="bolgeHostes" type="checkbox" class="bolgeKullaniciCheck" /> Hostes</label>
                                <label for="bolgeVeli" class="control-label col-md-2">
                                    <input id="bolgeVeli" name="bolgeVeli" type="checkbox" class="bolgeKullaniciCheck" /> Veli</label>
                                <label for="bolgeOgrenci" class="control-label col-md-2">
                                    <input id="bolgeOgrenci" name="bolgeOgrenci" type="checkbox" class="bolgeKullaniciCheck" /> Öğrenci</label>
                                <label for="bolgePersonel" class="control-label col-md-2">
                                    <input id="bolgePersonel" name="bolgePersonel" type="checkbox" class="bolgeKullaniciCheck" /> Personel</label>
                            </div>
                            <div class="bolgeIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="bolgeDetaylandir btn btn-info">Detaylandır</button>
                                <button class="duyuruYaz btn btn-success">Duyuru Yaz</button>
                            </div>
                        </div>
                        <!-- Kurum Filtreleme -->
                        <div class="kurumFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruKurum">Kurum</label>
                                <select type="text" class="form-control" id="DuyuruKurum" name="DuyuruKurum" multiple style="text-align: left;">
                                    <option value="1">Cumhuriyet İlkokulu</option>
                                    <option value="2">Denizli Lisesi</option>
                                </select>
                            </div>
                            <div class="kurumKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label for="kurumAdmin" class="control-label col-md-2">
                                    <input id="kurumAdmin" name="kurumAdmin" type="checkbox" class="kurumKullaniciCheck" /> Admin</label>
                                <label for="kurumSofor" class="control-label col-md-2">
                                    <input id="kurumSofor" name="kurumSofor" type="checkbox" class="kurumKullaniciCheck" /> Şoför</label>
                                <label for="kurumHostes" class="control-label col-md-2">
                                    <input id="kurumHostes" name="kurumHostes" type="checkbox" class="kurumKullaniciCheck" /> Hostes</label>
                                <label for="kurumVeli" class="control-label col-md-2">
                                    <input id="kurumVeli" name="kurumVeli" type="checkbox" class="kurumKullaniciCheck" /> Veli</label>
                                <label for="kurumOgrenci" class="control-label col-md-2">
                                    <input id="kurumOgrenci" name="kurumOgrenci" type="checkbox" class="kurumKullaniciCheck" /> Öğrenci</label>
                                <label for="kurumPersonel" class="control-label col-md-2">
                                    <input id="kurumPersonel" name="kurumPersonel" type="checkbox" class="kurumKullaniciCheck" /> Personel</label>
                            </div>
                            <div class="kurumIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="kurumGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button class="kurumDetaylandir btn btn-info">Detaylandır</button>
                                <button class="duyuruYaz btn btn-success">Duyuru Yaz</button>
                            </div>
                        </div>
                        <!-- Tur Filtreleme -->
                        <div class="turFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruTur">Tur</label>
                                <select type="text" class="form-control" id="DuyuruTur" name="DuyuruTur" multiple style="text-align: left;">
                                    <option value="1">Cumhuriyet İlkokulu - 1</option>
                                    <option value="2">Denizli Lisesi - 1</option>
                                    <option value="3">Denizli Lisesi - 2</option>
                                </select>
                            </div>
                            <div class="turKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label for="turAdmin" class="control-label col-md-2">
                                    <input id="turAdmin" name="turAdmin" type="checkbox" class="turKullaniciCheck" /> Admin</label>
                                <label for="turSofor" class="control-label col-md-2">
                                    <input id="turSofor" name="turSofor" type="checkbox" class="turKullaniciCheck" /> Şoför</label>
                                <label for="turHostes" class="control-label col-md-2">
                                    <input id="turHostes" name="turHostes" type="checkbox" class="turKullaniciCheck" /> Hostes</label>
                                <label for="turVeli" class="control-label col-md-2">
                                    <input id="turVeli" name="turVeli" type="checkbox" class="turKullaniciCheck" /> Veli</label>
                                <label for="turOgrenci" class="control-label col-md-2">
                                    <input id="turOgrenci" name="turOgrenci" type="checkbox" class="turKullaniciCheck" /> Öğrenci</label>
                                <label for="turPersonel" class="control-label col-md-2">
                                    <input id="turPersonel" name="turPersonel" type="checkbox" class="turKullaniciCheck" /> Personel</label>
                            </div>
                            <div class="turIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="turGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button class="duyuruYaz btn btn-success">Duyuru Yaz</button>
                            </div>
                        </div>
                        <!-- Duyuru Yazma -->
                        <div class="DuyuruFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruTur">Mesajınız</label>
                                <textarea class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" rows="3"></textarea>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="duyuruGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button class="duyuruGonder btn btn-success">Gönder</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sağ Menü Kullanıcılar -->
                <div class='col-lg-3 col-md-3 col-sm-4 col-xs-12' style="border-left:1px solid gray;">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#useradmin" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa fa-user"></i> Admin (2)
                                    </a>
                                </h4>
                            </div>
                            <div id="useradmin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label for="user-1" class="control-label">
                                                <input id="user-1" name="user-1" type="checkbox" class="" checked /> Ahmet Yılmaz</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="user-2" class="control-label">
                                                <input id="user-2" name="user-2" type="checkbox" class="" checked /> Filiz Yücel</label>
                                        </li>
                                    </ul>           
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userSofor" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-user"></i> Şoför (3)
                                    </a>
                                </h4>
                            </div>
                            <div id="userSofor" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label for="user-1" class="control-label">
                                                <input id="user-1" name="user-1" type="checkbox" class="" checked /> Ahmet Yılmaz</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="user-2" class="control-label">
                                                <input id="user-2" name="user-2" type="checkbox" class="" checked /> Filiz Yücel</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="user-3" class="control-label">
                                                <input id="user-3" name="user-3" type="checkbox" class="" checked /> Hakan Yıldırım</label>
                                        </li>
                                    </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userHostes" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="fa fa-user"></i> Hostes (1)
                                    </a>
                                </h4>
                            </div>
                            <div id="userHostes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label for="user-1" class="control-label">
                                                <input id="user-1" name="user-1" type="checkbox" class="" checked /> Ahmet Yılmaz</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- ./wrapper -->

<script type="text/javascript">
    var bolgeler = new Array();
    var kurumlar = new Array();
    var turlar = new Array();
    $(document).ready(function () {
        $(document).on("change", "#DuyuruBolge", function () {
            bolgeler = $(this).val();
            $(".kurumFiltre").fadeOut();
            $(".turFiltre").fadeOut();
            $(".DuyuruFiltre").fadeOut();
            if (bolgeler) {
                $(".bolgeKullanici").fadeIn();
                $(".bolgeIslem").fadeIn();
            }else {
                $(".bolgeKullanici").fadeOut();
                $(".bolgeIslem").fadeOut();
                $(".bolgeDetaylandir").fadeOut();
            }
        });
        
        $(document).on("click", ".bolgeDetaylandir", function () {
            $(".bolgeKullanici").fadeOut();
            $(".bolgeIslem").fadeOut();
            $(".kurumFiltre").fadeIn();
        });
        
        $(document).on("change", "#DuyuruKurum", function () {
            kurumlar = $(this).val();
            $(".turFiltre").fadeOut();
            $(".DuyuruFiltre").fadeOut();
            if (kurumlar) {
                $(".kurumKullanici").fadeIn();
                $(".kurumIslem").fadeIn();
            }else {
                $(".kurumKullanici").fadeOut();
                $(".kurumIslem").fadeOut();
            }
        });
        
        $(document).on("click", ".kurumGizle", function () {
            $(".kurumFiltre").fadeOut();
            $(".bolgeKullanici").fadeIn();
            $(".bolgeIslem").fadeIn();
        });
        
        $(document).on("click", ".kurumDetaylandir", function () {
            $(".kurumKullanici").fadeOut();
            $(".kurumIslem").fadeOut();
            $(".turFiltre").fadeIn();
        });
        
        $(document).on("change", "#DuyuruTur", function () {
            turlar = $(this).val();
            $(".DuyuruFiltre").fadeOut();
            if (turlar) {
                $(".kurumKullanici").fadeOut();
                $(".kurumIslem").fadeOut();
                $(".turKullanici").fadeIn();
                $(".turIslem").fadeIn();
            }else {
                $(".turKullanici").fadeOut();
                $(".turIslem").fadeOut();
            }
        });
        
        $(document).on("click", ".turGizle", function () {
            $(".turFiltre").fadeOut();
            $(".kurumKullanici").fadeIn();
            $(".kurumIslem").fadeIn();
        });
        
        $(document).on("click", ".duyuruYaz", function () {
            $(".DuyuruFiltre").fadeIn();
            $(".turIslem").fadeOut();
        });
        
        $(document).on("click", ".duyuruGizle", function () {
            $(".DuyuruFiltre").fadeOut();
            $(".turKullanici").fadeIn();
            $(".turIslem").fadeIn();
        });
    });
</script>


