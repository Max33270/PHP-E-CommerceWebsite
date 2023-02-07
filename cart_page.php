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
  <link rel="stylesheet" href="styles/cart.css">
</head>
<body>
  <header class="header">
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="profile_page.php">Profile</a></li>
        <li><a href="cart_page.php">Cart</a></li>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <input type="submit" name="logout" value="Logout">
        </form>
      </ul>
    </nav>
  </header>
  <form action="#" method="post">
    <input type="submit" name="logout" value="Logout">
  </form>
  <h1>Shopping Cart</h1>
  <div class="container">
    <input type="checkbox">
    <img src="pics/taco.jpeg" alt="Product Image">
    <div class="details">
      <h3 class="title">Taco Dinosaur</h3>
      <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
        molestiae quas vel sint commodi repudiandae consequunt...
      <div class="quantity">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" value="1" min="1">
      </div>
      <div class="discount">
        <label for="discount">Discount Code:</label> &#160 &#160
        <input type="text" id="discount" placeholder="Enter code here">
      </div>
      <p class="price">Price: $<span id="price"></span></p>
      <button class="delete-btn">Delete</button>
    </div>
  </div>
  <input id="quantity-input" type="number" style="display: none" />
  </div>
  </div>
  <a href="checkout_page.php" class="checkout">Proceed to checkout</a>
  <h2> Subtotal (1 item): $10 </h2>
  <p class="discount-subtotal"> Discounts : 3% off </p>
  <script>
    const quantityInput = document.getElementById("quantity");
    const priceSpan = document.getElementById("price");
    const itemPrice = 10;
    quantityInput.addEventListener("input", function () {
      const quantity = this.value;
      const price = itemPrice * quantity;
      priceSpan.textContent = price;
    });
    function updateQuantityField() {
      let quantityDropdown = document.getElementById("quantity-dropdown");
      let selectedValue = quantityDropdown.value;
      let quantityInput = document.getElementById("quantity-input");
      if (selectedValue === "10+") {
        quantityInput.style.display = "inline-block";
        quantityDropdown.style.display = "none";
      } else {
        quantityInput.style.display = "none";
        quantityDropdown.style.display = "inline-block";
      }
    }
    document.querySelector('.delete-btn').addEventListener('click', function () {
      this.parentNode.parentNode.remove();
    });
  </script>
</body>
</html>