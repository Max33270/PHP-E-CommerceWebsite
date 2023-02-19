<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/user-edit.css">
    <title>User-edit</title>
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
      <li><a href="../admin">Admin</a></li>
      <?php }?>
    </ul>
  </nav>
</header>

<body>
    <div class="user-info">
        <form action="#" method="post">
            <input type="text" placeholder="Pseudo" name="new-pseudo">
            <input type="text" placeholder="Role" name="new-role">
        </form>
    </div>
</body>
</html>