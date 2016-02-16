<script src="<?php echo SITE_USERFRONT_JS; ?>/features.js"></script>
<section id="page-breadcrumb">
    <div class="vertical-center sun">
        <div class="container">
            <div class="row">
                <div class="action">
                    <div class="col-sm-12">
                        <h1 class="title"><?php echo $data["Ozellikler"]; ?></h1>
                        <p><?php echo $data["UretCozum"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#page-breadcrumb-->

<section id="services" style="padding-top: 30px;">
    <div class="container">
        <div class="row">
            <ul id="specTabs" class="nav nav-tabs">
                <li class="active"><a href="#admins" data-toggle="tab"><i class="fa fa-bus"></i> <?php echo $data["ServisFirma"]; ?></a></li>
                <li><a href="#parents" data-toggle="tab"><i class="fa fa-user"></i> <?php echo $data["OgrenciVeli"]; ?></a></li>
                <li><a href="#workers" data-toggle="tab"><i class="fa fa-briefcase"></i> <?php echo $data["Personel"]; ?></a></li>
            </ul>
            <div class="tab-content specTab">
                <div class="tab-pane fade active in" id="admins">
                    <div class="col-sm-6 col-xs-12">
                        <div id="adminCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/admin_specs.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/admin_screen1.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/admin_screen2.jpg" alt=""/>
                                </div>
                            </div>
                            <a class="left carousel-control hidden-xs" href="#adminCarousel" data-slide="prev">
                                <i class="fa fa-chevron-left" style="position: absolute; top:50%;"></i>
                            </a>
                            <a class="right carousel-control hidden-xs" href="#adminCarousel" data-slide="next">
                                <i class="fa fa-chevron-right" style="position: absolute; top:50%;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <h1><?php echo $data["KolayYonet"]; ?></h1>
                        <p><?php echo $data["ServisAgi"]; ?></p>
                        <p>
                            <?php echo $data["EtkiHarita"]; ?>
                        </p>

                        <p><?php echo $data["BunlarIcin"]; ?></p>

                    </div>
                    <div class="row">

                        <div class="specs col-sm-12">
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/areas.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["BolgeYonet"]; ?></h2>
                                    <p><?php echo $data["AgBolge"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/school.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["KurumYonet"]; ?></h2>
                                    <p><?php echo $data["HizmetVer"]; ?></p>
                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/users.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["KullaniciYonet"]; ?></h2>
                                    <p><?php echo $data["HizmetOgrenci"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/buses.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AracYonet"]; ?></h2>
                                    <p><?php echo $data["SahipArac"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/route.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["RotaPlan"]; ?></h2>
                                    <p><?php echo $data["EtkilesimliHarita"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/money.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["BakiyeTakip"]; ?></h2>
                                    <p><?php echo $data["OdemeDirekt"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/location.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AracTakip"]; ?></h2>
                                    <p><?php echo $data["AracHizmet"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/news.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["DuyuruIslem"]; ?></h2>
                                    <p><?php echo $data["DuyuruBildir"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/security.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["GuvenlikUyari"]; ?></h2>
                                    <p><?php echo $data["BelliSure"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/report.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["Raporlama"]; ?></h2>
                                    <p><?php echo $data["DetayliBilgi"]; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="parents">
                    <div class="col-sm-6 col-xs-12">
                        <div id="parentCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                            </div>
                            <a class="left carousel-control hidden-xs" href="#parentCarousel" data-slide="prev">
                                <i class="fa fa-chevron-left" style="position: absolute; top:50%;"></i>
                            </a>
                            <a class="right carousel-control hidden-xs" href="#parentCarousel" data-slide="next">
                                <i class="fa fa-chevron-right" style="position: absolute; top:50%;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <h1><?php echo $data["UcretsizKullanim"]; ?></h1>
                        <p><?php echo $data["OgrTakip"]; ?></p>
                        <p>
                            <?php echo $data["OgrVeli"]; ?>
                        </p>
                        <p>
                            <?php echo $data["BirdenFazla"]; ?>
                        </p>
                        <p><?php echo $data["DahaFazla"]; ?></p>

                    </div>

                    <div class="row">

                        <div class="vertical-center">
                            <div class="container">
                                <div class="row">
                                    <div class="action take-tour text-center" style="margin-top: 50px;">
                                        <div class="col-sm-12 col-xs-12 wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms" style="padding-bottom: 30px;">
                                            <p><?php echo $data["MobilIndir"]; ?></p>
                                            <br/>
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

                        <div class="specs col-sm-12">
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/user.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["ProfilBilgi"]; ?></h2>
                                    <p><?php echo $data["SizeUlasma"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/student.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["OgrBilgi"]; ?></h2>
                                    <p><?php echo $data["BinisInis"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/calendar.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["TakvimPlan"]; ?></h2>
                                    <p><?php echo $data["GidisGelis"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/notify.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["Bildirimler"]; ?></h2>
                                    <p><?php echo $data["AracEv"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/location.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AracTakip"]; ?></h2>
                                    <p><?php echo $data["AracSefer"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/money.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["BakiyeTakip"]; ?></h2>
                                    <p><?php echo $data["FirmaOdeme"]; ?></p>

                                </div>
                            </div>

                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/news.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["Duyurular"]; ?></h2>
                                    <p><?php echo $data["OnemliDurum"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/security.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["GuvenlikUyari"]; ?></h2>
                                    <p><?php echo $data["BelliSure"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/settings.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AyarRapor"]; ?></h2>
                                    <p><?php echo $data["UygulamaKendi"]; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="workers">
                    <div class="col-sm-6 col-xs-12">
                        <div id="workerCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                                <div class="item">
                                    <img class="img-responsive" src="<?php echo SITE_USERFRONT_IMG; ?>/services/shuttle_mobile_1.jpg" alt=""/>
                                </div>
                            </div>
                            <a class="left carousel-control hidden-xs" href="#workerCarousel" data-slide="prev">
                                <i class="fa fa-chevron-left" style="position: absolute; top:50%;"></i>
                            </a>
                            <a class="right carousel-control hidden-xs" href="#workerCarousel" data-slide="next">
                                <i class="fa fa-chevron-right" style="position: absolute; top:50%;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <h1><?php echo $data["UcretsizKullanim"]; ?></h1>
                        <p><?php echo $data["ArtikIsyeri"]; ?></p>
                        <p>
                            <?php echo $data["TumPersonel"]; ?>
                        </p>
                        <p><?php echo $data["ShuttleUye"]; ?></p>
                    </div>
                    <div class="row">
                        <div class="vertical-center">
                            <div class="container">
                                <div class="row">
                                    <div class="action take-tour text-center" style="margin-top: 50px;">
                                        <div class="col-sm-12 col-xs-12 wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms" style="padding-bottom: 30px;">
                                            <p><?php echo $data["MobilIndir"]; ?></p>
                                            <br/>
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
                        <div class="specs col-sm-12">
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/user.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["ProfilBilgi"]; ?></h2>
                                    <p><?php echo $data["SizeUlasma"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/calendar.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["TakvimPlan"]; ?></h2>
                                    <p><?php echo $data["GidisGelis"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/notify.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["Bildirimler"]; ?></h2>
                                    <p><?php echo $data["AracBinis"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/location.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AracTakip"]; ?></h2>
                                    <p><?php echo $data["AracSefer"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/money.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["BakiyeTakip"]; ?></h2>
                                    <p><?php echo $data["FirmaOdeme"]; ?></p>

                                </div>
                            </div>

                            <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/news.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["Duyurular"]; ?></h2>
                                    <p><?php echo $data["OnemliDurum"]; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                                <div class="single-service">
                                    <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                                        <img src="<?php echo SITE_USERFRONT_IMG; ?>/services/settings.png" alt=""/>
                                    </div>
                                    <h2><?php echo $data["AyarRapor"]; ?></h2>
                                    <p><?php echo $data["UygulamaKendi"]; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<!--/#services-->

