<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>
</head>
<body>
<footer class="footer">
      <div class="container text-center">
          <p>&copy; 2023 E-Kitapçım - Copyright <span id="year"></span> Zeki Akkan. Tüm hakları saklıdır.</p>
      </div>
  </footer>
  <script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
  </script>


</body>
</html>