
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Menu Section -->
<section id="menuSection" class="Page-Section">
  <div class="container">
    <div class="row" id="menuCards">
      <?php
      // Make sure $conn is your open MySQLi connection
      include 'Db_connection.php';
      $query = "SELECT * FROM `tbl_product_id`";
      $result = mysqli_query($conn, $query);
      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="<?= $row['productImage']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['productName']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['productName']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($row['productDescription']); ?></p>
              <p class="card-text"><strong>Php <?= number_format($row['productPrice'], 2); ?></strong></p>
              <button class="btn btn-primary addToCartBtn"
                data-id="<?= $row['product_ID']; ?>"
                data-name="<?= htmlspecialchars($row['productName']); ?>"
                data-price="<?= $row['productPrice']; ?>"
                data-image="<?= $row['productImage']; ?>"
              >Add to Cart</button>
            </div>
          </div>
        </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</section>

<!-- Cart Section -->
<section id="cartSection" class="Page-Section mt-5">
  <div class="container">
    <h3>Your Cart</h3>
    <div id="cartContainer">
      <p>Your cart is empty.</p>
    </div>
  </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Make sure Bootstrap JS is loaded if you want to use Bootstrap components -->

<script>
let cart = [];

// Add to Cart button click handler
$(document).on('click', '.addToCartBtn', function () {
  const productId = $(this).data('id');
  const productName = $(this).data('name');
  const productPrice = parseFloat($(this).data('price'));
  const productImage = $(this).data('image');

  // Check if item already in cart
  const existing = cart.find(item => item.id === productId);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({
      id: productId,
      name: productName,
      price: productPrice,
      image: productImage,
      qty: 1
    });
  }
  renderCart();
});

// Render cart items in the cart container
function renderCart() {
  let html = '';
  if (cart.length === 0) {
    html = '<p>Your cart is empty.</p>';
  } else {
    html = '<ul class="list-group mb-3">';
    cart.forEach((item, idx) => {
      html += `
        <li class="list-group-item d-flex align-items-center">
          <img src="${item.image}" alt="${item.name}" style="width:40px;height:40px;object-fit:cover;margin-right:10px;">
          <span class="flex-grow-1">${item.name} (x${item.qty})</span>
          <span class="me-3">Php ${(item.price * item.qty).toFixed(2)}</span>
          <button class="btn btn-danger btn-sm removeFromCartBtn" data-idx="${idx}">&times;</button>
        </li>
      `;
    });
    html += '</ul>';
    html += `<div class="text-end"><strong>Total: Php ${cart.reduce((sum, item) => sum + item.price * item.qty, 0).toFixed(2)}</strong></div>`;
  }
  $('#cartContainer').html(html);
}

// Remove from cart handler
$(document).on('click', '.removeFromCartBtn', function () {
  const idx = $(this).data('idx');
  cart.splice(idx, 1);
  renderCart();
});
</script>
</body>
</html>