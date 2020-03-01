<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");

	exit;

}

 require 'functions.php';
// cek apakah tombol submit sudah ditekan apa belum
	if( isset($_POST["submit"]) ) {


		// cek apakah data berhasil di tambahkan atau tidak
		if( tambah($_POST) > 0 ) {

			// alert framework java
			echo "
				<script>
				alert('data berhasil ditambahkan!');
				document.location.href = 'index.php';
				</script>

			";
		} else {
			echo "
				<script>
				alert('data gagal ditambahkan!');
				document.location.href = 'index.php';
				</script>

			";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data Pegawai</title>
</head>
<body>

	<h1>Tambah Data Pegawai</h1>

	<form action="" method="post" enctype="multipart/form-data">
	<ul>
		<li>

			<label for="Nama">Nama : </label>
			<input type="text" name="Nama" id="Nama">


		</li> 

		<li>
			<label for="Nip">Nip : </label>
			<input type="text" name="Nip" id="Nip" required>
			</li>
			
			<li>
				<label for="Email">Email : </label>
			<input type="text" name="Email" id="Email">

			</li>
			<li>
				<label for="Golongan">Golongan : </label>
			<input type="text" name="Golongan" id="Golongan">

			</li>
		<li>
			<label for="Gambar">Gambar : </label>
			<input type="file" name="Gambar" id="Gambar">
		</li>
		<li>
			
		<button type="submit" name="submit">Tambah Data!</button>
		</li>

	</ul>

</body>
</html>