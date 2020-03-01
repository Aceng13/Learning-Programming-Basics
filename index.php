<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");

	exit;

}
require 'functions.php';

	// pagination
	// konfigurasi
	$jumlahDataPerHalaman = 3;
	$jumlahData = count(query("SELECT * FROM pegawai"));
	$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
	$halamanAktif = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
	$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;
	

$pegawai = query("SELECT * FROM pegawai LIMIT $awalData, $jumlahDataPerHalaman");


	// tombol cari ditekan
	if( isset($_POST["cari"]) ) {
		$pegawai = cari($_POST["keyword"]);
	}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>
<body>

<a href="logout.php">Logout</a>

<h1>Daftar Pegawai</h1>

		<a href="tambah.php">Tambah Data Pegawai</a>
		<br><br>
<form action="" method="post">
	
	<input type="text" name="keyword" size="40" autofocus placeholder="Silahkan Masukan Pencarian...." autocomplete="off">
	<button type="submit" name="cari">Search</button>

</form>
<br><br>
<!-- Navigasi -->
<?php if( $halamanAktif > 1 ) : ?>
	<a href="?page<?= $halamanAktif - 1; ?>">&laquo;</a>
<?php endif; ?>


<?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
	<?php if( $i == $halamanAktif ) : ?>
	<a href="?page=<?= $i; ?>" style="font-weight: bold; color: blue;"><?= $i; ?></a>
	<?php else : ?>
		<a href="?page=<?= $i; ?>"><?= $i; ?></a>
	<?php endif; ?>
	<?php endfor; ?>

<?php if( $halamanAktif < $jumlahHalaman ) : ?>
	<a href="?page<?= $halamanAktif + 1; ?>">&raquo;</a>
<?php endif; ?>


<br> 
<table border="1" cellpadding="10" cellspacing="0">

<tr>
	<th>No.</th>
	<th>Aksi</th>
	<th>Gambar</th>
	<th>NIP</th>
	<th>Nama</th>
	<th>Email</th>
	<th>Golongan</th>
</tr>

		<?php $i = 1;  ?>
 <?php foreach( $pegawai as $row ) : ?>
 <tr>
 	<td><?= $i; ?></td>
 	<td>
 		<a href="ubah.php?Id=<?= $row["Id"]; ?>">Ubah</a>
 		<a href="hapus.php?Id=<?= $row["Id"]; ?>" onclick=" return confirm('yakin?');">Hapus</a>
 		
 	</td>

 	<td><img src="img/<?= $row["Gambar"]; ?>"
 	width="100"></td>
 	<td><?= $row["Nip"]; ?></td>
 	<td><?= $row["Nama"]; ?></td>
 	<td><?= $row["Email"]; ?></td>
 	<td><?= $row["Golongan"]; ?></td>


 </tr>
 	<?php $i++;  ?>
 	<?php endforeach; ?>
 	
 	</table>

</body>
</html>