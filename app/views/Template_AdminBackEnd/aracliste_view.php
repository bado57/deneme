<script type="text/javascript">
    //$.adminFirmaIslem = function(args) {alert("hi");};
    
    var activeMenu = "menu_arac";
    var activeLink = "link_aracliste";
    
    $(window).on('load', function () {
        $.adminFirmaIslem();
    });

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side hiddenOnSv">
    <!-- Content Header (Page header) -->
    <div class="form-vertical">
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h1>
                            <i class="fa fa-bus"></i> Araç Listesi
                            <small>Araç İşlemleri</small>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
        <hr />
        <!-- Main content -->
        <section class="content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Plaka</th>
                            <th>Marka</th>
                            <th>Model Yılı</th>
                            <th>Kapasite</th>
                            <th>Araç KM</th>
                            <th>Sürücü</th>
                            <th>Açıklama</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-bus" style="color:red;"></i> 38 AS 265</td>
                            <td>Mercedes Sprinter</td>
                            <td>2012</td>
                            <td>18</td>
                            <td>36000</td>
                            <td>Hasan Aydın</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bus"  style="color:green;"></i> 38 SP 621</td>
                            <td>Mercedes Vito</td>
                            <td>2010</td>
                            <td>22</td>
                            <td>126000</td>
                            <td>Tahir Yüce</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bus" style="color:red;"></i> 38 AS 265</td>
                            <td>Mercedes Sprinter</td>
                            <td>2012</td>
                            <td>18</td>
                            <td>36000</td>
                            <td>Hasan Aydın</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Sil"> <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bus"  style="color:green;"></i> 38 SP 621</td>
                            <td>Mercedes Vito</td>
                            <td>2010</td>
                            <td>22</td>
                            <td>126000</td>
                            <td>Tahir Yüce</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bus" style="color:green;"></i> 38 AS 265</td>
                            <td>Mercedes Sprinter</td>
                            <td>2012</td>
                            <td>18</td>
                            <td>36000</td>
                            <td>Hasan Aydın</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bus"  style="color:green;"></i> 38 SP 621</td>
                            <td>Mercedes Vito</td>
                            <td>2010</td>
                            <td>22</td>
                            <td>126000</td>
                            <td>Tahir Yüce</td>
                            <td>Okul Servis Aracı</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Detaylar"> <i class="fa fa-search"></i> </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Düzenle"> <i class="fa fa-edit"></i> </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section><!-- /.content -->
    </div>
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

