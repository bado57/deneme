<script type="text/javascript">
    var activeMenu = "menu_lokasyon";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminlokasyonajaxquery.js" type="text/javascript"></script> 
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminlokasyon-web.app.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>

<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["AracLokasyon"]; ?>
                    <small id="smallArac"><?php if (count($model[0]['AdminAracCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminAracCount'];
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
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminLokasyonTable">
                    <thead>
                        <tr>
                            <th ><?php echo $data["Plaka"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Sofor"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["TurAdi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["TurKurum"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["TurBolge"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Tür"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["TurKm"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminLokasyonRow">
                        <?php foreach ($model as $aracTurModel) { ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" data-tur="<?php echo $aracTurModel['aktifTurID']; ?>" data-turtip="<?php echo $aracTurModel['aktifTurTip']; ?>" data-turgidisdonus="<?php echo $aracTurModel['aktifAracTip']; ?>"
                                       title="<?php echo $data["Detay"]; ?>" value="<?php echo $aracTurModel['aktifAracID']; ?>">
                                        <i class="fa fa-map-marker" style="color:green"></i> <?php echo $aracTurModel['aktifAracPlaka']; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs"><?php echo $aracTurModel['aktifAracSoforAd']; ?></td>
                                <td class="hidden-xs"><?php echo $aracTurModel['aktifTurAd']; ?></td>
                                <td class="hidden-xs" value="<?php echo $aracTurModel['aktifAracID']; ?>" data-kurumlocation="<?php echo $aracTurModel['aktifAracKurumLocation']; ?>"><?php echo $aracTurModel['aktifAracKurumAd']; ?></td>
                                <td class="hidden-xs"><?php echo $aracTurModel['aktifAracBolgeAd']; ?></td>
                                <td class="hidden-xs"><?php echo $aracTurModel['aktifAracTip'] == '0' ? $data["Gidis"] : $data["Donus"]; ?></td>
                                <td class="hidden-xs"><?php echo $aracTurModel['aktifAracTurKm']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>

<div id="aracDetay" class="svOpen col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="hd">
                <h3><?php echo $data["AracLokasyon"]; ?> <span id="turTipSubView"></span> (<span id="totalKm" style="font-weight: bold;color:black"></span>)<span class="pull-right"><button data-type="svClose" data-class="aracDetay" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
                <hr/>
            </div>
            <div id="lokasyonForm">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  id="multiple_lokasyon_map">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="infobox-wrapper">
    <div id="infobox">
    </div>
</div>


