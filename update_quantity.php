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

// AJAX isteği ile gelen verileri al
$productID = $_POST['product_id'];
$action = $_POST['action'];

// İşlemi kontrol et
if ($action === 'increase') {
    // Adeti artırma işlemi
    $sql = "UPDATE sepet SET urunadet = urunadet + 1 WHERE id = ?";
} elseif ($action === 'decrease') {
    // Adeti azaltma işlemi
    $sql = "UPDATE sepet SET urunadet = urunadet - 1 WHERE id = ?";

    // Eğer adet sıfıra düşerse, ürünü sil
    $deleteSql = "DELETE FROM sepet WHERE id = ? AND urunadet <= 1";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('i', $productID);
    $deleteStmt->execute();
    $deleteStmt->close();
}

// Sorguyu hazırla ve çalıştır
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productID);

$stmt->execute();

// Bağlantıyı kapat
$stmt->close();
$conn->close();
?>
