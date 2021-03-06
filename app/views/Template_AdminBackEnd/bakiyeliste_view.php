<script type="text/javascript">
    var activeMenu = "menu_bakiye";
    var activeLink = "link_bakiye";
</script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminkullanici-web.app.js" type="text/javascript"></script> 
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $data["FirmaAd"]; ?>
            <small><?php echo $data["BakiKullaniciPanel"]; ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- Kutular -->
        <div class="row">

            <div class="col-lg-4 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/bakiyeogrenciliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["Ogrenci"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['OgrenciCount']) > 0) { ?>
                                <?php
                                echo $model['OgrenciCount'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-xs-12">
                <!-- İşçi İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/bakiyeisciliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["Isci"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['IsciCount']) > 0) { ?>
                                <?php
                                echo $model['IsciCount'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                </a>
            </div>                      
            <!-- top row -->
            <div class="row">
                <div class="col-xs-12 connectedSortable">

                </div><!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable"> 


                </section><!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">



                </section><!-- right col -->
            </div><!-- /.row (main row) -->

    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->