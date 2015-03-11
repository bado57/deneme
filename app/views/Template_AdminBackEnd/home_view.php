<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        SHUTTLE
                        <small><?php echo $data["AdminKategoriKontrolPanel"];?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $data["AdminKategoriAnasayfa"];?></a></li>
                        <li class="active"><?php echo $data["AdminKategoriYonetimPanel"];?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Kutular -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-12">
                            <!-- Firma İşlemleri -->
                            <a href="<?php echo SITE_URL; ?>/adminweb/firmislem" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $data["AdminKategoriFirmaIslem"];?>
                                    </h3>
                                    <p>
                                        1  <?php echo $data["Toplam"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-building"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Kullanıcı İşlemleri -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $data["AdminKategoriKullaniciIslem"];?>
                                    </h3>
                                    <p>
                                        650 <?php echo $data["Toplam"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-xs-12">
                            <!-- Araç İşlemleri -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                       <?php echo $data["AdminKategoriAracIslem"];?>
                                    </h3>
                                    <p>
                                        35 <?php echo $data["Toplam"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bus"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Tur İşlemleri -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                      <?php echo $data["AdminKategoriTurIslem"];?>
                                    </h3>
                                    <p>
                                        48 <?php echo $data["Toplam"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Bakiye İşlemleri -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $data["AdminKategoriBakiyeIslem"];?>
                                    </h3>
                                    <p>
                                        365 TL  <?php echo $data["Odenmemis"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Lokasyon Sorgusu -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                       <?php echo $data["AdminKategoriLokasyonSorgu"];?>
                                    </h3>
                                    <p>
                                        2  <?php echo $data["AktifServis"];?>
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
                                        <?php echo $data["AdminKategoriMesaj"];?>
                                    </h3>
                                    <p>
                                        4 <?php echo $data["Okunmamis"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Duyurular -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $data["AdminKategoriDuyuru"];?>
                                    </h3>
                                    <p>
                                        5 <?php echo $data["YeniDuyuru"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bullhorn"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Raporlar -->
                            <a href="#" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $data["AdminKategoriRapor"];?>
                                    </h3>
                                    <p>
                                        5 <?php echo $data["YeniRapor"];?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <!-- Çıkış -->
                            <a href="<?php echo SITE_URL_LOGINN; ?>/logout" class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                         <?php echo $data["AdminCikisYap"];?>
                                    </h3>
                                    <p>
                                         <?php echo $data["GuvenliCikis"];?>
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