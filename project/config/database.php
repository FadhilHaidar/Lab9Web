<?php
// config/database.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'db_barang';


$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$koneksi) {
// Friendly error (development) - you may want to show less detail in production
die('Koneksi gagal: ' . mysqli_connect_error());
}
mysqli_set_charset($koneksi, 'utf8mb4');


// expose minimal wrapper
function db() {
global $koneksi;
return $koneksi;
}
?>