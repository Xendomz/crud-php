<?php
require '../connection.php';
$DB = Connection::getInstance();
$mahasiswa = $DB->delete('mahasiswa', ['id', '=', $_GET['id']]);

if ($mahasiswa) {
    header('Location:index.php');
} else {
    echo "error";
}
?>