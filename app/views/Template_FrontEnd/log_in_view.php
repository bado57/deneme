<script src="<?php echo SITE_USERFRONT_JS; ?>/userslogin.js"></script>
<section id="about-company" class="padding-top">
    <div class="container">
        <div class="row">
            <!--
            <div class="col-sm-12 text-center padding-bottom">
                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients.png" class="wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
            </div>
            -->
            <div class="col-sm-12 padding-bottom wow fadeInUp" data-wow-duration="500ms" data-wow-delay="400ms" style="padding-bottom: 100px;">
                <input type="hidden" id="sonucDeger" value="<?php echo $model[0]["Result"]; ?>" />
                <form role="form" action="<?php echo SITE_URL; ?>/UsersLogin" method="POST"  id="loginForm"> 
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4 col-xs-12">
                            <div class="form-group">
                                <label for="username" name="usersloginkadi" class="control-label text-left"><?php echo $data["Kadi"]; ?></label>
                                <input type="text" id="username" name="usersloginkadi" class="form-control"  placeholder="<?php echo $data["Kadi"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label text-left"><?php echo $data["Sifre"]; ?></label>
                                <input type="password" id="password" name="usersloginsifre" class="form-control"  placeholder="<?php echo $data["Sifre"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" id="loginFrom" class="btn btn-submit" value="<?php echo $data["Giris"]; ?>"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--/#about-company-->

