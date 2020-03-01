<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");

	exit;

}

 require 'functions.php';

 // ambil data di URL
 	$Id = $_GET["Id"];

 // query data mahasiswa berdasarkan id
 	$pgw = query("SELECT * FROM pegawai WHERE Id = $Id")[0];
// cek apakah tombol submit sudah ditekan apa belum
	if( isset($_POST["submit"]) ) {
		// cek apakah data berhasil di ubah atau tidak
		if( ubah($_POST) > 0 ) {

			// alert framework java
			echo "
				<script>
				alert('data berhasil diubah!');
				document.location.href = 'index.php';
				</script>

			";
		} else {
			echo "
				<script>
				alert('data gagal diubah!');
				document.location.href = 'index.php';
				</script>

			";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data Pegawai</title>
</head>
<body>

	<h1>Ubah Data Pegawai</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="Id" value="<?= $pgw["Id"]; ?>">
		<input type="hidden" name="gambarLama" value="<?= $pgw["Gambar"]; ?>">
	<ul>
		<li>

			<label for="Nama">Nama : </label>
			<input type="text" name="Nama" id="Nama" value="<?= $pgw["Nama"]; ?>">


		</li> 

		<li>
			<label for="Nip">Nip : </label>
			<input type="text" name="Nip" id="Nip" required value="<?= $pgw["Nip"]; ?>">
			</li>
			
			<li>
				<label for="Email">Email : </label>
			<input type="text" name="Email" id="Email" value="<?= $pgw["Email"]; ?>">

			</li>
			<li>
				<label for="Golongan">Golongan : </label>
			<input type="text" name="Golongan" id="Golongan" value="<?= $pgw["Golongan"]; ?>">

			</li>
		<li>
			<label for="Gambar">Gambar : </label> <br>
			<img src="img/<?= $pgw['Gambar']; ?>" width="70"> <br>
			<input type="file" name="Gambar" id="Gambar">
		</li>
		<li>
			
		<button type="submit" name="submit">Ubah Data!</button>
		</li>

	</ul>

</body>
</html>