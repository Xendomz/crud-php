<?php
require '../connection.php';
$DB = Connection::getInstance();
$mahasiswa = $DB->getWhereOnce('mahasiswa', ['id', '=', $_GET['id']]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mahasiswa = $DB->update('mahasiswa', [
        'nama' => $_POST['nama'],
        'nim' => $_POST['nim'],
        'alamat' => $_POST['alamat'],
    ],['id', '=', $_GET['id']]);

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
                <td><input type="text" name="nama" value="<?= $mahasiswa->nama ?>"></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim" value="<?= $mahasiswa->nim ?>"></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" value="<?= $mahasiswa->alamat ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>