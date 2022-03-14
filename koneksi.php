<?php
$hostname = "localhost";
$database = "db_siswa";
$username = "root";
$password = "";
$connect = mysqli_connect($hostname, $username, $password, $database);
// script cek koneksi   
if (!$connect) {
    die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
    //Die() digunakan untuk mencetak pesan sekaligus mengeluarkan program yang sedang dibuka.
}