<section id="page-breadcrumb">
    <div class="vertical-center sun">
        <div class="container">
            <div class="row">
                <div class="action">
                    <div class="col-sm-12">
                        <h1 class="title"><?php echo $data["KayitOl"]; ?></h1>
                        <p><?php echo $data["EnPrestij"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#page-breadcrumb-->

<section id="about-company" class="padding-top">
    <div class="container">
        <div class="row">
            <!--
            <div class="col-sm-12 text-center padding-bottom">
                <img src="<?php echo SITE_USERFRONT_IMG; ?>/home/clients.png" class="wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms" alt=""/>
            </div>
            -->
            <div class="col-sm-12 padding-bottom wow fadeInUp" data-wow-duration="500ms" data-wow-delay="400ms">
                <form id="sign-up-form" name="contact-form" method="post" action="sendemail.php">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="name" class="control-label text-left"><?php echo $data["FirmaAd"]; ?></label>
                                <input type="text" id="name" name="name" class="form-control" required="required" placeholder="<?php echo $data["AdSoyad"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="control-label text-left"><?php echo $data["FirmaTel"]; ?></label>
                                <input type="text" id="phone" name="phone" class="form-control" required="required" placeholder="<?php echo $data["FirmaTel"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="adress" class="control-label text-left"><?php echo $data["FirmaAdres"]; ?></label>
                                <textarea name="message" id="adress" name="adress" required="required" class="form-control" rows="6" placeholder="<?php echo $data["FirmaAdres"]; ?>" style="resize:none"></textarea>
                            </div> 
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="adminname" class="control-label text-left"><?php echo $data["YetkiliAd"]; ?></label>
                                <input type="text" id="adminname" name="adminname" class="form-control" required="required" placeholder="<?php echo $data["YetkiliAd"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="gsm" class="control-label text-left"><?php echo $data["YetkiliTel"]; ?></label>
                                <input type="text" id="gsm" name="gsm" class="form-control" required="required" placeholder="<?php echo $data["YetkiliTel"]; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label text-left"><?php echo $data["Email"]; ?></label>
                                <input type="email" id="email" name="email" class="form-control" required="required" placeholder="<?php echo $data["Email"]; ?>"/>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="bus" class="control-label text-left" data-toggle="tooltip" data-placement="top" title="<?php echo $data["EkUcret"]; ?>"><?php echo $data["AracSayi"]; ?> <i class="fa fa-info-circle"></i></label>
                                        <div class="input-group">
                                            <span class="input-group-addon ipa" id="bus-addon"><i class="fa fa-bus"></i></span>
                                            <input type="number" class="form-control" placeholder="<?php echo $data["AracSayi"]; ?>" min="1" required="required" aria-describedby="bus-addon"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="time" class="control-label text-left" data-toggle="tooltip" data-placement="top" title="<?php echo $data["HizmetSure"]; ?>"><?php echo $data["KullanimSure"]; ?> <i class="fa fa-info-circle"></i></label>
                                        <div class="input-group">
                                            <span class="input-group-addon ipa" id="time-addon"><i class="fa fa-calendar"></i></span>
                                            <select id="time" class="form-control" aria-describedby="time-addon" required="required">
                                                <option><?php echo $data["Seciniz"]; ?></option>
                                                <option value="1">1 <?php echo $data["Ay"]; ?></option>
                                                <option value="3">3 <?php echo $data["Ay"]; ?></option>
                                                <option value="6">6 <?php echo $data["Ay"]; ?></option>
                                                <option value="9">9 <?php echo $data["Ay"]; ?></option>
                                                <option value="12">1 <?php echo $data["Yil"]; ?></option>
                                                <option value="48">2 <?php echo $data["Yil"]; ?></option>
                                                <option value="36">3 <?php echo $data["Yil"]; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" style="padding-top: 10px;">
                                <p><input type="checkbox" id="contractCheck" class="icheckbox_square-green"/> <a role="button" data-toggle="modal" data-target="#contractModal"><b><?php echo $data["HizmetSoz"]; ?></b></a><?php echo $data["KabulEt"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group text-center">
                        <a href="#<?php //echo SITE_URL;/UserIndex/payment ?>" id="gosign_up" class="btn btn-success btn-lg col-xs-12"><i class="fa fa-chevron-right"></i> <?php echo $data["DevamEt"]; ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--/#about-company-->

<!-- Sözleşme Modal -->
<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="<?php echo $data["HizmetSoz"]; ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b><?php echo $data["HizmetSoz"]; ?></b></h4>
            </div>
            <div class="modal-body">
                <h4><b><?php echo $data["HSozlesme"]; ?></b></h4> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <hr>
                <h4><b><?php echo $data["KullanimKosul"]; ?></b></h4> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p> <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $data["Kapat"]; ?></button>
            </div>
        </div>
    </div>
</div>