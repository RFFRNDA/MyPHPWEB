<?php 
require 'functions.php';

// Cek apakah submit button sudah diklik atau belum
if( isset($_POST["submit"]) ) {
    // cek apakah data berhasil di tambahkan atau tidak
    if ( tambah($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }else{
        echo "            
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'insert.php';
            </script>
        ";
    };
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styleInsert.css">
</head>
<body>
    <h1>Tambah data mahasiswa</h1>

    <div class="container">
        <form action="" method="post" class="inputForm">
            <div class="mb-3">
                <label for="nama"><b>Nama</b></label>
                <input type="text" class="form-control" name="nama" id="nama" required>
            </div>
            <div class="mb-3">
                <label for="matkul"><b>Mata Kuliah</b></label>
                <input type="text" class="form-control" name="matkul" id="matkul" required>
            </div>
            <div class="grade">
                <label for="grade"><b>Grade</b></label>
                <select name="grade" id="grade" required>
                    <option value="">Pilih Grade</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
            <div>
                <input type="hidden" name="nilai">
            </div>
            <div class="buttonBox">
                <button type="button" name="back" class="back">Kembali ke Daftar Mahasiswa</button>
                <button type="submit" name="submit" class="submit">Tambah Data</button>
            </div>
        </form>
    </div>

    <script>      
        const gradeValues = { 
            A: 4, 
            B: 3, 
            C: 2, 
            D: 1, 
            E: 0
        };

        // Ambil elemen dropdown "Grade" dan input "nilai"
        const gradeSelect = document.getElementById("grade");
        const nilaiInput = document.querySelector('input[name="nilai"]');
        
        // Tambahkan event listener untuk mendengarkan perubahan pada "grade"
        gradeSelect.addEventListener('change', function() {
            // Ambil value yang dipilih dalam "grade"
            const selectedGrade = gradeSelect.value;
            
            // Jika value yang dipilih adalah salah satu dari gradeValues
            if (gradeValues[selectedGrade] !== undefined) {
                // Set atribut "value" pada elemen input "nilai" dengan nilai yang sesuai
                nilaiInput.setAttribute('value', gradeValues[selectedGrade]);
            } else {
                // Jika grade tidak ada dalam gradeValues, hapus atribut "value" pada elemen input "nilai"
                nilaiInput.removeAttribute('value');
            }
        });

        document.querySelector(".back").addEventListener("click", function() {
            window.location.href = "index.php";
        });
    </script>
</body>
</html>