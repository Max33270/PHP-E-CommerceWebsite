<?php
require_once '../../connect_bd.php';
session_start();
$BD = connect_BD();

if(isset($_POST['address']) && isset($_POST['city']) && isset($_POST['postal'])) {
    $_SESSION['solde'] = $_SESSION['solde'] - $_SESSION['price_panier'];
    $query_solde = "UPDATE user SET Solde = ? WHERE User_id = ?";
    $solde_update = $BD->prepare($query_solde);
    $solde_update->bindValue(1, $_SESSION['solde'], PDO::PARAM_INT);
    $solde_update->bindValue(2, $_SESSION['user_id'], PDO::PARAM_INT);
    $solde_update->execute();

    $user_id = $_SESSION['user_id'];
    $transaction_date = date("Y-m-d");
    $amount = $_SESSION['price_panier'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];

    $data = [
        "id" => $user_id,
        "date" => $transaction_date,
        "amount" => $amount,
        "address" => $address,
        "city" => $city,
        "postal" => $postal
    ];

    $invoice_query = "INSERT INTO invoice (User_id, Transaction_date, Amount, Billing_address, Billing_city, Billing_postal) VALUES (:id, :date, :amount, :address, :city, :postal)";
    $invoice = $BD->prepare($invoice_query);
    $invoice->execute($data);
    unset($_SESSION['panier']);
    header('Location: ../../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/cart_validate.css">
    <title>Validate</title>
</head>
<header>
    <nav>
        <ul>
          <li><a href="../../index.php">Home</a></li>
          <li><a href="../../cart">Cart</a></li>
          <li><a href="../../account">Profile</a></li>
          <li><a href="../../sell">Sell</a></li>
        </ul>
    </nav>
</header>

<body>
    <form action="#" method="post">
        <div><input type="text" placeholder="Address.." class="address" required></input></div>
        <div><input type="text" placeholder="City.." class="city" required></input></div>
        <div><input type="text" placeholder="Code postal.." class="postal" required></input></div>
        <div><input type="submit" value="Confirm" class="validate_cart"></div>
    </form>
</body>
</html>





  