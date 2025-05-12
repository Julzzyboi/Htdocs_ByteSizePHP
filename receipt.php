<?php
session_start();
require 'Db_connection.php'; 

//Getting the order from products page
$orderId = $_SESSION['order_id'] ?? null;
if (!$orderId) {
    header("Location: Product.html");
    exit();
}

// Order details
$stmt = $conn->prepare("SELECT total_amount, payment_method, address, created_at FROM orders WHERE id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Order not found!";
    exit();
}

// Reference number (kung need pa?)
$refNumber = $_SESSION['receipt_ref'] ?? "REF" . rand(100000, 999999);
$_SESSION['receipt_ref'] = $refNumber;
$_SESSION['receipt_time'] = $order['created_at'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receipt</title>
  <link rel="stylesheet" href="receipt.css" />
</head>
<body>

<div class="modal-overlay active" id="receiptModal">
  <section class="receiptContainer">
    <div class="receiptCard">
      <img src="images/checkbg.png" alt="Success" class="successIcon" />
      <h1>PAYMENT SUCCESS!</h1>
      <h2>ByteSize Delights</h2>

      <div class="info">
        <div class="info-row">
          <p><strong>TOTAL PAYMENT</strong></p>
          <span><?= htmlspecialchars($order['total_amount']) ?></span>
        </div>
        <div class="info-row">
          <p><strong>REF. NUMBER</strong></p>
          <span><?= $refNumber ?></span>
        </div>
        <div class="info-row">
          <p><strong>PAYMENT TIME</strong></p>
          <span><?= htmlspecialchars($order['created_at']) ?></span>
        </div>
        <div class="info-row">
          <p><strong>PAYMENT METHOD</strong></p>
          <span><?= htmlspecialchars($order['payment_method']) ?></span>
        </div>
        <div class="info-row">
          <p><strong>DELIVERY ADDRESS</strong></p>
          <span><?= htmlspecialchars($order['address']) ?></span>
        </div>
      </div>

      <p id="countdownText">Redirecting in 4 seconds...</p>
    </div>
  </section>
</div>

<script>
  let seconds = 4;
  const countdownText = document.getElementById("countdownText");

  const interval = setInterval(() => {
    seconds--;
    countdownText.textContent = `Redirecting in ${seconds} second${seconds !== 1 ? "s" : ""}...`;
    if (seconds <= 0) {
      clearInterval(interval);
      window.location.href = "Product.html";
    }
  }, 1000);
</script>

</body>
</html>
