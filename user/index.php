<?php
require '../connection.php';
$DB = Connection::getInstance();
$mahasiswa = $DB->get('mahasiswa');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBO</title>
</head>
<body>
    <h2>DATA MAHASISWA</h2>
    <br>
    <a href="tambah.php">TAMBAH MAHASISWA +</a>
    <br>
    <br>
    <table border="1">
        <tr>
            <td>NO</td>
            <td>Nama</td>
            <td>NIM</td>
            <td>Alamat</td>
            <td>Action</td>
        </tr>
        <?php
        foreach ($mahasiswa as $key => $mahasiswa):
        ?>
        <tr>
            <td><?= ++$key ?></td>
            <td><?= $mahasiswa->nama ?></td>
            <td><?= $mahasiswa->nim ?></td>
            <td><?= $mahasiswa->alamat ?></td>
            <td>
                <a href="edit.php?id=<?= $mahasiswa->id ?>">Edit</a>
                <a href="delete.php?id=<?= $mahasiswa->id ?>">Hapus</a>
            </td>
        </tr>
        <?php
        endforeach;
        ?>
    </table>
</body>
</html>