<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo SITE_PLUGINADMIN_IMG; ?>/avatar3.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php echo $data["AdminHello"]; ?>, <?php echo Session::get("username"); ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="<?php echo $data["AdminLeftMenuSearch"]; ?>"/>
                    <span class="input-group-btn">
                        <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="<?php echo SITE_URL; ?>/panel">
                        <i class="fa fa-home"></i> <span><?php echo $data["AdminKategoriAnasayfa"]; ?></span>
                    </a>
                </li>
                <li class="treeview" id="menu_firma">
                    <a href="#">
                        <i class="fa fa-building"></i>
                        <span><?php echo $data["AdminKategoriFirmaIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_firmislem"><a href="<?php echo SITE_URL; ?>/adminweb/firmislem"><i class="fa fa-angle-right"></i> Firma Bilgileri</a></li>
                    </ul>
                </li>

                <li class="treeview" id="menu_bolge">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span><?php echo $data["Bolgeler"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_bolgeliste"><a href="<?php echo SITE_URL; ?>/adminweb/bolgeliste"><i class="fa fa-angle-right"></i><?php echo $data["BolgeListe"]; ?></a></li>
                    </ul>
                </li>
                <li class="treeview" id="menu_arac">
                    <a href="#">
                        <i class="fa fa-building-o"></i>
                        <span><?php echo $data["Kurumlar"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_aracliste"><a href="<?php echo SITE_URL; ?>/adminweb/kurumliste"><i class="fa fa-angle-right"></i><?php echo $data["KurumListe"]; ?></a></li>
                    </ul>
                </li>
                <li class="treeview" id="menu_arac">
                    <a href="#">
                        <i class="fa fa-bus"></i>
                        <span><?php echo $data["AdminKategoriAracIslem"]; ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="link_aracliste"><a href="<?php echo SITE_URL; ?>/adminweb/aracliste"><i class="fa fa-angle-right"></i><?php echo $data["AracListe"]; ?></a></li>
                        <li><a href="pages/UI/icons.html"><i class="fa fa-angle-right"></i> Icons</a></li>
                        <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-right"></i> Buttons</a></li>
                        <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-right"></i> Sliders</a></li>
                        <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-right"></i> Timeline</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriKullaniciIslem"]; ?></span>
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
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriTurIslem"]; ?></span>
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
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriBakiyeIslem"]; ?></span>
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
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriLokasyonSorgu"]; ?></span>
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
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriDuyuru"]; ?></span>
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
                        <i class="fa fa-envelope"></i> <span><?php echo $data["AdminKategoriMesaj"]; ?></span>
                        <small class="badge pull-right bg-yellow">12</small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span><?php echo $data["AdminKategoriRapor"]; ?></span>
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