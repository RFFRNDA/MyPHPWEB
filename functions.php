<?php 
// Koneksi ke database
$conn = mysqli_connect("localhost","root","","phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    //ambil data dari tiap elemen dalam form
    //htmlspecialchars untuk mengconvert <,>,&," agar tidak diproses oleh web browser
    //Hal itu untuk menghindadri penyusupan element HTML pada sebuah inputan
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }
    
    //query insert data
    $query = "INSERT INTO mahasiswa
                VALUES ('','$nama','$nim','$jurusan','$email','$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tempName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if( $error === 4 ) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    // cek ekstensi file
    $ekstensiValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode(".",$namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiValid) ) {
        echo "<script>
                alert('Yang anda Upload bukan gambar!');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > 100000 ){
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }

    // lolos pengecekan. gambar siap diupload
    // generate nama gambar baru
    $namaBaru = uniqid();
    $namaBaru .= '.';
    $namaBaru .= $ekstensiGambar;
    move_uploaded_file($tempName,'img/' . $namaBaru);
    
    return $namaBaru;

}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    //cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET 
                nim = '$nim',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
                WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
                WHERE nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%'
            ";
    // Menggunakan wildcard dengan LIKE %-% agar pencarian fleksibel
    return query($query);
}


?>