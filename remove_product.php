<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// AJAX isteği ile gelen veriyi al
$productID = $_POST['product_id'];

// Ürünü silme işlemi
$sql = "DELETE FROM sepet WHERE id = ?";

// Sorguyu hazırla ve çalıştır
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productID);
$stmt->execute();

// Bağlantıyı kapat
$stmt->close();
$conn->close();
?>
