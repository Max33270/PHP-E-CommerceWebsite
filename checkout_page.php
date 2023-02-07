<?php
session_start();

// Check if the logout button was submitted
// test
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
    <link rel="stylesheet" href="styles/checkout.css">
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
    <h1>Welcome to your checkout page</h1>
  </body>
</html>