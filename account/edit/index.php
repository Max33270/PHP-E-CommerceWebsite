<?php
require_once '../../connect_bd.php';
session_start();
$BD = connect_BD();

if(isset($_POST['confirm-info'])) {
  if($_POST['new-pseudo'] != "") {
    $_SESSION['pseudo'] = $_POST['new-pseudo'];
    $new_pseudo = $_SESSION['pseudo'];
    $new_pseudo_query = "UPDATE user SET Pseudo = ? WHERE User_id = ?";
    $pseudo = $BD->prepare($new_pseudo_query);
    $pseudo->execute([$new_pseudo, $_SESSION['user_id']]);
  }
  if($_POST['password'] != "" && $_POST['new-password'] != "" && $_POST['password'] == $_POST['new-password']) {
    $new_password = $_POST['password'];
    // Hash password
    $options = [
      'cost' => 12, // coût de calcul
    ];

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, $options);

    $new_password_query = "UPDATE user SET Password = ? WHERE User_id = ?";
    $password = $BD->prepare($new_password_query);
    $password->execute([$hashed_password, $_SESSION['user_id']]);
  }
  header('Location: ../../account');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/edit.css">
    <title>Edit</title>
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
      <li><a href="../../index.php">Home</a></li>
      <li><a href="../../account/">Profile</a></li>
      <li><a href="../../cart/">Cart</a></li>
      <li><a href="../../sell/">Sell</a></li>
      <?php if($_SESSION['role'] == "admin") {?>
      <li><a href="../../admin">Admin</a></li>
      <?php }?>
    </ul>
  </nav>
</header>

<body>
    <div class="user-info">
        <form action="#" method="post">
            <input type="text" placeholder="Pseudo" name="new-pseudo">
            <br>
            <input type="text" placeholder="Password" name="password">
            <br>
            <input type="text" placeholder="New password" name="new-password">
            <br>
            <button type="submit" name="confirm-info">Confirm</button>
        </form>
    </div>
</body>
</html>