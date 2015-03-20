<script type="text/javascript">
    var activeMenu = "menu_bolge";
    var activeLink = "link_bolgeliste";
</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
                <div class="col-md-6 top-left">
                    <h3>
                        <i class="fa fa-th"></i> <?php echo $data["Bolgeler"];?>
                        <small><?php echo $data["AdminKategoriBolgeIslem"];?></small>
                    </h3>
                </div>
                <?php if (Session::get("userRutbe") != 0) { ?>
                    <div class="col-md-6 top-right" style="text-align:right;">
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
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $data["BolgeAd"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeKurumSayi"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeAciklama"]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php for ($v = 0; $v < count($model); $v++) { ?>
                            <tr>
                        <input id="adminBolgeRow" name="adminBolgeRow" type="hidden" value="<?php echo $model[$v]['AdminBolgeID']; ?>" />
                        <td>
                            <a class="svToggle" data-type="svDetail" role="button" data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"]; ?>">
                                <i class="fa fa-search"></i> <?php echo $model[$v]['AdminBolge']; ?>
                            </a>
                        </td>
                        <td class="hidden-xs"><?php echo $model[$v]['AdminKurum']; ?></td>
                        <td class="hidden-xs"><?php echo $model[$v]['AdminTur']; ?></td>
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
            <h3>Bölge Tanımlama <span class="pull-right"><button data-type="svAdd" data-class="bolge" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <form class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                    <div class="form-group">
                        <label for="BolgeAdi">Bölge Adı</label>
                        <input type="text" class="form-control" id="BolgeAdi" name="BolgeAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="Aciklama">Açıklama</label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svAdd" type="button" class="svToggle btn btn-default">Vazgeç</button>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="kurum" class="svAdd col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Kurum Tanımlama <span class="pull-right"><button data-type="svAdd" data-class="kurum" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <form class="form-vertical col-lg-4 col-md-4 col-sm-12 col-xs-12" method="post">
                    <div class="form-group">
                        <label for="BolgeAdi">Bölge Adı</label>
                        <input type="text" class="form-control" id="BolgeAdi" name="BolgeAdi" value="">
                    </div>
                    <div class="form-group">
                        <label for="Aciklama">Açıklama</label>
                        <textarea name="Aciklama" class="form-control dsb" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button data-type="svAdd" type="button" class="svToggle btn btn-default">Vazgeç</button>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="svDetail col-lg-12 col-md-12 col-sm-12 col-xs-12 subview">
    <div class="row">
        <div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Bölge Detayları <span class="pull-right"><button data-type="svDetail" type="button" class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>
            <hr/>
            <div class="row" id="getPartialView">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="generalInfo col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <h4>Genel Bilgiler</h4>
                        <hr/>
                        <div class="form-group">
                            <label for="BolgeAdi">Bölge Adı</label>
                            <input type="text" class="form-control dsb" id="BolgeAdi" name="BolgeAdi" value="Kayseri" disabled>
                        </div>
                        <div class="form-group">
                            <label for="Aciklama">Açıklama</label>
                            <textarea name="Aciklama" class="form-control dsb" rows="3" disabled="">Deneme</textarea>
                        </div>
                        <div class="form-group submit-group">
                            <button data-type="svDetail" type="button" class="btn btn-default vzg">Vazgeç</button>
                            <button type="submit" class="btn btn-success">Kaydet</button>
                        </div>
                        <div class="form-group edit-group">
                            <button id="editForm" type="button" class="btn btn-success">Düzenle</button>
                            <button id="deleteItem" type="button" class="btn btn-danger">Sil</button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h4>Kurumlar <button id="addNew" type="button" class="svToggle btn btn-success btn-sm pull-right addNewButton" data-type="svAdd" data-class="kurum"><i class="fa fa-plus-square"></i> Yeni Ekle</button> <button class="btn btn-success btn-sm pull-right seeAllButton">Tümünü Gör</button></h4>
                        <hr/>
                        <ul class="list-group">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Morbi leo risus</li>
                            <li class="list-group-item">Porta ac consectetur ac</li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- ./wrapper -->



