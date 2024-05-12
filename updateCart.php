<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// JSON formatında cevap döndürmek için başlık ayarla
header('Content-Type: application/json');

// Ürün eklemek için
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "add_to_cart") {
        $urunID = $_POST["urunID"];
        $kullaniciID = 1; // Kullanıcı ID'sini uygun şekilde ayarlayın
        $urunAdet = 1; // Sepete eklenen ürün adedi

        // Sepette aynı ürün var mı kontrol et
        $queryCheck = $conn->prepare('SELECT * FROM sepet WHERE kullaniciID = ? AND urunID = ?');
        $queryCheck->bind_param('ii', $kullaniciID, $urunID);
        $queryCheck->execute();
        $resultCheck = $queryCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Ürün zaten sepette varsa adeti artır
            $queryUpdate = $conn->prepare('UPDATE sepet SET urunadet = urunadet + ? WHERE kullaniciID = ? AND urunID = ?');
            $queryUpdate->bind_param('iii', $urunAdet, $kullaniciID, $urunID);
            $queryUpdate->execute();
        } else {
            // Ürün sepette yoksa ekle
            $queryInsert = $conn->prepare('INSERT INTO sepet (kullaniciID, urunID, urunadet) VALUES (?, ?, ?)');
            $queryInsert->bind_param('iii', $kullaniciID, $urunID, $urunAdet);
            $queryInsert->execute();
        }

        // Sepeti tekrar getir ve JSON formatında döndür
        $querySelect = $conn->prepare('SELECT urunid, product_name, price, SUM(urunadet) as toplam_adet
                                       FROM sepet s
                                       INNER JOIN product p ON p.id = s.urunid
                                       WHERE kullaniciID = ?
                                       GROUP BY urunid, product_name, price');
        $querySelect->bind_param('i', $kullaniciID);
        $querySelect->execute();

        $result = $querySelect->get_result();
        $updatedCart = [];

        while ($row = $result->fetch_assoc()) {
            $updatedCart[] = [
                'urunid' => $row["urunid"],
                'product_name' => $row["product_name"],
                'price' => $row["price"],
                'toplam_adet' => $row["toplam_adet"]
            ];
        }

        echo json_encode(['cart' => $updatedCart]);
    }

    // Ürünü silmek için
    elseif ($_POST["action"] == "remove_from_cart" && isset($_POST["urunID"])) {
        $urunID = $_POST["urunID"];
        $kullaniciID = 1; // Kullanıcı ID'sini uygun şekilde ayarlayın

        // Sepet tablosundan ürünü sil
        $queryDelete = $conn->prepare('DELETE FROM sepet WHERE kullaniciID = ? AND urunID = ?');
        $queryDelete->bind_param('ii', $kullaniciID, $urunID);
        $queryDelete->execute();

        // Sepeti tekrar getir ve JSON formatında döndür
        $querySelect = $conn->prepare('SELECT urunid, product_name, price, SUM(urunadet) as toplam_adet
                                       FROM sepet s
                                       INNER JOIN product p ON p.id = s.urunid
                                       WHERE kullaniciID = ?
                                       GROUP BY urunid, product_name, price');
        $querySelect->bind_param('i', $kullaniciID);
        $querySelect->execute();

        $result = $querySelect->get_result();
        $updatedCart = [];

        while ($row = $result->fetch_assoc()) {
            $updatedCart[] = [
                'urunid' => $row["urunid"],
                'product_name' => $row["product_name"],
                'price' => $row["price"],
                'toplam_adet' => $row["toplam_adet"]
            ];
        }

        echo json_encode(['cart' => $updatedCart]);
    }
}
?>
