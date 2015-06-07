<script type="text/javascript">
    var activeMenu = "menu_duyuru";
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
                    <i class="fa fa-bullhorn"></i> <?php echo $data["Duyuru"]; ?>
                </h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-right" style="text-align:right;">
                <div class="form-group">
                    <button type="button" class="svToggle btn btn-primary btn-sm" data-type="svOpen" data-islemler="adminDuyuruYeni" data-class="duyuruPage"><i class="fa fa-plus-square"></i> <?php echo $data["YeniDuyuru"]; ?></button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover" id="duyuruTable">
                    <thead>
                        <tr>
                            <th><i class='fa fa-clock-o'></i> <?php echo $data["Tarih"]; ?></th>
                    <th><i class='fa fa-envelope'></i> <?php echo $data["Icerik"]; ?></th>
                    <th><i class='fa fa-users'></i> <?php echo $data["Hedef"]; ?></th>
                    </tr>
                    </thead>
                    <tbody id="duyuruRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['DuyuruID']; ?>">
                                        <i class="fa fa-bullhorn"></i> <?php echo $adminModel['DuyuruTarih']; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs"><?php echo $adminModel['DuyuruText']; ?></td>
                                <td class="hidden-xs"><?php echo $adminModel['DuyuruHedef']; ?> <?php echo $data["Kullanici"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</aside>

<div id="duyuruPage" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["YeniDuyuru"]; ?> <span class="pull-right"><button data-type="svClose" data-class="duyuruPage"  type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <!-- Sol Menü Filtreleme -->
                <div class='form-horizontal col-lg-9 col-md-9 col-sm-8 col-xs-12'>
                    <div class="row">
                        <!-- Bölge Filtreleme -->
                        <div class="bolgeFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruBolge"><?php echo $data["Bolge"]; ?></label>
                                <select type="text" class="form-control" id="DuyuruBolge" name="DuyuruBolge" multiple>
                                </select>
                            </div>
                            <div class="bolgeKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label id="labelAdmin" for="bolgeAdmin" class="control-label col-md-2">
                                    <input id="bolgeAdmin" name="bolgeAdmin" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Admin"]; ?></label>
                                <label for="bolgeSofor" class="control-label col-md-2">
                                    <input id="bolgeSofor" name="bolgeSofor" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Sofor"]; ?></label>
                                <label for="bolgeHostes" class="control-label col-md-2">
                                    <input id="bolgeHostes" name="bolgeHostes" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Hostes"]; ?></label>
                                <label for="bolgeVeli" class="control-label col-md-2">
                                    <input id="bolgeVeli" name="bolgeVeli" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Veli"]; ?></label>
                                <label for="bolgeOgrenci" class="control-label col-md-2">
                                    <input id="bolgeOgrenci" name="bolgeOgrenci" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Ogrenci"]; ?></label>
                                <label for="bolgePersonel" class="control-label col-md-2">
                                    <input id="bolgePersonel" name="bolgePersonel" type="checkbox" class="bolgeKullaniciCheck"/> <?php echo $data["Personel"]; ?></label>
                            </div>
                            <div class="bolgeIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="bolgeDetaylandir btn btn-info"><?php echo $data["Detaylandır"]; ?></button>
                                <button class="duyuruYaz btn btn-success" ><?php echo $data["DuyuruYaz"]; ?></button>
                            </div>
                        </div>
                        <!-- Kurum Filtreleme -->
                        <div class="kurumFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruKurum"><?php echo $data["KurumAdi"]; ?></label>
                                <select type="text" class="form-control" id="DuyuruKurum" name="DuyuruKurum" multiple style="text-align: left;">
                                </select>
                            </div>
                            <div class="kurumKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label for="kurumAdmin" class="control-label col-md-2">
                                    <input id="kurumAdmin" name="kurumAdmin" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Admin"]; ?></label>
                                <label for="kurumSofor" class="control-label col-md-2">
                                    <input id="kurumSofor" name="kurumSofor" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Sofor"]; ?></label>
                                <label for="kurumHostes" class="control-label col-md-2">
                                    <input id="kurumHostes" name="kurumHostes" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Hostes"]; ?></label>
                                <label for="kurumVeli" class="control-label col-md-2">
                                    <input id="kurumVeli" name="kurumVeli" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Veli"]; ?></label>
                                <label for="kurumOgrenci" class="control-label col-md-2">
                                    <input id="kurumOgrenci" name="kurumOgrenci" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Ogrenci"]; ?></label>
                                <label for="kurumPersonel" class="control-label col-md-2">
                                    <input id="kurumPersonel" name="kurumPersonel" type="checkbox" class="kurumKullaniciCheck" /> <?php echo $data["Personel"]; ?></label>
                            </div>
                            <div class="kurumIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="kurumGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button class="kurumDetaylandir btn btn-info"><?php echo $data["Detaylandır"]; ?></button>
                                <button class="duyuruYaz btn btn-success"><?php echo $data["DuyuruYaz"]; ?></button>
                            </div>
                        </div>
                        <!-- Tur Filtreleme -->
                        <div class="turFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruTur"><?php echo $data["Tur"]; ?></label>
                                <select type="text" class="form-control" id="DuyuruTur" name="DuyuruTur" multiple style="text-align: left;">
                                </select>
                            </div>
                            <div class="turKullanici form-group col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-top:24px;">
                                <label for="turAdmin" class="control-label col-md-2">
                                    <input id="turAdmin" name="turAdmin" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Admin"]; ?></label>
                                <label for="turSofor" class="control-label col-md-2">
                                    <input id="turSofor" name="turSofor" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Sofor"]; ?></label>
                                <label for="turHostes" class="control-label col-md-2">
                                    <input id="turHostes" name="turHostes" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Hostes"]; ?></label>
                                <label for="turVeli" class="control-label col-md-2">
                                    <input id="turVeli" name="turVeli" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Veli"]; ?></label>
                                <label for="turOgrenci" class="control-label col-md-2">
                                    <input id="turOgrenci" name="turOgrenci" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Ogrenci"]; ?></label>
                                <label for="turPersonel" class="control-label col-md-2">
                                    <input id="turPersonel" name="turPersonel" type="checkbox" class="turKullaniciCheck" /> <?php echo $data["Personel"]; ?></label>
                            </div>
                            <div class="turIslem form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="turGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button class="duyuruYaz btn btn-success" ><?php echo $data["DuyuruYaz"]; ?></button>
                            </div>
                        </div>
                        <div class="DuyuruFiltre col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="DuyuruTur"><?php echo $data["Mesajınız"]; ?></label>
                                <textarea id="duyuruText" class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" rows="3"></textarea>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="duyuruGizle btn btn-warning"><i class="fa fa-times"></i></button>
                                <button type="button" class="duyuruGonder btn btn-success svToggle" data-type="svClose"  data-class="duyuruPage" data-islemler="adminDuyuruGonder"><?php echo $data["Gonder"]; ?></button>
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
                                        <i class="fa fa-user"></i> <?php echo $data["Admin"]; ?> <span id="AdminCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="useradmin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul id="userAdmin" class="list-group">
                                    </ul>           
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#usersofor" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-user"></i> <?php echo $data["Sofor"]; ?> <span id="SoforCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="usersofor" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul id="userSofor" class="list-group">
                                    </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userhostes" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="fa fa-user"></i> <?php echo $data["Hostes"]; ?> <span id="HostesCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="userhostes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul id="userHostes" class="list-group">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userveli" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-user"></i> <?php echo $data["Veli"]; ?> <span id="VeliCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="userveli" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul id="userVeli" class="list-group">
                                    </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userogrenci" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-user"></i> <?php echo $data["Ogrenci"]; ?> <span id="OgrenciCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="userogrenci" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul id="userOgrenci" class="list-group">
                                    </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#userpersonel" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-user"></i> <?php echo $data["Personel"]; ?> <span id="PersonelCount"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="userpersonel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul id="userPersonel" class="list-group">
                                    </ul> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



