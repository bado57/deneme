<section id="home-slider">
    <div class="container">
        <div class="main-slider">
            <div class="slide-text">
                <h1><?php echo $data["ServisTasimacilik"]; ?><br/><?php echo $data["YeniDonem"]; ?></h1>
                <p><?php echo $data["KolayYonetim"]; ?></p>
                <a href="<?php echo SITE_URL; ?>/UserIndex/features" class="btn btn-common"><b><i class="fa fa-angle-right"></i> <?php echo $data["Detaylar"]; ?></b></a>
            </div>
            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/slider/slide1/house.png" class="img-responsive slider-house" alt="slider image" width="650px"/>
        </div>
    </div>
    <div class="preloader"><i class="fa fa-sun-o fa-spin"></i></div>
</section>
<!--/#home-slider-->

<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="single-service">
                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/icon1.png" alt="<?php echo $data["AltFirma"]; ?>"/>
                    </div>
                    <h2><?php echo $data["SFirma"]; ?></h2>
                    <p><?php echo $data["SAgiYonet"]; ?></p>
                    <a href="<?php echo SITE_URL; ?>/UserIndex/features" class="btn btn-default"><?php echo $data["Detaylar"]; ?></a>
                </div>
            </div>
            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                <div class="single-service">
                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/icon2.png" alt="<?php echo $data["AltOgrenciVeli"]; ?>"/>
                    </div>
                    <h2><?php echo $data["OgrveVeliler"]; ?></h2>
                    <p><?php echo $data["SAracZaman"]; ?></p>
                    <a href="<?php echo SITE_URL; ?>/UserIndex/features#parents" class="btn btn-default"><?php echo $data["Detaylar"]; ?></a>
                </div>
            </div>
            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                <div class="single-service">
                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/icon3.png" alt="Personel Icon"/>
                    </div>
                    <h2><?php echo $data["Personeller"]; ?></h2>
                    <p><?php echo $data["SKullanmaZaman"]; ?></p>
                    <a href="<?php echo SITE_URL; ?>/UserIndex/features#workers" class="btn btn-default"><?php echo $data["Detaylar"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#services-->

<section id="action" class="responsive">
    <div class="vertical-center">
        <div class="container">
            <div class="row">
                <div class="action take-tour">
                    <div class="col-sm-6 col-xs-12 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                        <h1 class="title"><?php echo $data["MobilUygulama"]; ?></h1>
                        <p><?php echo $data["KullaniciMobCzum"]; ?></p>
                    </div>
                    <div class="col-sm-6 col-xs-12 text-center wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                        <div class="hidden-xs text-right">
                            <a href="#" class="btn-mobile" style="margin-right:10px;">
                                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/android.png" alt="<?php echo $data["GPlay"]; ?>"/>
                            </a>
                            <a href="#" class="btn-mobile">
                                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/apple.png" alt="<?php echo $data["AppStore"]; ?>" />
                            </a>
                        </div>
                        <div class="text-center padding-top hidden-lg hidden-md hidden-sm">
                            <a href="#" class="btn-mobile" style="margin-right:10px;">
                                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/android.png" alt="<?php echo $data["GPlay"]; ?>"/>
                            </a>
                            <a href="#" class="btn-mobile">
                                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/apple.png" alt="<?php echo $data["AppStore"]; ?>" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#action-->

<section id="features">
    <div class="container">
        <div class="row">
            <div class="single-features">
                <div class="col-sm-5 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                    <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/allusers.png" class="img-responsive" alt="<?php echo $data["SolutionsUsers"]; ?>"/>
                </div>
                <div class="col-sm-6 wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                    <h2><?php echo $data["KullaniciCozum"]; ?></h2>
                    <p><?php echo $data["ServisSureci"]; ?></p>

                </div>
            </div>
            <div class="single-features">
                <div class="col-sm-6 align-right wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                    <h2><?php echo $data["SifirMaliyet"]; ?></h2>
                    <p><?php echo $data["ServisTakip"]; ?></p>
                </div>
                <div class="col-sm-5 col-sm-offset-1 align-right wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                    <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/nomoredevices.png" class="img-responsive" alt="<?php echo $data["AltEkipGerekmez"]; ?>"/>
                </div>
            </div>
            <div class="single-features">
                <div class="col-sm-5 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                    <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/notifications.png" class="img-responsive" alt=""/>
                </div>
                <div class="col-sm-6 wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                    <h2><?php echo $data["OzelBildirim"]; ?></h2>
                    <p><?php echo $data["OgrServisDurum"]; ?></p>
                </div>
            </div>
            <div class="single-features">
                <div class="col-sm-6 align-right wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                    <h2><?php echo $data["DusukMaliyet"]; ?></h2>
                    <p><?php echo $data["GelecekYolcu"]; ?></p>
                </div>
                <div class="col-sm-5 col-sm-offset-1 align-right wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                    <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/lessfuel.png" class="img-responsive" alt=""/>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#features-->

<section id="clients">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="clients text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
                    <p><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients.png" class="img-responsive" alt=""/></p>
                    <h1 class="title">Mutlu Kullanıcılar</h1>
                    <!--
                    <p>Servis ağı çözümlerinde bizi tercih eden değerli müşterilerimizden bazıları.</p>
                    -->
                </div>
                <!-- 
                <div class="clients-logo wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                    <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                     <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                     <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                     <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                     <div class="col-xs-3 col-sm-2">
                        <a href="#"><img src="<?php echo SITE_USERFRONT_IMG; ?>/home/client1.png" class="img-responsive" alt=""/></a>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
</section>
<!--/#clients-->