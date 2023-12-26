<?php
// Koneksi
$conn = mysqli_connect("localhost", "root", "", "admin");

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $row = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function tambah($data)
{
  global $conn;

  // Ambil data dari tiap element dalam form
  $nik = htmlspecialchars($data["nik"]);
  $nama = htmlspecialchars($data["nama"]); // htmlspecialchars : biar kalo ngirim html jadi string lurd
  $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
  $no_hp = htmlspecialchars($data["no_hp"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $agama = htmlspecialchars($data["agama"]);
  $rt = htmlspecialchars($data["rt"]);

  // Upload gambar dari file
  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  // Query insert data
  $query = "INSERT INTO tb_warga
                VALUES 
                ($nik, '$nama', '$jenis_kelamin', '$no_hp', '$alamat', '$agama', '$rt', '$gambar')";

  mysqli_query($conn, $query);

  // Cek apakah data berhasil di tambahkan ?
  return mysqli_affected_rows($conn);
}

function upload()
{
  $namaFile = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  // Cek apakah tidak ada gambar yg di upload
  if ($error === 4) {
    echo "<script>
            alert('Pilih gambar terlebih dahulu');
        </script>";
    return false;
  }

  // Cek apakah yang di upload adalah gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
                alert('Upload gambar!');
            </script>";
    return false;
  }

  // Cek jika ukuran terlalu besar
  if ($ukuranFile > 1000000) {
    echo "<script>
                alert('Gambar terlalu besar!');
            </script>";
    return false;
  }

  // Lolos pengecekan 
  // Generate nama gambar baru agar tidak sama
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;
  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  return $namaFileBaru;
}

function hapus($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM tb_warga WHERE nik = $id");
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  global $conn;

  // Ambil data dari tiap element dalam form
  $nik = ($data["nik"]);
  $nama = htmlspecialchars($data["nama"]);
  $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]); // htmlspecialchars : biar kalo ngirim html jadi string lurd
  $no_hp = htmlspecialchars($data["no_hp"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $agama = htmlspecialchars($data["agama"]);
  $rt = htmlspecialchars($data["rt"]);
  $gambarLama = htmlspecialchars($data["gambarLama"]);

  // Cek user pilih gambar baru atau tidak
  if ($_FILES['gambar']['error'] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }


  // Query insert data
  $query = "UPDATE tb_warga SET 
            nik = '$nik',
            nama = '$nama',
            jenis_kelamin = '$jenis_kelamin',
            no_hp = '$no_hp',
            alamat = '$alamat',
            agama = '$agama',
            rt = '$rt',
            gambar = '$gambar'
        WHERE nik = $nik";

  mysqli_query($conn, $query);

  // Cek apakah data berhasil di tambahkan ?
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $query = "SELECT * FROM tb_warga
        WHERE nama LIKE '%$keyword%' 
        OR jenis_kelamin LIKE '%$keyword%' 
        OR no_hp LIKE '%$keyword%'
        OR alamat LIKE '%$keyword%'
        OR agama LIKE '%$keyword%'
        OR rt LIKE '%$keyword%'
        ";

  return query($query);
}
