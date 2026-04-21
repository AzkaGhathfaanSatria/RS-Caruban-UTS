<?php
// Menghubungkan PHP ke database
$conn = mysqli_connect("localhost", "root", "", "rs_caruban");

// jika gagal maka error dan hentikan program
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>