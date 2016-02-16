<section id="about-company" class="padding-top">
    <div class="container">
        <!-- Başarılı Ödeme -->
        <div class="col-sm-12 text-center padding-bottom">
            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients.png" class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
            <h1 class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="600ms"><?php echo $data["Tebrikler"]; ?></h1>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="700ms"><?php echo $data["OdemeGercek"]; ?></p>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="800ms"><?php echo $data["SistemeGiris"]; ?> <br><a href="#"><b><?php echo $data["Buradan"]; ?></b></a> <?php echo $data["BilgiYonet"]; ?></p>
            <a href="<?php echo SITE_URL; ?>/UserIndex/log_in" class="btn btn-success btn-lg wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1000ms"><i class="fa fa-sign-in"></i> <?php echo $data["GirisYap"]; ?></a>
        </div>
        <!-- Başarısız Ödeme -->
        <div class="col-sm-12 text-center padding-bottom">
            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients2.png" class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
            <h1 class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="600ms"><?php echo $data["Uzgunuz"]; ?></h1>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="700ms"><?php echo $data["HataOlustu"]; ?></p>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="800ms"><?php echo $data["HataMesaj"]; ?></p>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="900ms"><b>"Yetersiz Bakiye"</b> Hata Kodu: 125698.</p>
            <a href="<?php echo SITE_URL; ?>/UserIndex/payment" class="btn btn-success btn-lg wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1000ms"><i class="fa fa-chevron-left"></i> <?php echo $data["TekrarDene"]; ?></a>
        </div>
    </div>
</section>
<!--/#about-company-->

