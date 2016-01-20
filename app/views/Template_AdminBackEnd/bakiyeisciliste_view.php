<script type="text/javascript">
    var activeMenu = "menu_bakiye";
    var activeLink = "link_bakiye";
</script>
<script src="<?php echo SITE_PLUGINADMIN_JS; ?>/jquery.maskMoney.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminbakiyeisciajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminbakiyeisci-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-briefcase"></i> <?php echo $data["TitleIsci"]; ?>
                    <small id="smallIsci"><?php if (count($model[0]['IsciCount']) > 0) { ?>
                            <?php
                            echo $model[0]['IsciCount'];
                        } else {
                            ?>
                            <?php
                            echo '0 ';
                        }
                        ?></small>&nbsp;<small><?php echo $data["Toplam"]; ?></small>
                </h3>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="bakiyeIsciTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Adi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Soyadi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["OdemeTutar"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["OdenilenTutar"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["KalanTutar"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="isciRow">
                        <?php foreach ($model as $adminModel) { ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>" value="<?php echo $adminModel['ID']; ?>">
                                        <i class="glyphicon glyphicon-user"></i> <?php
                                        echo $adminModel['Adi'];
                                        ?>
                                    </a>
                                </td>
                                <td class="hidden-xs"><?php echo $adminModel['Soyad']; ?></td>
                                <td class="hidden-xs"><?php echo $adminModel['OdemeTutar'] . " " . $adminModel['OdemeParaTip']; ?></td>
                                <td class="hidden-xs"><?php echo $adminModel['OdenenTutar'] . " " . $adminModel['OdemeParaTip']; ?></td>
                                <td class="hidden-xs"><?php echo $adminModel['KalanTutar'] . " " . $adminModel['OdemeParaTip']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>
<style>
    table#odemeDetay{
        font:13px / 1.4 Helvetica, arial, nimbussansl, liberationsans,
            freesans, clean, sans-serif, "Apple Color Emoji",
            "Segoe UI Emoji", "Segoe UI Symbol"
    }
</style>
<div id="IsciDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <h4><i class="fa fa-briefcase"></i> <b id="isciAdSoyad"></b></h4>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <h4><div style=""><?php echo $data["Toplam"]; ?> : <span id="totalMoney"></span></div></h4>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <h4><div style=""><?php echo $data["Odenilen"]; ?> : <span id="odenenMoney"></span></div></h4>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <h4><div style=""><?php echo $data["Kalan"]; ?> : <span id="kalanMoney"></span></div></h4>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding-right:0 ">
                    <span class="pull-right">
                        <button id="addNew" type="button" class="svToggle btn btn-success addNewButton mr10" data-type="svOpen" data-class="isciOdeme" data-islemler="isciOdemeYeni">
                            <i class="fa fa-money"></i> <?php echo $data["YeniOdeme"]; ?></button>
                        <button data-type="svClose" data-class="IsciDetay" type="button" class="svToggle btn btn-danger">
                            <i class="fa fa-times-circle"></i></button></span>
                </div>  
            </div>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical addIsciForm col-lg-12 col-md-12 col-sm-6 col-xs-6">
                    <input id="isciDetayID" name="isciDetayID" type="hidden" value="" />
                    <input id="odemeDovizTip" name="odemeDovizTip" type="hidden" value="" />
                    <table id="odemeDetay"  class="table table-responsive display table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo $data["OdemeAlan"]; ?></th>
                                <th><?php echo $data["OdemeYapan"]; ?></th>
                                <th><?php echo $data["Tutar"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["OdemeSekli"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Aciklama"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["Tarih"]; ?></th>
                                <th class="hidden-xs"><?php echo $data["İslemler"]; ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="isciOdeme" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?php echo $data["YeniOdeme"]; ?>  ( <i class="fa fa-briefcase"></i> <span id="isciOdemeAdSoyad"></span> )<span class="pull-right"><button data-type="svClose" data-class="isciOdeme"  type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                    <div class="form-group">
                        <label for="OdemeYapan"><?php echo $data["OdemeYapan"]; ?></label>
                        <select type="text" class="form-control" id="odemeYapan" name="odemeYapan">
                            <option value="0"><?php echo $data["Seciniz"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding-left: 0">
                        <label for="odemeTutar"><?php echo $data["OdemeTutar"]; ?></label>
                        <input type="text" class="form-control" id="odemeTutar" name="odemeTutar" value="">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-right: 0">
                        <label for="dovizTip"><?php echo $data["DovizIsim"]; ?></label>
                        <input type="text" class="form-control" id="dovizTip" name="dovizTip" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["OdemeSekli"]; ?></label>
                        <select type="text" class="form-control" id="odemeSekil" name="odemeSekil">
                            <option value="0"><?php echo $data["Elden"]; ?></option>
                            <option value="1"><?php echo $data["KrediKartı"]; ?></option>
                            <option value="2"><?php echo $data["Havale"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="bakiyeAciklama" class="form-control" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svClose"  data-class="isciOdeme" type="button" data-islemler="isciOdemeCancel" class="svToggle btn btn-default"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" data-type="svClose"  data-islemler="odemeKaydet" data-class="isciOdeme" class="svToggle btn btn-success"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="isciOdemeDuzenle" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input id="rowID" name="rowID" type="hidden" value="" />
            <h3><?php echo $data["YeniOdeme"]; ?>  ( <i class="fa fa-briefcase"></i> <span id="isciDOdemeAdSoyad"></span> )<span class="pull-right"><button data-type="svClose" data-class="isciOdemeDuzenle"  type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                    <div class="form-group">
                        <label for="OdemeDYapan"><?php echo $data["OdemeYapan"]; ?></label>
                        <select type="text" class="form-control dsb" id="odemeDYapan" name="odemeDYapan" disabled>
                        </select>
                    </div>
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding-left: 0">
                        <label for="odemeDTutar"><?php echo $data["OdemeTutar"]; ?></label>
                        <input type="text" class="form-control dsb" id="odemeDTutar" name="odemeDTutar" value="" disabled>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-right: 0">
                        <label for="dovizDTip"><?php echo $data["DovizIsim"]; ?></label>
                        <input type="text" class="form-control" id="dovizDTip" name="dovizDTip" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="odemeDSekil"><?php echo $data["OdemeSekli"]; ?></label>
                        <select type="text" class="form-control dsb" id="odemeDSekil" name="odemeDSekil" disabled>
                            <option value="0"><?php echo $data["Elden"]; ?></option>
                            <option value="1"><?php echo $data["KrediKartı"]; ?></option>
                            <option value="2"><?php echo $data["Havale"]; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Aciklama"><?php echo $data["Aciklama"]; ?></label>
                        <textarea name="bakiyeDAciklama" class="form-control dsb" rows="3" style="resize:none" disabled></textarea>
                    </div>
                    <div class="form-group submit-group">
                        <button data-type="svClose" type="button" class="btn btn-default vzg" data-Vzgislem="adminBakiyeDetailVazgec"><?php echo $data["Vazgec"]; ?></button>
                        <button type="button" class="btn btn-success save" data-Saveislem="adminBakiyeDetailKaydet"><?php echo $data["Kaydet"]; ?></button>
                    </div>
                    <div class="form-group edit-group">
                        <button id="editForm" type="button" data-Editislem="adminBakiyeDetailEdit" class="btn btn-success"><?php echo $data["Duzenle"]; ?></button>
                        <button  data-type="svClose"  data-class="isciOdemeDuzenle" type="button" data-islemler="adminBakiyeDetailSil" class="btn btn-danger svToggle" ><?php echo $data["Sil"]; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="odemeprint" style="height:auto; padding: 1.1cm; background: #fff; border:2px solid #e6e6e6; font-family: Arial; display: none;">
    <img src="<?php echo SITE_IMG; ?>/shuttle2.png" alt="<?php echo SITE_AD; ?>" style="width:auto; height: 3cm; display: block; margin: 0 auto;" />
    <br/>
    <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; margin-bottom: 0.2cm;"></div>
    <div style="padding: 0.2cm;height: 80%;">
        <font style="font-size: 14pt; font-weight: bold; color: #D20F0F;"><?php echo $data["OdemeDetay"]; ?></font> <br/>
        <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; padding-bottom: 0.2cm;"></div>
        <br/> <br/>
        <font style="font-size: 12pt;line-height: 17pt;">
        <b><?php echo $data["OdemeAlan"]; ?> :</b> <span id="prOdemeAlan"></span> <br/> <br/>
        <b><?php echo $data["OdemeYapan"]; ?> :</b> <span id="prOdemeYapan"></span> <br/> <br/>
        <b><?php echo $data["Tutar"]; ?> :</b> <span id="prOdemeTutar"></span> <br/> <br/>
        <b><?php echo $data["OdemeSekli"]; ?> :</b> <span id="prOdemeSekli"></span> <br/> <br/>
        <b><?php echo $data["Aciklama"]; ?> :</b> <span id="prOdemeAciklama"></span> <br/> <br/>
        <b><?php echo $data["Tarih"]; ?> :</b> <span id="prOdemeTarih"></span> <br/> <br/>
        </font>
    </div>
</div>



