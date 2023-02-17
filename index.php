<?php
require_once './connect_bd.php';
session_start();

// Récupération de tous les articles
$BD = connect_BD();
$cart_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id ORDER BY Publication_date DESC;";
$cart_data = $BD->prepare($cart_query);
$cart_data->execute();
$cart = $cart_data->fetchAll();

// Check si le bouton logout est pressé
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: login_page.php');
  exit;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style.css">
  </head>

  <script>
    // Sélectionnez la navbar
    const navbar = document.querySelector('.header');

    // Récupérez la position de défilement de la page
    const offsetTop = navbar.offsetTop;

    // Ajoutez une classe "sticky" à la navbar lorsque vous faites défiler vers le bas
    function stickyNavbar() {
      if (window.pageYOffset >= offsetTop) {
        navbar.classList.add("sticky");
      } else {
        navbar.classList.remove("sticky");
      }
    }

    // Écoutez l'événement de défilement de la page et appelez la fonction stickyNavbar()
    window.onscroll = function() {stickyNavbar()};
  </script>

  
    <header class="header sticky">
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="profile_page.php">Profile</a></li>
          <li><a href="cart_page.php">Cart</a></li>
          <li><a href="sell_page.php">Sell</a></li>
          <li>
          <form action="#" method="post">
            <input type="submit" name="logout" value="Logout">
          </form>
          </li>
        </ul>
      </nav>
    </header>

    <body>
    <h1>Welcome to your home page</h1>

    <?php 
    for($i = 0; $i < count($cart); $i++) { 
    ?>
      <div class="card">
        <a href="details_page.php?id=<?=$cart[$i]['Article_id']?>">
          <h2><?=$cart[$i]['Name']?></h2>
          <p><?=$cart[$i]['Description']?></p>
          <p><?=$cart[$i]['Price']. "€"?></p>
        </a>
        <a href="profile_page.php?id=<?=$cart[$i]['User_id']?>">
          <p><?=$cart[$i]['Pseudo']?></p>
        </a>
      </div>
    <?php
      if (($i + 1) % 3 == 0) {
        ?>
        <div class="clearfix"></div>
        <?php
      }
    }; 
  ?>
  </body>
</html>