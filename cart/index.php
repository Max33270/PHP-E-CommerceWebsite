<?php
require_once '../connect_bd.php';
session_start();

$BD = connect_BD();

// Check if the ID is set in the URL and retrieve the card data with the matching ID
if (isset($_GET['id'])) {
  $article_id = $_GET['id'];
  $article_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id WHERE article.Article_id = '$article_id'";
  $article_data = $BD->prepare($article_query);
  $article_data->execute();
  $article = $article_data->fetch();

  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
  }

  $article_already_in_cart = false;
  foreach ($_SESSION['panier'] as $cart_item) {
    if ($cart_item['Article_id'] == $article['Article_id']) {
      $article_already_in_cart = true;
      break;
    }
  }

  if (!$article_already_in_cart) {
    array_push($_SESSION['panier'], $article);
  }
}

// Check if the remove button was clicked and remove the corresponding card from the cart array
if (isset($_POST['del_element'])) {
  $index = $_POST['index'];
  unset($_SESSION['panier'][$index]);
  $_SESSION['panier'] = array_values($_SESSION['panier']);
}

// Check if the clear button was clicked and clear the cart array
if (isset($_POST['delete'])) {
  unset($_SESSION['panier']);
}


$total = 0;
if(isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) { 
  foreach ($_SESSION['panier'] as $index => $article) {
    $total += $article['Price'];
  }
}

$error_solde = "";
if(isset($_POST['confirm']) && $total > 0 && $total <= $_SESSION['solde']) {
  $_SESSION['price_panier'] = $total;
  $total = 0;
  header('Location: ./validate');
} else if(isset($_POST['confirm']) && $total > $_SESSION['solde']){
  $error_solde = "Solde manquant";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cart.css">
    <title>Cart</title>
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
      <li><a href="../index.php">Home</a></li>
      <li><a href="../account">Profile</a></li>
      <li><a href="../cart">Cart</a></li>
      <li><a href="../sell">Sell</a></li>
    </ul>
  </nav>
</header>
<form action="#" method="post">
  <input type="submit" name="logout" value="Logout">
</form>

<body>
  <h1>Votre panier</h1>

  <?php 
  if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) { 
    foreach ($_SESSION['panier'] as $index => $article) {
  ?>
    <div class="card">
      <p><?= $article['Name']?></p>
      <p><?= $article['Description']?></p>
      <p><?= $article['Price']?></p>
      <form action="#" method="post">
        <input type="hidden" name="index" value="<?= $index ?>">
        <button class="del_button" type="submit" name="del_element">Delete</button>
      </form>
    </div>
  <?php 
    }
  } else {
  ?>
    <div class="panier_empty">
      <p>Vous n'avez pas ajouté d'éléments au panier</p>
    </div>
  <?php
  }
  ?>
<div id="total">
  Total: <?php echo $total ?> €<br>
  <p class="error_solde">
    <?php
    if($error_solde != ""){
      echo $error_solde;
    }
    ?>
  </p>
  <div class="card-confirm">
  <form action="#" method="post" >
    <button class="del_button" type="submit" name="delete">Clear</button>
    <button class="pay_button" type="submit" name="confirm">Confirm</button>
  </form>
  </div>
</div>

</html>