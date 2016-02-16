<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center bottom-separator">
                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/under.png" class="img-responsive inline" alt=""/>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="testimonial bottom">
                    <h2><?php echo $data["KullanmaBasla"]; ?></h2>
                    <div class="media">
                        <a href="<?php echo SITE_URL; ?>/UserIndex/sign_up" class="footer_signup btn-mobile" style="margin-right:10px;">
                            <?php echo $data["KayitOl"]; ?>
                        </a>
                    </div> 
                </div> 
                <div class="testimonial bottom">
                    <h2><?php echo $data["MobilUygulama"]; ?></h2>
                    <div class="media">
                        <a href="#" class="btn-mobile" style="margin-right:10px;">
                            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/android.png" alt="<?php echo $data["GPlay"]; ?>"/>
                        </a>
                    </div>
                    <div class="media">
                        <a href="#" class="btn-mobile">
                            <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/apple.png" alt="<?php echo $data["AppStore"]; ?>" />
                        </a>
                    </div>   
                </div> 
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="contact-info bottom">
                    <h2><?php echo $data["Iletisim"]; ?></h2>
                    <address>
                        <?php echo $data["E_mail"]; ?>: <a href="mailto:someone@example.com">email@email.com</a> <br> 
                        <?php echo $data["Telefon"]; ?>: +1 (123) 456 7890 <br> 
                        <?php echo $data["Fax"]; ?>: +1 (123) 456 7891 <br> 
                    </address>

                    <h2><?php echo $data["Adres"]; ?></h2>
                    <address>
                        Unit C2, St.Vincent's Trading Est., <br> 
                        Feeder Road, <br> 
                        Bristol, BS2 0UY <br> 
                        United Kingdom <br> 
                    </address>
                    <p style="margin-bottom: 5px;">&copy; <?php echo $data["TumHaklar"]; ?></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="contact-form bottom">
                    <h2><?php echo $data["BizeUlasin"]; ?></h2>
                    <form id="main-contact-form" name="contact-form">
                        <div class="form-group">
                            <input type="text" name="name" id="iletname" class="form-control" placeholder="<?php echo $data["AdSoyad"]; ?>"/>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="iletemail" class="form-control" placeholder="<?php echo $data["Email"]; ?>"/>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="iletmessage" class="form-control" rows="8" style="resize: none" placeholder="<?php echo $data["Mesajiniz"]; ?>"></textarea>
                        </div>                        
                        <div class="form-group">
                            <input type="button" id="iletsubmit" name="submit" class="btn btn-submit" value="<?php echo $data["Gonder"]; ?>"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12" style="margin-top: 30px;">
                <div class="copyright-text text-center" style="padding-top: 15px;">

                    <p style="margin-bottom: -8px;"><a href="#"><?php echo $data["HizmetSart"]; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/#footer-->
</body>

</html>