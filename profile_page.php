<?php
require_once './connect_bd.php';
session_start();

// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//   header('Location: login_page.php');
//   exit;
// }

// Check if the logout button was submitted
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: login_page.php');
  exit;
}

// Recherche search bar
function searchUser()
{
  $BD = connect_BD();
  $user_found = null;
  if (isset($_POST['search'])) {
    $contenu = $_POST['search'];
    $user_query = "SELECT * FROM user WHERE Pseudo = '$contenu'";
    $user_data = $BD->prepare($user_query);
    $user_data->execute();

    if ($user_data->rowCount() > 0) {
      $user_found = $user_data->fetch();
    }

    if ($user_found == null) {
      echo '
      <h1>
        <form action="profile_page.php" method="post">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </h1>
      <div class="card">
        ' . $_SESSION['profil_picture'] . '<br>
        <b>Pseudo: </b>' . $_SESSION['pseudo'] . '<br>
      </div>
      
      <div class="card">
        <p class="title"><b>Solde: </b>' . $_SESSION['solde'] . '€</p>
      </div>
      
      <div class="card">
        <p class="title">Edit profil</p>
        <p>Ajout et modification des informations du profil</p>
      </div>
      ';
    } else {
      echo '
      <h1>Bonjour</h1>
      <h1>
        <form action="profile_page.php" method="post">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </h1>
      ';
    }
    $user_found = null;
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="styles/profile.css">
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

<div><?php echo searchUser(); ?></div>

</body>
</html>
   
