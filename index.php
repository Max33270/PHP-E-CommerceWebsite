<?php
require_once './connect_bd.php';
session_start();

// Récupération de tous les articles
$BD = connect_BD();
$cart_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id;";
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
  <body>
    <header class="header">
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="profile_page.php">Profile</a></li>
          <li><a href="cart_page.php">Cart</a></li>
          <li><a href="sell_page.php">Sell</a></li>
        </ul>
      </nav>
    </header>
    <form action="#" method="post">
      <input type="submit" name="logout" value="Logout">
    </form>
    <h1>Welcome to your home page</h1>

    <?php 
    for($i = 0; $i < count($cart); $i++) { 
    ?>
      <div class="card">
        <a href="details_page.php?id=<?=$cart[$i]['Article_id']?>">
          <h2><?=$cart[$i]['Name']?></h2>
          <p><?=$cart[$i]['Pseudo']?></p>
          <p><?=$cart[$i]['Description']?></p>
          <p><?=$cart[$i]['Price']. "€"?></p>
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