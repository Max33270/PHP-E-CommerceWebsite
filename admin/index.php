<?php
require_once '../connect_bd.php';
session_start();

// Récupération de tous les articles
$BD = connect_BD();
$user_list_query = "SELECT * FROM user";
$user_list = $BD->prepare($user_list_query);
$user_list->execute();
$user = $user_list->fetchAll();

$cart_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id ORDER BY Publication_date DESC;";
$cart_data = $BD->prepare($cart_query);
$cart_data->execute();
$cart = $cart_data->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admin.css">
    <title>Admin</title>
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
      <li><a href="../account/">Profile</a></li>
      <li><a href="../cart/">Cart</a></li>
      <li><a href="../sell/">Sell</a></li>
      <?php if($_SESSION['role'] == "admin") {?>
      <li><a href="./admin">Admin</a></li>
      <?php }?>
    </ul>
  </nav>
</header>

<body>
  
    
</body>
</html>