<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cart";

// MySQLi bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$return = array();

// MySQLi kullanımı
$query = $conn->prepare('INSERT INTO sepet (kullaniciID, urunid, urunadet) VALUES (?, ?, ?)');
$query->bind_param('iii', $kullaniciID, $urunid, $urunadet);

$kullaniciID = 1;
$urunid = $_POST['urunid'];
$urunadet = $_POST['urunadet'];

$query->execute();

if ($query->affected_rows > 0) {
    $return['mesaj'] = 'İşlem başarılı';
} else {
    $return['mesaj'] = 'İşlem başarısız';
}

echo json_encode($return);

?>
