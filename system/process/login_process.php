<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Default username XAMPP
$password = ""; // Default password XAMPP
$dbname = "user_db"; // Nama database Anda

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
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

// Cek apakah ada user yang ditemukan
if ($stmt->num_rows > 0) {
    // Ambil hash password dari database
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verifikasi password
    if (password_verify($password, $hashed_password)) {
        echo "Login successful! Welcome, " . htmlspecialchars($user) . ".";
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}
header("Location: ../../index.html");
exit();
// Tutup koneksi
$stmt->close();
$conn->close();
?>