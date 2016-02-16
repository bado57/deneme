<link href="<?php echo SITE_USERFRONT_CSS; ?>/timeline.css" rel="stylesheet"/>
<section id="page-breadcrumb">
    <div class="vertical-center sun">
        <div class="container">
            <div class="row">
                <div class="action">
                    <div class="col-sm-12">
                        <h1 class="title"><?php echo $data["NasilCalisir"]; ?></h1>
                        <p><?php echo $data["İsleyis"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#page-breadcrumb-->

<section id="about-company" class="padding-top padding-bottom" >
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center wow fadeInUp" data-wow-duration="400ms" data-wow-delay="400ms">
                <ul class="timeline">
                    <li>
                        <div class="timeline-badge success"><i class="fa fa-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["IlkKayit"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="tbuses" class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="400ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/tbus.png" alt=""/>
                                    <img id="tcalendar"  class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="800ms" src="<?php echo SITE_USERFRONT_IMG; ?>/services/tcal.png" alt=""/>
                                    <img id="ttick"  class="wow fadeIn" data-wow-duration="400ms" data-wow-delay="1200ms" src="<?php echo SITE_USERFRONT_IMG; ?>/services/tick.png" alt=""/>
                                </div>
                                <p><?php echo $data["SistemeKayit"]; ?></p>
                                <p><?php echo $data["OdemeIslem"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-badge success"><i class="fa fa-upload"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["VeriGiris"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="tdata" class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/data.png" alt=""/>
                                </div>
                                <p><?php echo $data["KayitTamam"]; ?></p>
                                <div class="timelineImages">
                                    <img id="tbuses" class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/login.png" alt=""/>
                                </div>
                                <p><?php echo $data["SistemOto"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-badge success"><i class="fa fa-map-marker"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["DurakBelirle"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages mapBg">
                                    <img id="thand" class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/phonehand.png" alt=""/>
                                    <img id="tmarker" class="wow fadeIn" data-wow-duration="400ms" data-wow-delay="1200ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/map_marker.png" alt=""/>
                                </div>
                                <div style='padding:10px 0px;'></div>
                                <p><?php echo $data["KayitKullanici"]; ?></p>
                                <p><?php echo $data["AyniZaman"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-badge success"><i class="fa fa-road"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["RotaPlan"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="tmaproute" class="wow fadeIn img-responsive" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/maproute.png" alt=""/>
                                </div>
                                <p><?php echo $data["BinisInis"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-badge success"><i class="fa fa-bus"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["ServisHizmet"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="tnavigation" class="wow fadeIn img-responsive" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/navigation2.png" alt=""/>
                                </div>
                                <div style='padding:10px 0px;'></div>
                                <p><?php echo $data["AracSurucu"]; ?></p>
                                <p><?php echo $data["AracYolcu"]; ?></p>
                                <p><?php echo $data["TumHizmet"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-badge success"><i class="fa fa-envelope"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["Haberlesme"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="tconnection" class="wow fadeIn img-responsive" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/connection.png" alt=""/>
                                </div>
                                <p><?php echo $data["ServisSurucu"]; ?></p>
                                <p><?php echo $data["ShuttleSms"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-badge success"><i class="fa fa-shield"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["Guvenlik"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages mapWrongBg">
                                    <img id="twarning" class="wow fadeIn" data-wow-duration="400ms" data-wow-delay="1200ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/phonewarning.png" alt=""/>
                                </div>
                                <div style='padding:10px 0px;'></div>
                                <p><?php echo $data["OzellikleKucuk"]; ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-badge success"><i class="fa fa-line-chart"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h2 class="timeline-title"><?php echo $data["Raporlama"]; ?></h2>
                            </div>
                            <div class="timeline-body">
                                <div class="timelineImages">
                                    <img id="treport" class="wow fadeIn img-responsive" data-wow-duration="400ms" data-wow-delay="600ms"  src="<?php echo SITE_USERFRONT_IMG; ?>/services/graphic.png" alt=""/>
                                </div>
                                <p><?php echo $data["TumKayit"]; ?></p>
                                <p><?php echo $data["BorcOdeme"]; ?></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--/#about-company-->

