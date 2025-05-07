<?php
session_start();

// Database connection (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdata";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the cart in the session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to find an item in the session cart by product ID
function findCartItem($productId) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $productId) {
            return $key;
        }
    }
    return -1; // Not found
}

if (isset($_GET['action']) && $_GET['action'] === 'view_cart_data') {
    header('Content-Type: application/json');
    echo json_encode(array_values($_SESSION['cart'])); // Return cart data as JSON
    exit();
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $productId = $_POST['product_id'];

            // Fetch product data from the database
            $sql = "SELECT id, productName, price FROM test_cart WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $product = [
                    'id' => $row['id'],
                    'name' => $row['productName'],
                    'price' => floatval($row['price']), // Convert price to float
                    'quantity' => 1
                ];

                $existingKey = findCartItem($productId);

                if ($existingKey !== -1) {
                    $_SESSION['cart'][$existingKey]['quantity']++;
                } else {
                    $_SESSION['cart'][] = $product;
                }

                echo json_encode(['success' => true, 'message' => 'Item added to cart!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Product not found.']);
            }
            $stmt->close();
            break;

        case 'submit_order':
            if (!empty($_SESSION['cart'])) {
                // In a real application, you would:
                // 1. Validate the cart data against your database again (prices, availability)
                // 2. Create a new order record in your database
                // 3. Add the items from the session cart to the order details table
                // 4. Potentially update inventory levels
                // 5. Clear the user's session cart after successful order submission
                $_SESSION['cart'] = []; // Clear the server-side cart after submission
                echo "Order submitted successfully (simulated)!";
            } else {
                echo "Your cart is empty.";
            }
            break;

        case 'clear':
            $_SESSION['cart'] = [];
            echo "Cart cleared!";
            break;

        default:
            echo "Invalid action.";
    }
} else {
    echo "No action specified.";
}

$conn->close();
?>