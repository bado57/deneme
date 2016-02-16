<style type="text/css">
    #header{display: none !important;}
    #about-company{padding-top: 200px;}
</style>
<section id="about-company" class="padding-top">
    <div class="container">
        <!-- 404 -->
        <div class="col-sm-12 text-center padding-bottom">
            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/404.png" class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
            <h1 class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="600ms" style="font-size: 60px; font-weight: 300; color: #009933; "><?php echo $data["404"]; ?></h1>
            <h2 class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="700ms"><?php echo $data["HataGeldi"]; ?></h2>
            <p class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="800ms" style="margin-bottom: 30px;"><?php echo $data["UlasSayfa"]; ?></p>
            <a href="<?php echo SITE_URL; ?>" class="btn btn-success btn-lg wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1000ms"><i class="fa fa-home"></i> <?php echo $data["AnasayfaDon"]; ?></a>
        </div>
    </div>
</section>

