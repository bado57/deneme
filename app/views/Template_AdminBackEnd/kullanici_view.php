<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $data["FirmaAd"]; ?>
            <small><?php echo $data["KullaniciPanel"]; ?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Kutular -->
        <div class="row">
            <div class="col-lg-3 col-xs-12">
                <!-- Firma İşlemleri -->
                <a href="#" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            Admin
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
                <a href="#" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            Şoför
                        </h3>
                        <p>
                            <?php echo $model['AdminBolge']; ?> <?php echo $data["Toplam"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-th"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="#" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            Veli
                        </h3>
                        <p>
                            <?php echo $model['AdminKurum']; ?> <?php echo $data["Toplam"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building-o"></i>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-xs-12">
                <!-- Kullanıcı İşlemleri -->
                <a href="#" class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            Öğrenci
                        </h3>
                        <p>
                            650 <?php echo $data["Toplam"]; ?>
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
                            İşci
                        </h3>
                        <p>
                            <?php echo $model['AdminArac']; ?> <?php echo $data["Toplam"]; ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bus"></i>
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