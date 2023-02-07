<?php
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

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>
    <header class="header">
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="profile_page.php">Profile</a></li>
          <li><a href="cart_page.php">Cart</a></li>
        </ul>
      </nav>
    </header>
    <form action="#" method="post">
      <input type="submit" name="logout" value="Logout">
    </form>
    <h1>Welcome to your home page</h1>
  </body>
</html>