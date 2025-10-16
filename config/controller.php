<?php
function select($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows; // BUKAN $result
}


 // fungsi menambahkan (create)
function create_barang($post)
{
    global $db;

    $nama   = $post['nama'];
    $jumlah = $post['jumlah'];
    $harga  = $post['harga'];
    $barcode = rand(100000, 999999);

    // query tambah data
    $query = "INSERT INTO barang VALUES (null, '$nama', '$jumlah', '$harga', '$barcode', CURRENT_TIMESTAMP())";

    mysqli_query($db, $query);
   
    return mysqli_affected_rows($db);
}

// fungsi update (ubah data barang)
function update_barang($post)
{
    global $db;

    $id_barang = (int)$post['id_barang'];
    $nama      = $post['nama'];
    $jumlah    = $post['jumlah'];
    $harga     = $post['harga'];

    $query = "UPDATE barang 
              SET nama   = '$nama',
                  jumlah = '$jumlah',
                  harga  = '$harga'
              WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi menghapus data barang
function delete_barang($id_barang)
{
  global $db;

  //query hapus data barang
  $query = "DELETE FROM barang WHERE id_barang = $id_barang";
  mysqli_query($db, $query);
  return mysqli_affected_rows($db);
}

// fungsi menambahkan mahasiswa(create)
function create_mahasiswa($post)
{
    global $db;

    $nama     = strip_tags($post['nama']);
    $prodi    = strip_tags($post['prodi']);
    $jk       = strip_tags($post['jk']);
    $telepon  = strip_tags($post['telepon']);
    $alamat   = $post['alamat'];  
    $email    = strip_tags($post['email']);
    $foto     = upload_file();
//CHECK UPLOAD foto
if (!$foto) {
    return false;
}

// Query tambah data
$query = "INSERT INTO mahasiswa 
          VALUES (NULL, '$nama', '$prodi', '$jk', '$telepon', '$alamat', '$email', '$foto')";

mysqli_query($db, $query);

return mysqli_affected_rows($db);

}
// fungsi mengupload file
function upload_file()
{
    $namaFile   = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error      = $_FILES['foto']['error'];
    $tmpName    = $_FILES['foto']['tmp_name'];

    // check file yang diupload
    $ekstensiFileValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFile      = explode('.', $namaFile);
    $ekstensiFile      = strtolower(end($ekstensiFile));

// check format/ekstensi file
if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    // pesan gagal
    echo "<script>
            alert('Format File Tidak Valid');
            document.location.href = 'tambah-mahasiswa.php';
          </script>";
    die();
}

// check ukuran file 2 MB
if ($ukuranFile > 2048000) {
    // pesan gagal
    echo "<script>
            alert('Ukuran File Terlalu Besar');
            document.location.href = 'tambah-mahasiswa.php';
          </script>";
    die();
}

// generate nama file baru
$namaFileBaru = uniqid();
$namaFileBaru .= '.';
$namaFileBaru .= $ekstensiFile;

// pindahkan ke folder local
move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

return $namaFileBaru;
}
// DELETE MAHASISWA
function delete_mahasiswa($id_mahasiswa)
{
  global $db;

  // AMBIL FOTO SESUAI DATA
   $foto = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
   unlink("assets/img/". $foto['foto']);
  //query hapus data mahasiswa
  $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
  mysqli_query($db, $query);
  return mysqli_affected_rows($db);
}

//UBAH MAHASISWA
function update_mahasiswa($post)
{
    global $db;

    $id_mahasiswa     = strip_tags($post['id_mahasiswa']);
    $nama     = strip_tags($post['nama']);
    $prodi    = strip_tags($post['prodi']);
    $jk       = strip_tags($post['jk']);
    $telepon  = strip_tags($post['telepon']);
    $alamat   = $post['alamat'];  
    $email    = strip_tags($post['email']);
    $fotoLama = strip_tags($post['fotoLama']);
//CHECK UPLOAD foto
if ($_FILES['foto']['error'] == 4) {
    $foto = $fotoLama;

} else {
    $foto = upload_file();
}
// Query ubah data
$query = "UPDATE mahasiswa SET nama = '$nama', prodi = '$prodi' , jk = '$jk' , telepon = '$telepon' , alamat = '$alamat' ,email = '$email' , foto = '$foto' WHERE id_mahasiswa = $id_mahasiswa";

mysqli_query($db, $query);

return mysqli_affected_rows($db);
}

// fungsi tambah akun
function create_akun($post)
{
    global $db;

    $nama = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $email = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $level = strip_tags($post['level']);
    // enkripsi pw
    $password = password_hash($password, PASSWORD_DEFAULT);
    // query tambah data
    $query = "INSERT INTO akun VALUES(null, '$nama', '$username', '$email', '$password', '$level')";
    
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// DELETE AKUN
function delete_akun($id_akun)
{
  global $db;

 
  //query hapus data mahasiswa
  $query = "DELETE FROM akun WHERE id_akun = $id_akun";
  mysqli_query($db, $query);
  return mysqli_affected_rows($db);
}

// fungsi ubah akun
function update_akun($post)
{
    global $db;

    $id_akun = strip_tags($post['id_akun']);
    $nama = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $email = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $level = strip_tags($post['level']);
    // enkripsi pw
    $password = password_hash($password, PASSWORD_DEFAULT);
    // query ubah data
    $query = "UPDATE akun 
          SET nama = '$nama', 
              username = '$username', 
              email = '$email', 
              password = '$password', 
              level = '$level' 
          WHERE id_akun = $id_akun";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
?>



