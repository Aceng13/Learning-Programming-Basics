<?php  
//koneksi ke database

$conn = mysqli_connect("localhost", "root", "", "belajarphp");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
		
	}
	return $rows;
}



function tambah($data) {
		global $conn;
		$Nama = htmlspecialchars($data["Nama"]);
		$Nip = htmlspecialchars($data["Nip"]);
		$Email = htmlspecialchars($data["Email"]);
		$Golongan = htmlspecialchars($data["Golongan"]);
		
		// upload gambar
		$Gambar = upload();
		if ( !$Gambar ) {
			return false;
		}

	$query = "INSERT INTO pegawai
					VALUES
					('', '$Nama', '$Nip', '$Email', '$Golongan', '$Gambar')
		";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
}
	
	function upload () {

		$namaFile = $_FILES['Gambar']['name'];
		$ukuranFile = $_FILES['Gambar']['size'];
		$error = $_FILES['Gambar']['error'];
		$tmpName = $_FILES['Gambar']['tmp_name'];



		// cek apakah tidak ada gambar yang di upload
			if( $error === 4 ) {
				echo "<script> 
						alert('Pilih Gambar Terlebih Dahulu!');
				</script>";
				return false;

			}

			// cek apakah yang diupload gambar
			$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
			$ekstensiGambar = explode('.', $namaFile);
			$ekstensiGambar = strtolower(end($ekstensiGambar));
			if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {

				echo "<script> 
						alert('Yang Anda Upload Bukan Gambar!');
				</script>";
				return false;

			}

			// cek jika ukuranya terlalu besar
			$ekstensiGambar = [' > 1500000 ' ];
   			 if(in_array($ukuranFile , $ekstensiGambar )) {
        	echo "<script>
            alert('Ukuran Gambar Terlalu Besar !');
       		 </script>";
        		return false;
    }

    		// lolos pengecekan, gambar siap diupload
    		// generate nama gambar baru 
    		$namaFileBaru = uniqid();
    		$namaFileBaru .= '.';
    		$namaFileBaru .= $ekstensiGambar;

    		move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    		return $namaFileBaru;



	}



	function hapus($Id) {
		global $conn;
		mysqli_query($conn, "DELETE FROM pegawai WHERE Id = $Id");
		return mysqli_affected_rows($conn);
	}

function ubah($data) {
global $conn;
		
		$Id = $data["Id"];
		$Nama = htmlspecialchars($data["Nama"]);
		$Nip = htmlspecialchars($data["Nip"]);
		$Email = htmlspecialchars($data["Email"]);
		$Golongan = htmlspecialchars($data["Golongan"]);
		$gambarLama = htmlspecialchars($data["gambarLama"]);

		// cek apakah user pilih gambar baru atau tidak
		if( $_FILES['Gambar']['error'] === 4 ) {
			$Gambar = $gambarLama;

		} else {
			$Gambar = upload();
		}

	$query = "UPDATE pegawai SET
			Nama = '$Nama',
			Nip = '$Nip',
			Email = '$Email',
			Golongan = '$Golongan',
			Gambar = '$Gambar'
			WHERE Id = $Id
		";

		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);

}

function cari($keyword) {
	$query = "SELECT * FROM pegawai 
				WHERE 
				Nip LIKE '%$keyword%' OR
				Nama LIKE '%$keyword%' OR
				Email LIKE '%$keyword%' OR
				Golongan LIKE '%$keyword%' 
				 ";

	return query($query);
}

	function registrasi($data) {
		global $conn;

		$username =  strtolower(stripcslashes($data["username"]));
		$email = strtolower(stripcslashes($data["email"]));
		$password = mysqli_real_escape_string($conn, $data["password"]);
		$password2 = mysqli_real_escape_string($conn, $data["password2"]);

		// cek username sudah ada atau belum
		$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

		if( mysqli_fetch_assoc($result) ) {
			echo "<script>
					alert('Username Sudah Terdaftar!')
					</script>";
				return false;
		}


		// cek informasi password
		if( $password !== $password2 ) {
			echo "<script>
					alert('Konfirmasi Password Tidak Sesuai!');
					</script>";

					return false;
		}
		
		// enskripsi password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// tambahkan userbaru ke database
		mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$email', '$password')");

		return mysqli_affected_rows($conn);
	}



?>