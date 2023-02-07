<?php
require_once './connect_bd.php';
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/sell.css">
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="cart_page.php">Cart</a></li>
          <li><a href="profile_page.php">Profile</a></li>
          <li><a href="sell_page.php">Sell</a></li>
        </ul>
      </nav>
    </header>
    <form action="" method="post">
      <input type="text" placeholder="Name" name="Name"></input>
    </form>
  </body>
</html>