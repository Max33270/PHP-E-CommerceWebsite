<?php
require_once '../connect_bd.php';
session_start();

$error = "";
if(isset($_POST['Pseudo']) && isset($_POST['Mail']) && isset($_POST['Password'])) {
  $pseudo = $_POST['Pseudo'];
  $password = $_POST['Password'];
  $mail = $_POST['Mail'];

  // Hash password
  $options = [
    'cost' => 12, // coût de calcul
];
  $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

  // Connexion BD + Vérification que le user n'existe pas
  $BD = connect_BD();
  $bd_Verif = "SELECT Pseudo, Mail FROM user WHERE Pseudo = :verif_pseudo AND Mail = :verif_mail";
  $datas_verif_user = [
    'verif_pseudo' => $pseudo,
    'verif_mail' => $mail
  ];

  $verif_user = $BD->prepare($bd_Verif);
  $verif_user->execute($datas_verif_user);

  // Vérification OK = Création du user
  if($verif_user->fetch() == false){
    $datas_create_user = [
      'create_pseudo' => $pseudo,
      'create_password' => $hashed_password,
      'create_mail' => $mail,
      'role' => "user"
    ];
    $bd_Query = "INSERT INTO user (Pseudo, Password, Mail, Role) VALUES (:create_pseudo, :create_password, :create_mail, :role)";
    $recipesStatement = $BD->prepare($bd_Query);
    $recipesStatement->execute($datas_create_user);

    // Récupération données users créées
    $datas_user = [
      'user_pseudo' => $pseudo
    ];
    $bd_user = "SELECT * FROM user WHERE Pseudo = :user_pseudo";
    $recup_user = $BD->prepare($bd_user);
    $recup_user->execute($datas_user);
    $user = $recup_user->fetch();

    // Création données de session User
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['User_id'];
    $_SESSION['pseudo'] = $user['Pseudo'];
    $_SESSION['mail'] = $user['Mail'];
    $_SESSION['password'] = $user['Password'];
    $_SESSION['solde'] = $user['Solde'];
    $_SESSION['profil_picture'] = $user['Profil_picture'];
    $_SESSION['role'] = $user['Role'];
    header("Location: ../index.php");
  } else {
    $error = "Utilisateur déjà existant";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/sign_up.css">
  </head>
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
  <body>
    <div class="grid">
    <div class="register_card">
      <header class="login__header">
        <h3 class="login__title">Sign up</h3>
      </header>
      <form action="" method="post" class="form login" id="form-login">
        <div class="login__body">
          <div class="form__field">
            <input id="pseudo" type="text" placeholder="Pseudo" name="Pseudo" required> 
          </div>
          <div class="form__field">
            <input id="mail" type="mail" placeholder="Mail" name="Mail" required>
          </div>
          <div class="form__field">
            <input id="password" type="password" placeholder="Password" name="Password" required>
          </div>
        </div>
          <input type="submit" value="Sign up" class="register_button">
      </form>
      <a href="../login" class="loginacc">Log in</a>
        <div><?php if ($error != "") {
          echo $error;} ?>
        </div>
      </div>
    </div>
  </body>
</html>