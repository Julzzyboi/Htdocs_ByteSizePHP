<?php
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paymentMethod = $_POST['payment'] ?? 'Cash';
    $deliveryMode = $_POST['delivery'] ?? 'Pick-up';
    $address = $deliveryMode === 'Delivery' ? trim($_POST['address'] ?? '') : 'N/A';
    $totalAmount = $_POST['totalAmount'] ?? '₱0.00';

    if ($deliveryMode === 'Delivery' && $address === '') {
        $error = "Please enter a delivery address.";
    } else {
        // Save order details to session (or database)
        $_SESSION['orderDetails'] = [
            'paymentMethod' => $paymentMethod,
            'deliveryMode' => $deliveryMode,
            'address' => $address,
            'totalAmount' => $totalAmount
        ];

        // Redirect to receipt page
        header("Location: receipt.php");
        exit();
    }
}

// Fetch amount from session (assumed stored earlier in shopping cart step)
$totalAmount = $_SESSION['totalAmount'] ?? 0.00;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transaction</title>
  <link rel="stylesheet" href="transaction.css" />
  <style>.hidden { display: none; }</style>
</head>
<body>

<div class="modal-overlay active" id="checkoutModal">
  <section class="checkoutContainer">
    <h1>CHECKOUT</h1>
    <h3>Order Details:</h3>

    <?php if (!empty($error)): ?>
      <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="amount">
      <p>Total Amount to Pay: <span id="amountDisplay">₱<?php echo number_format($totalAmount, 2); ?></span></p>
    </div>

    <form method="POST" action="transaction.php">
      <input type="hidden" name="totalAmount" value="<?php echo number_format($totalAmount, 2); ?>">

      <div class="paymentBoxGroup">
        <label for="payment">Payment Methods</label>
        <select id="payment" name="payment">
          <option value="Cash">Cash</option>
          <option value="E-Payment">E-Payment</option>
        </select>
      </div>

      <div class="paymentBoxGroup">
        <label for="delivery">Mode of Delivery</label>
        <select id="delivery" name="delivery">
          <option value="Pick-up">Pick-up</option>
          <option value="Delivery">Delivery</option>
        </select>
      </div>

      <div class="paymentBoxGroup" id="addressGroup">
        <label for="address">Delivery Address</label>
        <input type="text" id="address" name="address" placeholder="UST" />
      </div>

      <a href="Product.php" class="backtoCartbtn">Back to Cart</a>
      <button type="submit" class="confirmButton">Confirm</button>
    </form>
  </section>
</div>

<script>
  const deliverySelect = document.getElementById("delivery");
  const addressGroup = document.getElementById("addressGroup");
  const addressInput = document.getElementById("address");

  deliverySelect.addEventListener("change", () => {
    if (deliverySelect.value === "Delivery") {
      addressGroup.style.display = "block";
    } else {
      addressGroup.style.display = "none";
      addressInput.value = "";
    }
  });

  // Initial visibility check
  if (deliverySelect.value === "Pick-up") {
    addressGroup.style.display = "none";
  }
</script>

</body>
</html>
