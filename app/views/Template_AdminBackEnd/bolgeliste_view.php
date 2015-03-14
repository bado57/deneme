<script type="text/javascript">
    //$.adminFirmaIslem = function(args) {alert("hi");};

    var activeMenu = "menu_bolge";
    var activeLink = "link_bolgeliste";

    $(window).on('load', function () {
        addSubView("Yeni Bölge", "addBolge", "create");
    });

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h3>
                        <i class="fa fa-th"></i> Bölgeler
                        <small>Bölge İşlemleri</small>
                    </h3>
                </div>
                <?php if (Session::get("userRutbe") != 0) { ?>
                    <div class="col-md-6" style="text-align:right; padding-right:15px; padding-top:15px;">
                        <div class="form-group">
                            <button type="button" class="svToggle btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Yeni Bölge</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Bölge Adı</th>
                            <th class="hidden-xs">Kurum Sayısı</th>
                            <th class="hidden-xs">Tur Sayısı</th>
                            <th class="hidden-xs">Müşteri / Yolcu Sayısı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kayseri</td>
                            <td class="hidden-xs">35</td>
                            <td class="hidden-xs">72</td>
                            <td class="hidden-xs">324</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Kayseri</td>
                            <td>35</td>
                            <td>72</td>
                            <td>324</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Kayseri</td>
                            <td>35</td>
                            <td>72</td>
                            <td>324</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Kayseri</td>
                            <td>35</td>
                            <td>72</td>
                            <td>324</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                    </tbody>
                </table>
                
                
            </div>
        </div>
    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div><!-- ./wrapper -->



