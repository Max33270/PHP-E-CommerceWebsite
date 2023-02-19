<?php
require_once '../connect_bd.php';
require_once '../uploads/upload.php';
session_start();
$BD = connect_BD();

// Récupération données entrées côté user
if(isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Price'])) {
    if(isset($_POST['submit'])) {
        upload_file();
        $image_path = $_SESSION['path_article_img'];

        $article_name = $_POST['Name'];
        $article_description = $_POST['Description'];
        $article_price = $_POST['Price'];
        $article_date = date("Y-m-d");

        $data_article = [
            "name" => $article_name,
            "description" => $article_description,
            "price" => $article_price,
            "date" => $article_date,
            "user_id" => $_SESSION['user_id'],
            "img_link" => $image_path
        ];

    // Ajout à la base de donnée
        $query_add_article = "INSERT INTO article (Name, Description, Price, Publication_date, User_id, Picture_link) VALUES (:name, :description, :price, :date, :user_id, :img_link)";
        $creation_article = $BD->prepare($query_add_article);
        $creation_article->execute($data_article);
        header("Location: ../index.php");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sell</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="../styles/sell.css">

</head>

<body>
<header class="header sticky">
  <nav>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../account">Profile</a></li>
      <li><a href="../cart">Cart</a></li>
      <li><a href="../sell">Sell</a></li>
      <?php if($_SESSION['role'] == "admin") {?>
      <li><a href="../admin">Admin</a></li>
      <?php }?>
    </ul>
  </nav>
</header>
    
    <form action="#" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload"> 
        <br> <br> <br>
        <div><input type="text" placeholder="Name" name="Name" id="name" required></input></div> <br> <br>
        <div id="description"><input type="text" placeholder="Description" name="Description" id="description"required></input></div> <br> <br>
        <!--Attention prix est un float dans la db-->
        <div><input type="text" placeholder="Price" name="Price" id="price"required></input></div> <br> <br>
        <div><button type="submit" value="Confirm" name="submit" id="submit">Confirm</button></div>

    </form>
</body>
</html>

