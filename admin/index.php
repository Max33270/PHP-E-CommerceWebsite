<?php
require_once '../connect_bd.php';
session_start();
$BD = connect_BD();

// Récupération de tous les users
$show_user = true;
$user_list_query = "SELECT * FROM user";
$user_list = $BD->prepare($user_list_query);
$user_list->execute();
$user = $user_list->fetchAll();

// Récupération de tous les users
if(isset($_POST['show-articles'])){
  $show_user = false;
  $cart_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id ORDER BY Publication_date DESC;";
  $cart_data = $BD->prepare($cart_query);
  $cart_data->execute();
  $cart = $cart_data->fetchAll();
}

if(isset($_POST['show-users'])){
  $show_user = true;
}

if(isset($_POST['delete-user'])){
  $user_id = $_POST['delete-user'];
  $user_delete_query = "DELETE FROM user WHERE User_id = $user_id";
  $user_delete = $BD->prepare($user_delete_query);
  $user_delete->execute();

  $user_delete_article_query = "DELETE FROM article WHERE User_id = $user_id";
  $user_delete_article = $BD->prepare($user_delete_article_query);
  $user_delete_article->execute();

  $user_delete_invoice_query = "DELETE FROM invoice WHERE User_id = $user_id";
  $user_delete_invoice = $BD->prepare($user_delete_invoice_query);
  $user_delete_invoice->execute();
  header('Location: ../admin');
}

$modif_user = false;
if(isset($_POST['modif-user'])) {
  $modif_user = true;
}

if(isset($_POST['confirm-modif-user'])) {
  $modif_user = false;
  $user_id = $_POST['modif-user'];
  $new_pseudo = $_POST['new-pseudo'];
  $new_role = $_POST['new-role'];

  if($new_pseudo != "") {
    $query_modif = "UPDATE user SET Pseudo = ? WHERE User_id = ?";
    $modif = $BD->prepare($query_modif);
    $modif->bindValue(1, $new_pseudo, PDO::PARAM_STR);
    $modif->bindValue(2, $user_id, PDO::PARAM_INT);
    $modif->execute();
  }
  if($new_role != "") {
  $query_modif = "UPDATE user SET Role = ? WHERE User_id = ?";
  $modif = $BD->prepare($query_modif);
  $modif->bindValue(1, $new_role, PDO::PARAM_STR);
  $modif->bindValue(2, $user_id, PDO::PARAM_INT);
  $modif->execute();
  }
  header('Location: ../admin');
}

if(isset($_POST['delete-article'])){
  $article_id = $_POST['delete-article'];
  $delete_article_query = "DELETE FROM article WHERE Article_id = $article_id";
  $delete_article = $BD->prepare($delete_article_query);
  $delete_article->execute();
  header('Location: ../admin');
}

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
  <div class="options">
    <form action="#" method="post">
      <button type="submit" name="show-users">Users</button>
      <button type="submit" name="show-articles">Articles</button>
    </form>
  </div>
  <?php 
  if($show_user == true) {
    for($i = 0; $i < count($user); $i++) {
      $img_user = $user[$i]['Profil_picture'];
  ?>
    <div class="card">
      <?php if($user[$i]['Profil_picture'] != "") {?>
      <img src="<?= $img_user?>" alt="photo article">
      <?php } ?>
      <p><?= $user[$i]['Role'] . " / " . $user[$i]['Pseudo'] . " / " . $user[$i]['Mail'] ?></p>
      <form action="#" method="post">
        <button type="submit" name="modif-user" value="<?= $user[$i]['User_id'] ?>">Modifier</button>
        <button type="submit" name="delete-user" value="<?= $user[$i]['User_id'] ?>">Supprimer</button>
        <?php if($modif_user == true){?>
          <input type="text" placeholder="Pseudo" name="new-pseudo">
          <input type="text" placeholder="Role" name="new-role">
          <button type="input" name="confirm-modif-user">Confirm</button>
        <?php }?>
      </form>
    </div>

  <?php } } else {
    for($i = 0; $i < count($cart); $i++) {
      $img_article = $cart[$i]['Picture_link'];
  ?>  
    <div class="card-article">
      <?php if($cart[$i]['Picture_link'] != "") {?>
      <img src="<?= $img_article?>" alt="photo article">
      <?php } ?>
      <p><?= $cart[$i]['Name'] . " " . $cart[$i]['Price'] . "€ "?></p>
      <form action="#" method="post">
        <button type="submit" name="modif-article" value="<?= $cart[$i]['Article_id'] ?>">Modifier</button>
        <button type="submit" name="delete-article" value="<?= $cart[$i]['Article_id'] ?>">Supprimer</button>
      </form>
    </div>
  <?php
  }}
  ?>
</body>
</html>