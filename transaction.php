<?php
session_start();
include 'Db_connection.php';

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="transaction.css"/>
</head>
<body>

  <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#checkoutModal" id="launchModalBtn">
    Launch Checkout
  </button>

  <!-- Bootstrap Modal -->
  <div class="modal fade show d-block" id="checkoutModal" tabindex="-1" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-0">
        <div class="checkoutContainer">
          <div class="modal-body">

            <h1>CHECKOUT</h1>
            <h3>Order Details:</h3>

            <div class="amount">
              <p>Total Amount to Pay: <span id="amountDisplay">Php 0.00</span></p>
            </div>

            <div class="paymentBoxGroup">
              <label for="payment">Payment Methods</label>
              <select id="payment">
                <option value="nonee">Select payment method</option>
                <option value="cash">Cash</option>
                <option value="e-payment">E-Payment</option>
              </select>
            </div>

            <div class="paymentBoxGroup" id="modetopay">
              <label for="payment">E-Payment Method</label>
              <select id="e-paymentm">
                <option value="GCash">GCash</option>
                <option value="maya">Maya</option>
                <option value="GoTyme">GoTyme</option>
                <option value="QR Ph">QR Ph</option>
              </select>
            </div>

            <div class="paymentBoxGroup">
              <label for="delivery">Mode of Delivery</label>
              <select id="delivery">
                <option value="None">Select mode of delivery</option>
                <option value="Pick-up">Pick-up</option>
                <option value="Delivery">Delivery</option>
              </select>
            </div>

            <div class="paymentBoxGroup" id="addressGroup">
              <label for="address">Delivery Address</label>
              <input type="text" id="address" placeholder="Ex.: 123 M.H Del Pilar St., Espana, Manila" />
            </div>

            <div class="d-flex justify-content-between">
              <a href="Product.html" class="backtoCartbtn">Back to Cart</a>
              <button class="confirmButton" id="confirmBtn">Confirm</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modalOverlay">
    <div id="modalContent"></div>
  </div>

  <script>
    const deliverySelect = document.getElementById("delivery");
    const addressGroup = document.getElementById("addressGroup");
    const confirmBtn = document.getElementById("confirmBtn");
    const paymentSelect = document.getElementById("payment");
    const addressInput = document.getElementById("address");
    const amountDisplay = document.getElementById("amountDisplay");
    const modeToPay = document.getElementById("modetopay");

    deliverySelect.addEventListener("change", () => {
      if (deliverySelect.value === "Delivery") {
        addressGroup.style.display = "block";
      } else {
        addressGroup.style.display = "none";
        addressInput.value = ""; 
      }
    });

    confirmBtn.addEventListener("click", () => {
      const paymentMethod = paymentSelect.value;
      const deliveryMode = deliverySelect.value;
      const address = addressInput.value.trim();
      const totalAmount = amountDisplay.textContent;

      if ((paymentMethod === "nonee" || paymentMethod === "None") &&
          (deliveryMode === "None")) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing details',
          text: 'Please select a payment method and delivery mode!',
        });
        return;
      }

      if ((paymentMethod === "nonee" || paymentMethod === "None")) {
        Swal.fire({
          icon: 'warning',
          title: 'No payment method',
          text: 'Please select a payment method',
        });
        return;
      }

      if ((deliveryMode === "None")) {
        Swal.fire({
          icon: 'warning',
          title: 'No delivery mode',
          text: 'Please select a delivery mode',
        });
        return;
      }

      if (deliveryMode === "Delivery" && address === "") {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Address',
          text: 'Please enter a delivery address.',
        });
        return;
      }

      const orderDetails = {
        paymentMethod,
        deliveryMode,
        address: deliveryMode === "Delivery" ? address : "N/A",
        totalAmount
      };

      localStorage.setItem("orderDetails", JSON.stringify(orderDetails));
      window.location.href = "receipt.php";
    });

    if (deliverySelect.value === "Pick-up") {
      addressGroup.style.display = "none";
    }

    const totalAmount = localStorage.getItem("totalAmount");
    if (totalAmount) {
      amountDisplay.textContent = `Php ${parseFloat(totalAmount).toFixed(2)}`;
    } else {
      amountDisplay.textContent = "Php 0.00"; 
    }

    paymentSelect.addEventListener('change', function () {
      if (this.value === 'e-payment') {
        modeToPay.style.display = 'block';
      } else {
        modeToPay.style.display = 'none';
      }
    });

    if (paymentSelect.value !== 'e-payment') {
      modeToPay.style.display = 'none';
    }
  </script>

</body>
</html>
