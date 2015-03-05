<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
 <!--Kodlaması Bayram ALTINIŞIK'a ait.
   Teşekkür için reklama tıklamanız yeterlidir :)
   iletisim: http://www.softwareline.net
 -->
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<style type="text/css">@import url("css/kategori.css");</style>
	<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="js/kategori.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/kategoricss.js"></script>
	<title>KATEGORİ UYGULAMASI</title>
</head>

<body>
    <div id="ust"></div>
	<div id="gorsel">
	  <div id="menu">
		<ul class="anasayfa">
		<?php 		  
		$sessionz=$_SESSION['mesaj'];
	     $query  =$db->query("SELECT  * FROM ana_kategori WHERE session='$sessionz' ORDER BY ana_kategori_id  ASC",PDO::FETCH_ASSOC);
	     if ($altcount=$query -> rowCount()) {
          foreach ($query   as  $row) {
            echo '<li class="'.$row["ana_kategori_id"].'" id="'.$row["ana_kategori_id"].'"><a href="#">'.$row["ana_kategori_adi"].'</a>'; 
				$querym =$db->query("SELECT * FROM alt_kategoriler WHERE alt_ana_kategori=".$row["ana_kategori_id"]." && alt_session='$sessionz'");
				if($querym -> rowCount()){ 
				 echo '<ul class="'.$row["ana_kategori_id"].'" id="'.$row["ana_kategori_id"].'" >';
				 foreach ($querym as $row){
				   echo '<li><a href="#">'.$row["alt_kategori_adi"].'</a></li>';
				  }
			echo '</ul>';
          }
		
      }
	    
	}
	echo '<div id="hesapalt" value="'.$altcount.'"></div>';
		  ?>
		</ul>
		</div>
	<div style="color:red" id="sonucum">asdadsas</div>
	</div>

	<div id="kategori">
		<ul>
		<span>Ana Kategori Adı:</span>
		<li><input type="text" name="ana_kategori" id="bosluk" value="Lütfen bir kategori adı giriniz.."/></li>
		<button onclick="$.Blog.anaKategori()" id="ekleme">Ekle</button>
		<div style="color:red" id="sonuc">asdadsas</div>
		</ul>
	</div>
	<div id="alt_kategori">
		<ul>
		<span>Hangi Kategori Altına Gelsin:</span>
		<select name="salt_ana_kategori">
			 <?php
			 $query  =$db->query("SELECT  * FROM ana_kategori ORDER BY ana_kategori_id DESC",   PDO::FETCH_ASSOC);
			  if ($query -> rowCount()) {
				  foreach ($query   as  $katRow) {
					echo '<option value="'.$katRow["ana_kategori_id"].'">'.$katRow["ana_kategori_adi"].'</option>';
				  }
			  }
			?>
		</select>
		<li></li>
		<span>Alt Kategori Adı:</span>
		<li><input type="text" name="alt_kategori" id="alt_bosluk" value="Lütfen bir alt kategori adı giriniz.."/></li>
		<button onclick="$.Blog.altKategori()" id="alt_gorsel">Ekle</button>
		<div style="color:red" id="alt_sonuc">asdadsas</div>
		</ul>
	</div>
</body>
</html>