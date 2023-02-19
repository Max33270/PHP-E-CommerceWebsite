<?php
require_once '../connect_bd.php';
session_start();

$BD = connect_BD();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
  // Retrieve the card data with the matching ID
  $card_id = $_GET['id'];
  $card_query = "SELECT * FROM article JOIN user ON article.User_id = user.User_id WHERE article.Article_id = '$card_id'";
  $card_data = $BD->prepare($card_query);
  $card_data->execute();
  $card = $card_data->fetch();
} else {
  // Redirect to the cart page if the ID is not set
  header('Location: ../cart');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>
    <h1>Card Details</h1>
    <div class="card">
      <h2><?= $card['Name']?></h2>
      <p><?= $card['Pseudo']?></p>
      <p><?= $card['Description']?></p>
      <p><?= $card['Price']. "€"?></p>
      <form action="../cart" method="get">
        <input type="hidden" name="id" value="<?= $card['Article_id']; ?>">
        <button type="submit">Ajouter au panier</button>
      </form>
    </div>
</body>
</html>