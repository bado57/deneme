<section id="about-company" class="padding-top">
    <div class="container">
        <!--
        <div class="col-sm-12 text-center padding-bottom">
            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients.png" class="wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
        </div>
        -->
        <div class="col-sm-4 padding-bottom wow fadeInUp" data-wow-duration="500ms" data-wow-delay="400ms">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><?php echo $data["FirmaBilgi"]; ?></b></h3>
                </div>
                <div class="panel-body">
                    <p><i class="fa fa-briefcase"></i>&nbsp; Süper Tur</p>
                    <p><i class="fa fa-phone-square"></i> +90 352 65 25</p>
                    <p><i class="fa fa-home"></i> Mevlana Cad. Turgut Özal Bulv. Özata İşhanı No: 26/5 Melikgazi / Kayseri</p>
                    <hr>
                    <p><i class="fa fa-user"></i> Ahmet Yıldız</p>
                    <p><i class="fa fa-mobile-phone"></i>&nbsp; +90 505 65 25</p>
                    <p><i class="fa fa-envelope"></i> ahmet.yildiz@gmail.com</p>
                    <hr>
                    <a href="<?php echo SITE_URL; ?>/UserIndex/sign_up" id="calc" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> <?php echo $data["Degistir"]; ?></a>
                </div>
            </div>
        </div>
        <div class="col-sm-8 padding-bottom">
            <div class="row">
                <div class="col-sm-6 col-xs-6 text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="400ms">
                    <img class="" src="<?php echo SITE_USERFRONT_IMG; ?>/services/bus_count.png" alt=""/>
                    <h2><?php echo $data["AracSayi"]; ?></h2>
                    <h1 class="timer bold paymentCount" data-to="12" data-speed="1000" data-from="0"></h1>
                </div>
                <div class="col-sm-6 col-xs-6 text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="400ms">
                    <img class="" src="<?php echo SITE_USERFRONT_IMG; ?>/services/time_count.png" alt=""/>
                    <h2><?php echo $data["KullanimSure"]; ?></h2>
                    <h1 class="timer bold paymentCount" data-to="6" data-speed="1000" data-from="0"></h1>
                </div>
                <div class="col-sm-12 col-xs-12 text-center">
                    <hr>
                </div>
                <div class="col-sm-12 col-xs-12 text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="800ms">
                    <p style="margin-bottom: 0px;">10 TL <?php echo $data["AracAy"]; ?></p>
                    <h1 class="totalCost"><?php echo $data["AracAy"]; ?> <b><span class="timer bold wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1000ms" data-to="720" data-speed="2000" data-from="0"></span></b> TL</h1>
                </div>
                <div class="col-sm-12 col-xs-12 text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1200ms" style="margin-top: 20px;">
                    <a href="<?php echo SITE_URL; ?>/UserIndex/payment_result" class="btn btn-success btn-lg"><i class="fa fa-credit-card"></i> <?php echo $data["KrediKarti"]; ?></a>
                    <a href="<?php echo SITE_URL; ?>/UserIndex/payment_result" class="btn btn-success btn-lg"><i class="fa fa-paypal"></i> <?php echo $data["Paypal"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#about-company-->

