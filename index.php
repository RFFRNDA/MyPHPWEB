<?php 
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

//tombol cari ditekan
if( isset($_POST["cari"]) ) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    
<a href="logout.php">Logout</a>

<h1>Daftar Mahasiswa</h1>

<a href="insert.php">Tambah data mahasiswa</a>
<br><br>

<form action="" method="post">

    <input type="text" name="keyword" size="40" autofocus 
    placeholder="Masukkan keyword pencarian.." autocomplete="off">
    <button type="submit" name="cari">Cari</button>

</form>

<br>

<table border="1" cellpadding="10" cellspacing="0">
    
    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Email</th>
    </tr>

    <?php $i = 1; ?>
    <?php foreach( $mahasiswa as $mhs ) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td>
            <a href="edit.php?id=<?= $mhs["id"]; ?>">Ubah</a> |
            <a href="delete.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Yakin?');">Hapus</a>
        </td>
        <td>
            <img src="img/<?= $mhs["gambar"]; ?>" width="50">
        </td>
        <td><?= $mhs["nim"]; ?></td>
        <td><?= $mhs["nama"]; ?></td>
        <td><?= $mhs["jurusan"]; ?></td>
        <td><?= $mhs["email"]; ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>

</table>

</body>
</html>