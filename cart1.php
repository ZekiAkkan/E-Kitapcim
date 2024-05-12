<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainstyle.css">
    <link rel="stylesheet" href="sepet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>E-kitap | Sepet</title>
</head>
<body>

    <header>
        <div class="logo2">E-Kitapçım</div>
        <div class="header-nav2">
            <a href="index.php">Anasayfa</a>
        </div>
        <div class="header-nav2" style="margin-left: auto;">
            <a href="cart1.php"><i class="fas fa-shopping-cart icons"></i>Sepet</a>
        </div>
    </header>

    <div class="container">
        <ul id="cart-list">
            <?php
            $kullaniciID = 1;
            $query = $conn->prepare('SELECT s.id, s.urunid, p.product_name, p.price, s.urunadet
                        FROM sepet s
                        INNER JOIN product p ON p.id = s.urunid
                        WHERE s.kullaniciID = ?');

            $query->bind_param('i', $kullaniciID);
            $query->execute();
            $result = $query->get_result();

            $toplam = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<li data-id="' . $row["id"] . '" data-urunid="' . $row["urunid"] . '">';
                echo '<span>' . $row["product_name"] . '</span> - ' . $row["price"] . ' TL ';
                echo '<span class="urun-adet"> ' . $row["urunadet"] . ' Adet </span>';
                echo '<button class="add-quantity">+</button>';
                echo '<button class="remove-quantity">-</button>';
                echo '<button class="remove-product">Ürünü Sil</button>';
                echo '</li>';

                $toplam += $row["price"] * $row["urunadet"];
            }
            ?>
        </ul>
        <div class="total">
            Ödenecek Tutar: <span id="total-amount"><?= $toplam ?></span> TL
        </div>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cartList = document.getElementById('cart-list');
            var totalAmount = document.getElementById('total-amount');

            // Adet Artırma
            cartList.addEventListener('click', function (event) {
                if (event.target.classList.contains('add-quantity')) {
                    var listItem = event.target.closest('li');
                    var productId = listItem.getAttribute('data-id');

                    // Ajax ile adet artırma işlemi
                    updateQuantity(productId, 'increase');
                }
            });

            // Adet Azaltma
            cartList.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-quantity')) {
                    var listItem = event.target.closest('li');
                    var productId = listItem.getAttribute('data-id');

                    // Ajax ile adet azaltma işlemi
                    updateQuantity(productId, 'decrease');
                }
            });

            // Ürünü Silme
            cartList.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-product')) {
                    var listItem = event.target.closest('li');
                    var productId = listItem.getAttribute('data-id');

                    // Ajax ile ürünü silme işlemi
                    removeProduct(productId);
                    location.reload()
                }
            });

            // Veritabanını güncelleyen Ajax fonksiyonları
            function updateQuantity(productId, action) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_quantity.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        
                        updateTotalAmount();
                        location.reload()
                    }
                };
                xhr.send('product_id=' + productId + '&action=' + action);
            }

            function removeProduct(productId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_product.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        
                        updateTotalAmount();
                        location.reload()
                    }
                };
                xhr.send('product_id=' + productId);
            }

            function updateTotalAmount() {
                var total = 0;
                var listItems = cartList.querySelectorAll('li');
                listItems.forEach(function (item) {
                    var price = parseFloat(item.innerText.split(' TL')[0].split(' - ')[1]);
                    var quantity = parseInt(item.querySelector('.urun-adet').innerText);
                    total += price * quantity;
                    location.reload()
                });

                totalAmount.innerText = total.toFixed(2);
            }
        });
    </script>

    <?php include('footer.php'); ?>
    <script src="https://kit.fontawesome.com/c463ab28df.js" crossorigin="anonymous"></script>
</body>
</html>
