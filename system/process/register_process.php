<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Ambil data dari form
$user = $_POST['username'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

// Cek apakah username sudah ada
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close(); // Pastikan untuk menutup pernyataan setelah selesai

// Set header untuk JSON
header('Content-Type: application/json');

if ($count > 0) {
    // Mengembalikan respons JSON jika username sudah ada
    echo json_encode(array("status" => "error", "message" => "Username telah dipakai, coba yang lain."));
} else {
    // Siapkan dan jalankan pernyataan untuk menyimpan data
    $stmt = $conn->prepare("INSERT INTO users (username, full_name, email, password) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $user, $full_name, $email, $password);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Registration successful!"));
        exit(); // Hentikan eksekusi setelah mengembalikan respons
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
    }

    $stmt->close(); // Tutup pernyataan setelah selesai
}
header("Location: ../../login.html");
exit();
// Tutup koneksi
$stmt->close();
$conn->close();
?>