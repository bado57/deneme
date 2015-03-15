<script type="text/javascript">
    //$.adminFirmaIslem = function(args) {alert("hi");};

    var activeMenu = "menu_bolge";
    var activeLink = "link_bolgeliste";

    $(window).on('load', function () {
        addSubView("Yeni Bölge", "addBolge", "create");
    });

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h3>
                        <i class="fa fa-th"></i> <?php echo $data["Bolgeler"];?>
                        <small><?php echo $data["AdminKategoriBolgeIslem"];?></small>
                    </h3>
                </div>
                <?php if (Session::get("userRutbe") != 0) { ?>
                    <div class="col-md-6" style="text-align:right; padding-right:15px; padding-top:15px;">
                        <div class="form-group">
                            <button type="button" class="svToggle btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Yeni Bölge</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $data["BolgeAd"];?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeKurumSayi"];?></th>
                            <th class="hidden-xs"><?php echo $data["BolgeTurSayi"];?></th>
                            <th class="hidden-xs"><?php echo $data["TitleOgrenci"];?></th>
                            <th class="hidden-xs"><?php echo $data["TitleIsci"];?></th>
                            <th><?php echo $data["AdminFirmaİslemler"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php for($v=0; $v<count($model); $v++){ ?>
                        <tr>
                            <input id="adminBolgeRow" name="adminBolgeRow" type="hidden" value="<?php echo $model[$v]['AdminBolgeID'];?>" />
                            <td><?php echo $model[$v]['AdminBolge'];?></td>
                            <td class="hidden-xs"><?php echo $model[$v]['AdminKurum'];?></td>
                            <td class="hidden-xs"><?php echo $model[$v]['AdminArac'];?></td>
                            <td class="hidden-xs"><?php echo $model[$v]['AdminOgrenci'];?></td>
                            <td class="hidden-xs"><?php echo $model[$v]['AdminIsci'];?></td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo $data["Detay"];?>"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo $data["AdminFirmaDuzenle"];?>"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo $data["BolgeKurumSayi"];?>"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div><!-- ./wrapper -->



