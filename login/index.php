<?php
require_once '../connect_bd.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  header('Location: ../index.php');
  exit;
}

$error = "";
if (isset($_POST['Pseudo']) && isset($_POST['Password'])) {
  $pseudo = $_POST['Pseudo'];
  $password = $_POST['Password'];
  $BD = connect_BD();

  // Vérifie qu'il existe un utilisateur avec ce pseudo/mdp
  $bd_Query = "SELECT * FROM user WHERE Pseudo = :pseudo";
  $datas = [
    'pseudo' => $pseudo,
  ];
  $recipesStatement = $BD->prepare($bd_Query);
  $recipesStatement->execute($datas);
  $valid_user = $recipesStatement->fetch();

  // Se login
  if ($valid_user && password_verify($password, $valid_user['Password'])) {
    
    // Création données de session User
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $valid_user['User_id'];
    $_SESSION['pseudo'] = $valid_user['Pseudo'];
    $_SESSION['mail'] = $valid_user['Mail'];
    $_SESSION['password'] = $valid_user['Password'];
    $_SESSION['solde'] = $valid_user['Solde'];
    $_SESSION['profil_picture'] = $valid_user['Profil_picture'];
    $_SESSION['role'] = $valid_user['Role'];
    header("Location: ../index.php");
    exit;
  } else {
    $error = "Pseudo ou mot de passe incorrect";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/login.css">
  </head>
<body>
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
  <div class="grid">
  <div class="login_card">
    <header class="login__header">
      <h3 class="login__title">Login</h3>
      </header>
      <form action="" method="post" class="form login" id="form-login">
        <div class="login__body">
          <div class="form__field">
            <input id="pseudo" type="text" placeholder="Pseudo" name="Pseudo" required> 
          </div>
          <div class="form__field">
            <input id="password" type="password" placeholder="Password" name="Password" required>
          </div>
        </div>
        <input type="submit" value="Login" class="login_button">
      </form>
      <a href="../register" class="registeracc">Sign up</a>
      <div><?php if ($error != "") {
        echo $error;
      } ?>
    </div>
    </div>
  </div>
  </body>
</html>