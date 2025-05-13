<?php
session_start();
require_once 'Db_connection.php'; // 

$ref = $_SESSION['receiptRef'] ?? $_GET['ref'] ?? '';
$time = $_SESSION['receiptTime'] ?? '';
$receipt = null;

if ($ref) {
    $stmt = $conn->prepare("SELECT total_amount, payment_method, delivery_address FROM transactions WHERE reference_number = ?");
    $stmt->bind_param("s", $ref);
    $stmt->execute();
    $result = $stmt->get_result();
    $receipt = $result->fetch_assoc();
    $stmt->close();
}
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
        <p class="paymentSuccessful">PAYMENT SUCCESS!</p>
        <p class="byteSize">ByteSize Delights</p>

       <div class="info">
         <div class="info-row">
           <p><strong>TOTAL PAYMENT</strong></p>
           <span><?= htmlspecialchars($receipt['total_amount'] ?? 'Unavailable') ?></span>
         </div>
         <div class="info-row">
           <p><strong>REF. NUMBER</strong></p>
           <span><?= htmlspecialchars($ref) ?></span>
         </div>
         <div class="info-row">
           <p><strong>PAYMENT TIME</strong></p>
           <span><?= htmlspecialchars($time ?: date('Y-m-d H:i:s')) ?></span>
         </div>
         <div class="info-row">
           <p><strong>PAYMENT METHOD</strong></p>
           <span><?= htmlspecialchars($receipt['payment_method'] ?? 'Unavailable') ?></span>
         </div>
         <div class="info-row">
           <p><strong>DELIVERY ADDRESS</strong></p>
           <span><?= htmlspecialchars($receipt['delivery_address'] ?? 'Unavailable') ?></span>
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
      countdownText.textContent = `Redirecting in ${seconds} second${seconds !== 1 ? "s" : ""}...`;
      if (seconds <= 0) {
        clearInterval(interval);
        window.location.href = "Product.html";
      }
      seconds--;
    }, 1000);
  </script>

</body>
</html>
