<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminbildirimayarajaxquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_PLUGINADMIN_AjaxJs; ?>/adminbildirimayar-web.app.js" type="text/javascript"></script> 
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $data["FirmaAd"]; ?>
            <small><?php echo $data["KontrolPanel"]; ?></small>
        </h1>
    </section>
    <input id="degerler" style="display:none" value="<?php echo $model; ?>"/>
    <!-- Main content -->
    <section class="content">
        <!-- Kutular -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><input id="allCheck" type="checkbox" checked /> <?php echo $data["BildirimAlan"]; ?></th>
                    <th><?php echo $data["Kayıt"]; ?></th>
                    <th><?php echo $data["Duzenleme"]; ?></th>
                    <th><?php echo $data["Silme"]; ?></th>
                    <th><?php echo $data["Atama"]; ?></th>
                    </tr>
                    </thead>
                    <tbody id="bildirim">
                        <tr>
                            <td><input class="alanCheck" id="bolgeCheck" type="checkbox" checked /> <i class="fa fa-th"></i> <b>&nbsp;<?php echo $data["Bolgeler"]; ?></b></td>
                    <td><input data-islem="1" type="checkbox"  checked/></td>
                    <td><input data-islem="5" type="checkbox"  checked /></td>
                    <td><input data-islem="3" type="checkbox"  checked /></td>
                    <td><input data-islem="7" type="checkbox"  checked /></td>
                    </tr>

                    <tr>
                        <td><input class="alanCheck" id="kurumCheck" type="checkbox" checked /> <i class="fa fa-building-o"></i> <b>&nbsp;<?php echo $data["Kurumlar"]; ?></b></td>
                    <td><input data-islem="10" type="checkbox" checked /></td>
                    <td><input data-islem="50" type="checkbox" checked /></td>
                    <td><input data-islem="30" type="checkbox" checked /></td>
                    <td><input data-islem="70" type="checkbox" checked /></td>
                    </tr>
                    <tr>
                        <td><input class="alanCheck" id="aracCheck" type="checkbox" checked /> <i class="fa fa-bus"></i> <b>&nbsp;<?php echo $data["Araclar"]; ?></b></td>
                    <td><input data-islem="11" type="checkbox" checked /></td>
                    <td><input data-islem="51" type="checkbox" checked /></td>
                    <td><input data-islem="31" type="checkbox" checked /></td>
                    <td><input data-islem="71" type="checkbox" checked /></td>
                    </tr>
                    <tr>
                        <td><input class="alanCheck" id="turCheck" type="checkbox" checked /> <i class="fa fa-refresh"></i> <b>&nbsp;<?php echo $data["Turlar"]; ?></b></td>
                    <td><input data-islem="12" type="checkbox" checked /></td>
                    <td><input data-islem="52" type="checkbox" checked /></td>
                    <td><input data-islem="32" type="checkbox" checked /></td>
                    <td><input data-islem="72" type="checkbox" checked /></td>
                    </tr>
                    </tbody>
                </table>
                <button class="btn btn-success save" data-Saveislem="bildirimKaydet"><?php echo $data["Kaydet"]; ?></button>
            </div>
        </div><!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->