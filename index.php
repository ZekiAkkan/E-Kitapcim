<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link rel="stylesheet" href="mainstyle.css">
    <title>E-kitap</title>
</head>
<body>

  
<?php include('header.php'); ?>  
  
<div id="slider" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/Slider1.jpg" class="d-block w-100" alt="Slider Resim 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>Yeni Nesil Eğitim Kitapları</h5>
        <p>2024 Yılına uygun yeni seri basımlar ve yeni sınav sistemine uygun sorular sizeleri bekliyor! </p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="./images/slider2.png" class="d-block w-100" alt="Slider Resim 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Yeni romanlarımızı gördünüz mü?</h5>
        <p>Hemen satın al ve okumaya başla!</p>
      </div>
    </div>
    

    
  </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>



  
  <section class="hakkimizda" id="hk">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 offset-lg-2 text-center">
                  <h2 class="bolum-basligi">Hakkımızda</h2>
                  <p class="bolum-metni">
                      <i class="fas fa-book-open icon"></i>
                      E-Kitapçım, kaliteli eğitim ve keyifli okuma deneyimleri sunmayı amaçlayan bir platformdur.
                      2024 yılına uygun yeni nesil eğitim kitapları ve keyifli romanlarla okuyucularımıza hizmet vermekteyiz.
                      Her bir kitap özenle seçilmiş ve sizin için özel olarak hazırlanmıştır.
                      <i class="fas fa-lightbulb icon"></i>
                  </p>
              </div>
          </div>
      </div>
  </section>


  

  <hr>
  <div class="book-logos" id="kitaplar" >
    <div class="book-logo-container">
        <i class="fas fa-book book-logo"></i>
        <p class="buy-now-text">Hemen Satın Al</p>
        <i class="fas fa-book book-logo"></i>
    </div>
  </div>
  

  <section class="products" >
    <?php
    // MySQL bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cart";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // SQL sorgusu
    $sql = "SELECT id, product_name, detail, price, image_url FROM product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verileri kartlar şeklinde listeleyin
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . $row["image_url"] . '" alt="' . $row["product_name"] . '">';
            echo '<h3>' . $row["product_name"] . '</h3>';
            echo '<p>' . $row["detail"] . '</p>';
            echo '<p>Price: ₺' . $row["price"] . '</p>';

            // Adet girişi ve Satın Al butonu
            echo '<div class="quantity-container">';
            echo '<label for="quantity">Adet:</label>';
            echo '<input type="number" id="quantity" class="quantity-input" name="urunadet[' . $row['id'] . ']" value="1" min="1">';
            echo '</div>';
            echo '<button name="sepeteEkle" urunid="' . $row['id'] . '"  type="button" class="buy-button">Satın Al</button>';

            echo '</div>';
        }
    } else {
        echo "Hiç ürün bulunamadı.";
    }

    // Bağlantıyı kapat
    $conn->close();
    ?>
  </section>
  
  
  <?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/c463ab28df.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="script.js"></script>
<script src="main.js"></script>
</body>
</html>