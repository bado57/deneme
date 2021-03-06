<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas hiddenOnSv">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo SITE_PLUGINADMIN_IMG; ?>/avatar3.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php echo $data["Merhaba"]; ?>,</p>
                    <p><?php echo Session::get("kullaniciad"); ?>&nbsp;<?php echo Session::get("kullanicisoyad"); ?></p>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active"  id="menu_home" id="menu_home">
                    <a href="<?php echo SITE_URL; ?>/Panel">
                        <i class="fa fa-home"></i> <span><?php echo $data["Anasayfa"]; ?></span>
                    </a>
                </li>
                <li id="menu_firma">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/firmislem">
                        <i class="fa fa-building"></i>
                        <span><?php echo $data["FirmaIslem"]; ?></span>
                    </a>
                </li>

                <li id="menu_bolge">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/bolgeliste">
                        <i class="fa fa-th"></i>
                        <span><?php echo $data["BolgeIslem"]; ?></span>
                    </a>
                </li>
                <li id="menu_kurum">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/kurumliste">
                        <i class="fa fa-building-o"></i>
                        <span><?php echo $data["Kurumlar"]; ?></span>
                    </a>    
                </li>

                <li id="menu_arac">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/aracliste">
                        <i class="fa fa-bus"></i>
                        <span><?php echo $data["AracIslem"]; ?></span>
                    </a>
                </li>
                <li class="treeview" id="menu_kullanici">
                    <a href="#">
                        <i class="fa fa-users"></i> <span><?php echo $data["KullaniciIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_adminliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/adminliste"><i class="fa fa-angle-right"></i><?php echo $data["Admin"]; ?></a></li>
                        <li id="link_soforliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/soforliste"><i class="fa fa-angle-right"></i><?php echo $data["Sofor"]; ?></a></li>
                        <li id="link_hostesliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/hostesliste"><i class="fa fa-angle-right"></i><?php echo $data["Hostes"]; ?></a></li>
                        <li id="link_veliliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/veliliste"><i class="fa fa-angle-right"></i><?php echo $data["Veli"]; ?></a></li>
                        <li id="link_ogrenciliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/ogrenciliste"><i class="fa fa-angle-right"></i><?php echo $data["Ogrenci"]; ?></a></li>
                        <li id="link_isciliste"><a href="<?php echo SITE_URL; ?>/AdminWeb/isciliste"><i class="fa fa-angle-right"></i><?php echo $data["TitleIsci"]; ?></a></li>
                    </ul>
                </li>
                <li id="menu_tur">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/turliste">
                        <i class="fa fa-refresh"></i> <span><?php echo $data["TurIslem"]; ?></span>
                    </a>
                </li>
                <li id="menu_bakiye">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/bakiyeliste">
                        <i class="fa fa-money"></i> <span><?php echo $data["BakiyeIslem"]; ?></span>
                    </a>
                </li>
                <li id="menu_lokasyon">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/lokasyonliste">
                        <i class="fa fa-map-marker"></i> <span><?php echo $data["LokasyonSorgu"]; ?></span>
                    </a>
                </li>
                <li id="menu_duyuru">
                    <a href="<?php echo SITE_URL; ?>/AdminWeb/duyuruliste">
                        <i class="fa fa-bullhorn"></i> <span><?php echo $data["Duyuru"]; ?></span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-check-square-o"></i> <span><?php echo $data["HesapIslem"]; ?></span>
                    </a>
                </li>
                <li class="menu_rapor">
                    <a href="#">
                        <i class="fa fa-line-chart"></i> <span><?php echo $data["Rapor"]; ?></span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>