<?php
require_once '../connect_bd.php';
session_start();
$BD = connect_BD();

// Récupération données entrées côté user
if(isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Price'])) {
    $article_name = $_POST['Name'];
    $article_description = $_POST['Description'];
    $article_price = $_POST['Price'];
    $article_date = date("Y-m-d");

    $data_article = [
        "name" => $article_name,
        "description" => $article_description,
        "price" => $article_price,
        "date" => $article_date,
        "user_id" => $_SESSION['user_id']
    ];

// Ajout à la base de donnée
    $query_add_article = "INSERT INTO article (Name, Description, Price, Publication_date, User_id) VALUES (:name, :description, :price, :date, :user_id)";
    $creation_article = $BD->prepare($query_add_article);
    $creation_article->execute($data_article);
    header("Location: ../index.php");
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

<style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
    header {
  background-color: white;
  color: #fff;
  box-shadow: 0px 3px 0px -2px black;
  padding: 15px 0;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin: 0;
  padding: 0 30px;
}

nav ul {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
}

nav ul li a {
  color: black;
  text-decoration: none;
  padding: 0 20px;
  transition: background-color 0.2s ease-in-out;
}

nav ul li a:hover {
  background-color: green;
  color: white;
}

form {
    display: inline-block;
    width: 40%;
}
input[type="submit"] {
  width: 120px;
  background-color: green;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  padding: 10px;
  position: absolute;
  top: 5px;
  right: 10px;
  transition: background-color 0.2s ease-in-out;
}

input[type="submit"]:hover {
  background-color: #006400;
}
h1 {
    text-align: center;
    margin-top: 100px;
}


#description input[type="text"]{
    width: 100%;
    height: 150px;
}


</style>

<body>
    <header>
      <nav>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../cart">Cart</a></li>
          <li><a href="../account">Profile</a></li>
          <li><a href="../sell">Sell</a></li>
        </ul>
      </nav>
    </header>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png, .gif">
        </div>
    </form>
    <script>
        document.getElementById("fileToUpload").onchange = function () {
            var reader = new FileReader();

            reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
            document.getElementById("preview").style.display = "block";
            };

            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        };
    </script>
    
    <form action="" method="post">
        <div><input type="text" placeholder="Name" name="Name" required></input></div>
        <div id="description"><input type="text" placeholder="Description" name="Description" required></input></div>
        <!--Attention prix est un float dans la db-->
        <div><input type="text" placeholder="Price" name="Price" required></input></div>
        <div><input type="submit" value="Confirm"></div>
    </form>
</body>
</html>

