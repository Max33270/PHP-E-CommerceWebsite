<?php
require_once '../connect_bd.php';
session_start();
$BD = connect_BD();

// Check if the logout button was submitted
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: ../login');
  exit;
}

$user_found = null;

// recherche par article
if (isset($_GET['id'])) {
  $user_found = "user by article";
  $user_article_id = $_GET['id'];
  $search_user_article_query = "SELECT * FROM user WHERE User_id = ?";
  $search_user_article = $BD->prepare($search_user_article_query);
  $search_user_article->execute([$user_article_id]);
  $user_by_article = $search_user_article->fetch();

  $user_search_query = "SELECT * FROM article WHERE User_id = ?";
  $user_search_article = $BD->prepare($user_search_query);
  $user_search_article->execute([$user_by_article['User_id']]);
  $article = $user_search_article->fetchAll();
}

// Recherche par search bar
if (isset($_POST['search']) && $_POST['search'] != $_SESSION['pseudo']) {
  $contenu = $_POST['search'];
  $user_search_query = "SELECT * FROM user WHERE Pseudo = ?";
  $user_search = $BD->prepare($user_search_query);
  $user_search->execute([$contenu]);

  if ($user_search->rowCount() > 0) {
    $user_found = $user_search->fetch();
    $article_user_search_query = "SELECT * FROM article WHERE User_id = ?";
    $article_data_user_found = $BD->prepare($article_user_search_query);
    $article_data_user_found->execute([$user_found['User_id']]);
    $article = $article_data_user_found->fetchAll();
  }
}

// articles de l'utilisateur connecté
if($user_found == null) {
  $user_log_query = "SELECT * FROM article WHERE User_id = ?";
  $user_log_article = $BD->prepare($user_log_query);
  $user_log_article->execute([$_SESSION['user_id']]);
  $article = $user_log_article->fetchAll();

  $user_log_invoice_query = "SELECT * FROM invoice WHERE User_id = ?";
  $user_log_invoice = $BD->prepare($user_log_invoice_query);
  $user_log_invoice->execute([$_SESSION['user_id']]);
  $invoice = $user_log_invoice->fetchAll();
}

$edit_solde = false;
if(isset($_POST['edit-solde'])) {
  $edit_solde = true;
}

if (isset($_POST['modifier-solde'])) {
  $nouveauSolde = $_POST['nouveau-solde'];
  $_SESSION['solde'] = $nouveauSolde;
  $solde_query = "UPDATE user SET Solde = $nouveauSolde WHERE User_id = ?";
  $solde_update = $BD->prepare($solde_query);
  $solde_update->execute([$_SESSION['user_id']]);
  $edit_solde = false;
  // Faire quelque chose avec le nouveau solde...
}

if(isset($_POST['edit-info'])) {
  header('Location: ./edit');
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../styles/profile.css">
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
      <li><a href="../admin">Admin</a></li>
      <?php }?>
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
    <form action="#" method="post">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <h2>Vos informations :</h2>
  <div class="card">
    <?= $_SESSION['profil_picture'] ?><br>
    <b>Pseudo: </b> <?=$_SESSION['pseudo'] ?><br>
    <p><?php echo $user_found;?></p>
  </div>
  
  <form action="#" method="post">
    <?php if($edit_solde == false) { ?>
      <button type="submit" name="edit-solde" class="edit-card">
        <p class="title"><b>Solde: </b> <?=$_SESSION['solde'] . "€"?></p>
      </button>
    <?php } else { ?>
      <div class="edit-card">
        <input type="text" name="nouveau-solde" placeholder="Entrez le nouveau solde">
        <br>
        <button type="submit" name="modifier-solde" class="confirm-solde">Valider</button>
    </div>
    <?php } ?>
  <form>

  <form action="#" method="post">
    <button type="submit" name="edit-info" class="edit-card">
      <p class="title">Edit profil</p>
      <p>Ajout et modification des informations du profil</p>
    </button>
  </form>
  <div class="article-cards">
    <p class="title">Vos articles :</p>
    <?php 
      for($i = 0; $i < count($article); $i++) { 
    ?>
      <div class="card">
        <?php if($article[$i]['Picture_link'] != "") {?>
        <img src="<?php echo $article[$i]['Picture_link'];?>" alt="photo article">
        <?php } ?>
        <p><?=$article[$i]['Name']?></p>
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
  </div>
  <div class="invoice-cards">
      <p class="title">Vos factures :</p>
      <?php
      for($j = 0; $j < count($invoice); $j++){
      ?>
        <div class="card">
          <p><?=$invoice[$j]['Transaction_date'] . " / " . $invoice[$j]['Billing_address'] . " " . $invoice[$j]['Billing_city'] . " " . $invoice[$j]['Billing_postal'] . " / " . $invoice[$j]['Amount']. "€"?></p>
        </div>
      <?php
      }
      ?>
  </div>
  <?php
  } else if($user_found == "user by article") {
  ?>
  <h1>
    <form action="#" method="post">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <h2>Ses informations :</h2>
  <div class="card">
    <p><?php echo $user_by_article['Pseudo']; ?></p>
    <p><?php echo $user_by_article['Mail'] ?></p>
  </div>
  <br>
  <br>
  <br>
  <div class="article-cards">
  <p class="title">Ses articles :</p>
  <?php 
    for($i = 0; $i < count($article); $i++) { 
  ?>
  <div class="card">
    <p><?= $article[$i]['Name'] ?></p>
    <p><?= $article[$i]['Description'] ?></p>
    <p><?= $article[$i]['Price'] . "€" ?></p>
  </div>
  <?php
    if (($i + 1) % 3 == 0) {
  ?>
    <div class="clearfix"></div>
  <?php
      }
    }; 
  ?>
  </div>
  <?php
   } else {
    if($user_found['User_id'] != $_SESSION['user_id']) {
  ?>
  <h1>
    <form action="#" method="post">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </h1>
  <h2>Ses informations :</h2>
  <div class="card">
    <?php echo $user_found['Pseudo'] . " " . $user_found['Mail'] ?>
  </div>
  <br>
  <br>
  <br>
  <div class="article-cards">
  <p class="title">Ses articles :</p>
  <?php 
    for($i = 0; $i < count($article); $i++) { 
  ?>
    <div class="card">
      <p><?=$article[$i]['Name']?></p>
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
  </div>
  <?php
    } 
  }
  ?>

</body>
</html>