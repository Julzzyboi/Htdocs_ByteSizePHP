<div class="products-container">
  <div class="product">
    <h3>Awesome T-Shirt</h3>
    <p>Price: PHP 25.00</p>
    <button class="add-to-cart-btn" data-product-id="123">Add to Cart</button>
  </div>

  <div class="product">
    <h3>Cool Mug</h3>
    <p>Price: PHP 10.00</p>
    <button class="add-to-cart-btn" data-product-id="456">Add to Cart</button>
  </div>
</div>

<div class="cart-sidebar">
  <h2>Your Cart</h2>
  <ul id="cartItems">
    </ul>
  <p id="cartTotal">Total: PHP 0.00</p>
  <button onclick="submitOrder()">Submit Order</button>
  <button onclick="clearCart()">Clear Cart</button>
</div>

<div id="cart-notification" style="display:none; color: green;">Item added to cart!</div>

<style>
  .cart-sidebar {
    width: 300px; /* Adjust width as needed */
    position: fixed; /* Or absolute, depending on your layout */
    top: 0;
    right: 0;
    height: 100%;
    background-color: #f8f8f8;
    padding: 20px;
    border-left: 1px solid #ccc;
    overflow-y: auto; /* Enable scrolling if cart is long */
    box-sizing: border-box;
  }

  /* Adjust styles for product container to avoid overlap */
  .products-container {
    margin-right: 320px; /* Adjust to accommodate sidebar width + some spacing */
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartNotification = document.getElementById('cart-notification');

    addToCartButtons.forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.dataset.productId;

        fetch('cart_actions.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `action=add&product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log(data.message);
            cartNotification.style.display = 'block';
            setTimeout(() => {
              cartNotification.style.display = 'none';
            }, 2000);
            fetchCartDataAndDisplay(); // Update the static cart display
          } else {
            console.error('Error adding to cart:', data.error);
            alert(`Error: ${data.error}`);
          }
        })
        .catch(error => {
          console.error('Fetch error:', error);
          alert('An error occurred while adding to cart.');
        });
      });
    });

    function fetchCartDataAndDisplay() {
      fetch('cart_actions.php?action=view_cart_data')
        .then(response => response.json())
        .then(cartData => {
          displayCartItems(cartData);
        })
        .catch(error => {
          console.error('Error fetching cart data:', error);
        });
    }

    function displayCartItems(cartData) {
      const cartItemsElement = document.getElementById('cartItems');
      const cartTotalElement = document.getElementById('cartTotal');
      cartItemsElement.innerHTML = '';
      let total = 0;

      if (cartData.length === 0) {
        cartItemsElement.innerHTML = '<li>Your cart is empty.</li>';
        cartTotalElement.textContent = 'Total: PHP 0.00';
        return;
      }

      cartData.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.name} x${item.quantity} - PHP ${(item.price * item.quantity).toFixed(2)}`;
        cartItemsElement.appendChild(listItem);
        total += (item.price * item.quantity);
      });

      cartTotalElement.textContent = `Total: PHP ${total.toFixed(2)}`;
    }

    function submitOrder() {
      fetch('cart_actions.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=submit_order'
      })
      .then(response => response.text())
      .then(data => {
        alert(data);
        fetchCartDataAndDisplay(); // Update the cart display after submission
      })
      .catch(error => {
        console.error('Error submitting order:', error);
      });
    }

    function clearCart() {
      fetch('cart_actions.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=clear'
      })
      .then(response => response.text())
      .then(data => {
        alert(data);
        fetchCartDataAndDisplay(); // Update the cart display after clearing
      })
      .catch(error => {
        console.error('Error clearing cart:', error);
      });
    }

    // Fetch and display cart data on page load to populate the sidebar
    fetchCartDataAndDisplay();
  });
</script>