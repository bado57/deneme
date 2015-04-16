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
                <li class="active">
                    <a href="<?php echo SITE_URL; ?>/panel">
                        <i class="fa fa-home"></i> <span><?php echo $data["Anasayfa"]; ?></span>
                    </a>
                </li>
                <li id="menu_firma">
                    <a href="<?php echo SITE_URL; ?>/adminweb/firmislem">
                        <i class="fa fa-building"></i>
                        <span><?php echo $data["FirmaIslem"]; ?></span>
                    </a>
                </li>

                <li class="treeview" id="menu_bolge">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span><?php echo $data["BolgeIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_bolgeliste"><a href="<?php echo SITE_URL; ?>/adminweb/bolgeliste"><i class="fa fa-angle-right"></i><?php echo $data["BolgeListe"]; ?></a></li>
                    </ul>
                </li>
                <li class="treeview" id="menu_kurum">
                    <a href="#">
                        <i class="fa fa-building-o"></i>
                        <span><?php echo $data["Kurumlar"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_kurumliste"><a href="<?php echo SITE_URL; ?>/adminweb/kurumliste"><i class="fa fa-angle-right"></i><?php echo $data["KurumListe"]; ?></a></li>
                    </ul>
                </li>
                <li class="treeview" id="menu_arac">
                    <a href="#">
                        <i class="fa fa-bus"></i>
                        <span><?php echo $data["AracIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_aracliste"><a href="<?php echo SITE_URL; ?>/adminweb/aracliste"><i class="fa fa-angle-right"></i><?php echo $data["AracListe"]; ?></a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span><?php echo $data["KullaniciIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-refresh"></i> <span><?php echo $data["TurIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span><?php echo $data["BakiyeIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-map-marker"></i> <span><?php echo $data["LokasyonSorgu"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullhorn"></i> <span><?php echo $data["Duyuru"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-envelope"></i> <span><?php echo $data["Mesaj"]; ?></span>
                        <small class="badge pull-right bg-yellow">12</small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text"></i> <span><?php echo $data["Rapor"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-right"></i> Editors</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>