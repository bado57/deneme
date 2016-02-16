<script type="text/javascript">
    var activeMenu = "menu_home";
</script>
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $data["FirmaAd"]; ?>
            <small><?php echo $data["KontrolPanel"]; ?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Kutular -->
        <div class="row">
            <div class="col-lg-3 col-xs-12">
                <!-- Firma İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/firmislem" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["FirmaIslem"]; ?>
                        </h3>
                        <p>
                            1  <?php echo $data["Toplam"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/bolgeliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["BolgeIslem"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminBolge']) > 0) { ?>
                                <?php
                                echo $model['AdminBolge'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-th"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/kurumliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["KurumIslem"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminKurum']) > 0) { ?>
                                <?php
                                echo $model['AdminKurum'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building-o"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/kullaniciListe" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["KullaniciIslem"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminKullanici']) > 0) { ?>
                                <?php
                                echo $model['AdminKullanici'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Araç İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/aracliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["AracIslem"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminArac']) > 0) { ?>
                                <?php
                                echo $model['AdminArac'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bus"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Tur İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/turliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["TurIslem"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminTur']) > 0) { ?>
                                <?php
                                echo $model['AdminTur'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-refresh"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Bakiye İşlemleri -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/bakiyeliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["BakiyeIslem"]; ?>
                        </h3>
                        <p>
                            <?php echo $model['AdminParaTotal'] . ' ' . $data["ToplamOdeme"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Lokasyon Sorgusu -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/lokasyonliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["LokasyonSorgu"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminLokasyon']) > 0) { ?>
                                <?php
                                echo $model['AdminLokasyon'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Mesajlar -->
                <a href="#" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["HesapIslem"]; ?>
                        </h3>
                        <p>
                            365 TL  <?php echo $data["Odenmemis"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Duyurular -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/duyuruliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["Duyuru"]; ?>
                        </h3>
                        <p>
                            <?php if (count($model['AdminDuyuru']) > 0) { ?>
                                <?php
                                echo $model['AdminDuyuru'] . ' ' . $data["Toplam"];
                            } else {
                                ?>
                                <?php
                                echo '0 ' . $data["Toplam"];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bullhorn"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Raporlar -->
                <a href="<?php echo SITE_URL; ?>/AdminWeb/raporliste" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["Rapor"]; ?>
                        </h3>
                        <p>
                            6 <?php echo $data["YeniRapor"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Çıkış -->
                <a href="<?php echo SITE_URL_LOGOUT; ?>" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $data["CikisYap"]; ?>
                        </h3>
                        <p>
                            <?php echo $data["GuvenliCikis"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-arrow-circle-right"></i>
                    </div>
                </a>
            </div>

        </div><!-- /.row -->

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