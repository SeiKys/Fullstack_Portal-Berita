<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Default username XAMPP
$password = ""; // Default password XAMPP
$dbname = "admin_db"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form login
$user = $_POST['username'];
$password = $_POST['password'];


// Siapkan pernyataan untuk mencari user
$stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

// Cek apakah ada user yang ditemukan
if ($stmt->num_rows > 0) {
    // Ambil hash password dari database
    $stmt->bind_result($password);
    $stmt->fetch();

// Verifikasi password
if ($password == $password) { // Perbandingan langsung
    echo "Login successful! Welcome, " . htmlspecialchars($user) . ".";
    header("location: ../../index - Admin.html");}
 else {
    echo "Invalid password.";
}
} else {
header("Location: login_process.php");
}
// Tutup koneksi
$stmt->close();
$conn->close();
?>