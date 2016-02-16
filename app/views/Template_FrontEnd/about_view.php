<section id="page-breadcrumb">
    <div class="vertical-center sun">
        <div class="container">
            <div class="row">
                <div class="action">
                    <div class="col-sm-12">
                        <h1 class="title"><?php echo $data["Hakkinda"]; ?></h1>
                        <p><?php echo $data["ProjeHakkinda"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#page-breadcrumb-->

<section id="about-company" class="padding-top wow fadeInUp" data-wow-duration="400ms" data-wow-delay="400ms">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <!--<img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/aboutus_logo.png" class="margin-bottom" alt=""/>-->
                <h1 class="margin-bottom"><?php echo $data["Nedir"]; ?></h1>
                <p>
                    <?php echo $data["ShuttleAbout"]; ?>
                </p>
            </div>
        </div>
    </div>
</section>
<!--/#about-company-->

<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="single-service">
                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                        <img width="300" src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/bilimsanayi_logo.png" alt=""/>
                    </div>
                    <h2><?php echo $data["TeknoGirisim"]; ?></h2>
                    <p><?php echo $data["TCBSTB"]; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#services-->

<section id="action">
    <div class="vertical-center">
        <div class="container">
            <div class="row">
                <div class="action count">
                    <div class="col-sm-3 text-center wow bounceIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h1 class="timer bold" data-to="7" data-speed="3000" data-from="0"></h1>   
                        <h3><?php echo $data["SektorTecrube"]; ?></h3>
                    </div>
                    <div class="col-sm-3 text-center wow bounceIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h1 class="timer bold" data-to="547" data-speed="3000" data-from="0"></h1>   
                        <h3><?php echo $data["GunlukCalisma"]; ?></h3> 
                    </div>
                    <div class="col-sm-3 text-center wow bounceIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h1 class="timer bold" data-to="1328" data-speed="3000" data-from="0"></h1> 
                        <h3><?php echo $data["BardakKahve"]; ?></h3>
                    </div>
                    <div class="col-sm-3 text-center wow bounceIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h1 class="timer bold" data-to="1260000" data-speed="3000" data-from="0"></h1> 
                        <h3><?php echo $data["SatirKod"]; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#action-->

<section id="team">
    <div class="container">
        <div class="row">
            <h1 class="title text-center wow fadeInDown" data-wow-duration="500ms" data-wow-delay="300ms"><?php echo $data["Ekibimiz"]; ?></h1>
            <p class="text-center wow fadeInDown" data-wow-duration="400ms" data-wow-delay="400ms"><?php echo $data["DahaIyiOlmak"]; ?></p>
            <div id="team-carousel" class="carousel slide wow fadeIn" data-ride="carousel" data-wow-duration="400ms" data-wow-delay="400ms">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active personel">
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/bayram.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Bayram Altınışık</h2>
                                    <p><?php echo $data["IsciBado"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/selman.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Selman KILINÇ</h2>
                                    <p><?php echo $data["IsciSelman"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/savas.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Savaş Çiftci</h2>
                                    <p><?php echo $data["IsciSavas"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/alican.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Alican Bozkurt</h2>
                                    <p><?php echo $data["IsciAlican"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/yusuf.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Yusuf Taşdelen</h2>
                                    <p><?php echo $data["IsciYusuf"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="team-single-wrapper">
                                <div class="team-single">
                                    <div class="person-thumb">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/aboutus/aytac.jpg" class="img-responsive" alt=""/>
                                    </div>
                                    <div class="social-profile">
                                        <ul class="nav nav-pills">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="person-info">
                                    <h2>Aytaç Salman</h2>
                                    <p><?php echo $data["IsciAytac"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#team-->
