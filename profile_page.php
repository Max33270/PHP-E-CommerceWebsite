<?php
require_once './connect_bd.php';
session_start();
$BD = connect_BD();

// Check if the logout button was submitted
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: login_page.php');
  exit;
}

$user_found = null;
// recherche par pseudo sur l'article
if (isset($_GET['id'])) {
  $user_found = "user by article";
  $searchUser_id = $_GET['id'];
  $search_query = "SELECT * FROM user WHERE User_id = ?";
  $search_data = $BD->prepare($search_query);
  $search_data->execute([$searchUser_id]);
  $user_search = $search_data->fetch();

  $user_search_query = "SELECT * FROM article WHERE User_id = ?";
  $user_search_article = $BD->prepare($user_search_query);
  $user_search_article->execute([$user_search['User_id']]);
  $article = $user_search_article->fetchAll();
}

// Recherche par search bar
$error_search = "";
if (isset($_POST['search'])) {
  $contenu = $_POST['search'];
  $user_query = "SELECT * FROM user WHERE Pseudo = '$contenu'";
  $user_data = $BD->prepare($user_query);
  $user_data->execute();

  if ($user_data->rowCount() > 0) {
    $user_found = $user_data->fetch();
    $article_user_search_query = "SELECT * FROM article WHERE User_id = ?";
    $article_data_user_found = $BD->prepare($article_user_search_query);
    $article_data_user_found->execute([$user_found['User_id']]);
    $article = $article_data_user_found->fetchAll();
  } else {
    $error_search = "Utilisateur inexistant";
  }
}

// articles de l'utilisateur connecté
if($user_found == null) {
  $user_log_query = "SELECT * FROM article WHERE User_id = ?";
  $user_log_article = $BD->prepare($user_log_query);
  $user_log_article->execute([$_SESSION['user_id']]);
  $article = $user_log_article->fetchAll();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="styles/profile.css">
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
    </ul>
  </nav>
</header>

<form action="#" method="post">
  <input type="submit" name="logout" value="Logout">
</form>

<body>
  <?php
    if ($user_found == null) {
  ?>
  <h1>
    <form action="profile_page.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <div class="card">
    <?= $_SESSION['profil_picture'] ?><br>
    <b>Pseudo: </b> <?=$_SESSION['pseudo'] ?><br>
  </div>
  
  <div class="card">
    <p class="title"><b>Solde: </b> <?=$_SESSION['solde'] . "€"?></p>
  </div>
  
  <div class="card">
    <p class="title">Edit profil</p>
    <p>Ajout et modification des informations du profil</p>
  </div>
  <?php 
    for($i = 0; $i < count($article); $i++) { 
  ?>
    <div class="card">
      <h2><?=$article[$i]['Name']?></h2>
      <p><?=$article[$i]['Description']?></p>
      <p><?=$article[$i]['Price']. "€"?></p>
    </div>
  <?php
    if (($i + 1) % 3 == 0) {
  ?>
    <div class="clearfix"></div>
  <?php
      }
    }; 
  ?>
  <?php
  } else if($user_found == "user by article"){
  ?>
  <h1>
    <form action="profile_page.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <div class="card">
    <?= $user_search['Pseudo']; ?>
    <?= $user_search['Mail']; ?>
  </div>
  <?php 
    for($i = 0; $i < count($article); $i++) { 
  ?>
    <div class="card">
      <h2><?=$article[$i]['Name']?></h2>
      <p><?=$article[$i]['Description']?></p>
      <p><?=$article[$i]['Price']. "€"?></p>
    </div>
  <?php
    if (($i + 1) % 3 == 0) {
  ?>
    <div class="clearfix"></div>
  <?php
      }
    }; 
    } else {
  ?>
  <h1>
    <form action="profile_page.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <div class="card">
    <?= $user_found['Pseudo']; ?>
    <?= $user_found['Mail']; ?>
  </div>
  <?php 
    for($i = 0; $i < count($article); $i++) { 
  ?>
    <div class="card">
      <h2><?=$article[$i]['Name']?></h2>
      <p><?=$article[$i]['Description']?></p>
      <p><?=$article[$i]['Price']. "€"?></p>
    </div>
  <?php
    if (($i + 1) % 3 == 0) {
  ?>
    <div class="clearfix"></div>
  <?php
      }
    }; 
  ?>
  <?php
    }
  ?>
</body>
</html>