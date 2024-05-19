<?php
require '../connection.php';
$DB = Connection::getInstance();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mahasiswa = $DB->insert('mahasiswa', [
        'nama' => $_POST['nama'],
        'nim' => $_POST['nim'],
        'alamat' => $_POST['alamat'],
    ]);

    if ($mahasiswa) {
        header('Location:index.php');
    } else {
        echo "erro";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBO</title>
</head>
<body>
    <h2>CRUD DATA MAHASISWA</h2>
    <br>
    <br>
    <h3>Tambah Data Mahasiswa</h3>
    <form method="POST">
        <table>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim"></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>