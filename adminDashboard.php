<?php
// Include database connection
include('Db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data safely
  $firstName = $_POST['firstName'] ?? '';
  $lastName = $_POST['lastName'] ?? '';
  $emailAddress = $_POST['emailAddress'] ?? '';
  $phoneNumber = $_POST['phoneNumber'] ?? '';
  $gender = $_POST['Gender'] ?? '';
  $password = $_POST['Password'] ?? '';
  $confirmPassword = $_POST['ConfirmPass'] ?? '';

  // Validate required fields
  if (empty($firstName) || empty($lastName) || empty($emailAddress) || empty($phoneNumber) || empty($gender) || empty($password) || empty($confirmPassword)) {
    die("All fields are required.");
  }

  // Validate password match
  if ($password !== $confirmPassword) {
    die("Passwords do not match.");
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert into tbl_user_id
  $stmt_user = $conn->prepare("INSERT INTO tbl_user_id (firstName, lastName, emailAddress, contactNumber, gender, password_Hash, userRole) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
  $stmt_user->bind_param("ssssss", $firstName, $lastName, $emailAddress, $phoneNumber, $gender, $hashedPassword);

  if ($stmt_user->execute()) {
    $user_id = $stmt_user->insert_id;

    // Insert into tbl_admin_id
    $stmt_admin = $conn->prepare("INSERT INTO tbl_admin_id (user_id, adminPassword_Hash) VALUES (?, ?)");
    $stmt_admin->bind_param("is", $user_id, $hashedPassword);

    if ($stmt_admin->execute()) {
      echo "Admin account created successfully.";
    } else {
      echo "Error creating admin record: " . $stmt_admin->error;
    }

    $stmt_admin->close();
  } else {
    echo "Error creating user: " . $stmt_user->error;
  }

  $stmt_user->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="adminDashboard.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</head>

<body>
  <label>
    <!-- NAVIGATION EXPAND -->
    <input type="checkbox">
    <div class="toggle">
      <span class="topLine common"></span>
      <span class="middleLine common"></span>
      <span class="bottomLine common"></span>
    </div>

    <!-- TOP NAVBAR -->
    <div class="topNav">
      <p>Admin DashBoard</p>
    </div>

    <!-- SIDE NAVBAR -->
    <nav class="sideBar">
      <p>Menu</p>

      <div>
        <ul>
          <li class="dashboardNav nav-link">
            <a href="#dashboardSection">
              <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 32 32" viewBox="0 0 32 32"
                id="Dashboard">
                <path fill="#f24584" d="M29,20v5H3v-5C3,12.83,8.83,7,16,7S29,12.83,29,20z" class="color45aaf2 svgShape">
                </path>
                <path fill="#2e222f"
                  d="M15.5 12h1c.2761 0 .5-.2239.5-.5v-1c0-.2761-.2239-.5-.5-.5h-1c-.2761 0-.5.2239-.5.5v1C15 11.7761 15.2239 12 15.5 12zM7.8682 14.2823l.707.707c.1953.1953.5118.1953.7071 0l.707-.707c.1953-.1953.1953-.5118 0-.7071l-.707-.707c-.1953-.1953-.5118-.1953-.7071 0l-.707.707C7.6729 13.7704 7.6729 14.087 7.8682 14.2823zM22.0108 14.2823l.707.707c.1953.1953.5118.1953.7071 0l.707-.707c.1953-.1953.1953-.5118 0-.7071l-.707-.707c-.1953-.1953-.5118-.1953-.7071 0l-.707.707C21.8155 13.7704 21.8155 14.087 22.0108 14.2823zM24.5 22h1c.2761 0 .5-.2239.5-.5v-1c0-.2761-.2239-.5-.5-.5h-1c-.2761 0-.5.2239-.5.5v1C24 21.7761 24.2239 22 24.5 22zM6.5 22h1C7.7761 22 8 21.7761 8 21.5v-1C8 20.2239 7.7761 20 7.5 20h-1C6.2239 20 6 20.2239 6 20.5v1C6 21.7761 6.2239 22 6.5 22z"
                  class="color3867d6 svgShape"></path>
                <path fill="#ff69a0" d="M21,25H11c0-2.76,2.24-5,5-5S21,22.24,21,25z" class="colord1d8e0 svgShape">
                </path>
                <path fill="#2e222f"
                  d="M16,6C8.2803,6,2,12.2803,2,20v5c0,0.5527,0.4473,1,1,1h26c0.5527,0,1-0.4473,1-1v-5C30,12.2803,23.7197,6,16,6z M12.142,24c0.4471-1.7205,1.9993-3,3.858-3s3.4109,1.2795,3.858,3H12.142z M28,24h-6.0903c-0.4233-2.5071-2.4025-4.4864-4.9097-4.9097V14.5c0-0.2761-0.2239-0.5-0.5-0.5h-1c-0.2761,0-0.5,0.2239-0.5,0.5v4.5903c-2.5071,0.4233-4.4864,2.4025-4.9097,4.9097H4l0-3.649C4,14.1058,8.6262,8.6393,14.844,8.0545C21.9786,7.3834,28,13.0013,28,20V24z"
                  class="color3867d6 svgShape"></path>
              </svg>
              <span>Dashboard</span>
            </a>
          </li>

          <li class="ordersNav nav-link">
            <a href="#orderSection">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="receipt">
                <defs>
                  <linearGradient id="a" x1="19.475" x2="4.525" y1="23.474" y2="8.525" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#ff609a" class="stopColor60efff svgShape"></stop>
                    <stop offset=".117" stop-color="#f15f95" class="stopColor5ff0f1 svgShape"></stop>
                    <stop offset=".503" stop-color="#f55d95" class="stopColor5df5ca svgShape"></stop>
                    <stop offset=".811" stop-color="#ff69a0" class="stopColor5cf8b1 svgShape"></stop>
                    <stop offset="1" stop-color="#fa5c96" class="stopColor5cfaa9 svgShape"></stop>
                  </linearGradient>
                </defs>
                <g fill="#000000" class="color000000 svgShape">
                  <path fill="url(#a)"
                    d="M23,16c0,1.2-.12,2.29-.29,3.25-.3,1.68-1.66,2.96-3.35,3.21-2.16,.32-4.63,.54-7.36,.54s-5.2-.22-7.36-.54c-1.69-.25-3.05-1.53-3.35-3.21-.17-.96-.29-2.05-.29-3.25s.12-2.29,.29-3.25c.18-1.01,.7401-1.87,1.52-2.45l1.19,1.08v.01l5.31,4.82c1.52,1.39,3.86,1.39,5.38,0l5.31-4.82v-.01l1.19-1.08c.78,.58,1.34,1.44,1.52,2.45,.17,.96,.29,2.05,.29,3.25Z">
                  </path>
                </g>
                <g fill="#000000" class="color000000 svgShape">
                  <g fill="#000000" class="color000000 svgShape">
                    <path fill="#2e222f"
                      d="M23.6943,12.5747c-.2188-1.2319-.8965-2.3247-1.9043-3.0752-.2518-.1885-.517-.3453-.79-.4798V3c0-1.6543-1.3457-3-3-3H6c-1.6543,0-3,1.3457-3,3v6.0197c-.2726,.1342-.537,.2905-.7871,.4779-1.0107,.7524-1.6885,1.8452-1.9072,3.0781-.2031,1.1445-.3057,2.2969-.3057,3.4243s.1025,2.2798,.3057,3.4258c.373,2.0908,2.0557,3.708,4.1875,4.0234,2.4688,.3652,4.9941,.5508,7.5068,.5508s5.0381-.1855,7.5068-.5508c2.1318-.3154,3.8145-1.9326,4.1875-4.0249,.2031-1.1445,.3057-2.2969,.3057-3.4243s-.1025-2.2798-.3057-3.4253ZM6,2h12c.5518,0,1,.4487,1,1v7.9399l-4.9844,4.5322c-1.1299,1.0332-2.9014,1.0322-4.0332-.002l-4.9824-4.5303V3c0-.5513,.4482-1,1-1Zm15.7256,17.0742c-.2217,1.2441-1.2314,2.207-2.5117,2.3965-4.7441,.7021-9.6836,.7021-14.4277,0-1.2803-.1895-2.29-1.1523-2.5117-2.395-.1816-1.0298-.2744-2.0645-.2744-3.0757s.0928-2.0459,.2744-3.0747c.082-.4605,.2834-.8813,.5647-1.2471l5.7957,5.2696c.9443,.8633,2.1553,1.2944,3.3662,1.2944,1.21,0,2.4199-.4312,3.3623-1.2925l5.7979-5.2717c.2808,.3655,.4823,.7861,.5644,1.2463,.1816,1.0298,.2744,2.0645,.2744,3.0757s-.0928,2.0459-.2744,3.0742Z"
                      class="color212529 svgShape"></path>
                    <path fill="#2e222f"
                      d="M12.5,10h-2.5c-.5527,0-1,.4478-1,1s.4473,1,1,1h1c0,.5522,.4473,1,1,1s1-.4478,1-1v-.0506c1.14-.2323,2-1.2422,2-2.4494,0-1.3784-1.1211-2.5-2.5-2.5h-1c-.2754,0-.5-.2241-.5-.5s.2246-.5,.5-.5h2.5c.5527,0,1-.4478,1-1s-.4473-1-1-1h-1c0-.5522-.4473-1-1-1s-1,.4478-1,1v.0506c-1.14,.2323-2,1.2422-2,2.4494,0,1.3784,1.1211,2.5,2.5,2.5h1c.2754,0,.5,.2241,.5,.5s-.2246,.5-.5,.5Z"
                      class="color212529 svgShape"></path>
                  </g>
                </g>
              </svg>
              <span>Orders</span>
            </a>
          </li>

          <li class="inventoryNav nav-link">
            <a href="#inventorySection">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 128 128" id="DeliveryBox">
                <path fill="#ff69a0" stroke="#2e222f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5"
                  d="M102 52.4232L102 75.5222C102 77.976 100.715 80.2506 98.6136 81.5174L84 90.3258L67.747 100.626C65.4593 102.075 62.5407 102.075 60.2531 100.626L44 90.3258L29.3864 81.5174C27.2848 80.2507 26 77.976 26 75.5222L26 52.4232C26 49.999 27.2543 47.7473 29.3155 46.4713L45 36.7619L60.3155 27.2809C62.5731 25.8833 65.4269 25.8833 67.6845 27.2809L83 36.7619L98.6845 46.4713C100.746 47.7473 102 49.999 102 52.4232Z"
                  class="colorffd84e svgShape colorStroke000000 svgStroke"></path>
                <path stroke="#2e222f" stroke-linecap="round" stroke-linejoin="round" stroke-width="5"
                  d="M101 50L64 73.0746M64 73.0746L64 102M64 73.0746L44.5 61.5373L27 50"
                  class="colorStroke000000 svgStroke"></path>
                <path stroke="#2e222f" stroke-linecap="round" stroke-width="5"
                  d="M45.5 62L83.5 37M36 64L12 64M39 71L18 71M37 78L10 78" class="colorStroke000000 svgStroke"></path>
              </svg>
              <span>Inventory</span>
            </a>
          </li>

          <li class="accountNav nav-link">
            <a href="#accountSection">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="Users">
                <path fill="#ff69a0"
                  d="M17.05 51.49a1 1 0 0 1-.4-.94c.33-2.74 2.49-14.11 15.21-14.67s15.25 11.68 15.67 14.63a1 1 0 0 1-.45 1c-2.84 1.79-16.68 9.64-30.03-.02Z"
                  class="color666666 svgShape"></path>
                <path fill="#2e222f"
                  d="M32 32.83a9.52 9.52 0 0 1-9.56-9.57A9.57 9.57 0 1 1 32 32.83Zm0-16.13a6.43 6.43 0 0 0-4.08 1.42 6.58 6.58 0 0 0 1.51 11.19 6.69 6.69 0 0 0 5.3-.07 6.57 6.57 0 0 0 1.65-10.86A6.5 6.5 0 0 0 32 16.7Z"
                  class="color0a1c1b svgShape"></path>
                <path fill="#2e222f"
                  d="M40.74 34.17a9.63 9.63 0 0 1-6.39-2.44 1.49 1.49 0 0 1 .37-2.48 6.58 6.58 0 0 0 1.66-10.87 1.5 1.5 0 0 1 .38-2.48 9.57 9.57 0 1 1 4 18.27zm-2.63-3.55A6.56 6.56 0 1 0 40.74 18h-.71a9.57 9.57 0 0 1-1.92 12.55zM32 57.7h-1.81c-.41 0-.85-.07-1.29-.13a4.6 4.6 0 0 1-.6-.07l-.7-.1-.6-.2c-.38-.08-.71-.15-1-.24s-.72-.17-1.11-.29l-.89-.25c-.32-.1-.63-.21-.95-.34a23.66 23.66 0 0 1-3.82-1.79L18.8 54l-.21-.13a25.73 25.73 0 0 1-2.46-1.71 1.52 1.52 0 0 1-.57-1.05v-.5A16.42 16.42 0 0 1 32 34.19a16.45 16.45 0 0 1 16.45 16.46v.5a1.52 1.52 0 0 1-.57 1.05c-.27.21-.54.42-.81.61l-.39.27c-.14.11-.32.23-.49.34s-.59.39-.9.57-.59.35-.88.51a24.852 24.852 0 0 1-2.93 1.39l-.85.32-.88.3-.67.2-.72.19-.74.19c-.83.18-1.66.32-2.46.42l-1 .1a6.71 6.71 0 0 1-.67 0h-.8zm.47-3zm-13.92-4.43c.52.38 1.05.74 1.59 1.07l.23.14.36.21a20.28 20.28 0 0 0 3.4 1.59c.3.12.54.2.8.28a7.63 7.63 0 0 0 .73.23c.33.1.65.19 1 .26s.58.14.84.2l.68.12.62.1.43.05a11.44 11.44 0 0 0 1.19.11 7.59 7.59 0 0 0 .79 0 7.59 7.59 0 0 0 .8 0h1.94c.32 0 .58 0 .84-.09a21.74 21.74 0 0 0 2.21-.4c.22 0 .43-.1.64-.16l.6-.15.63-.19.77-.26.78-.3c.29-.11.53-.22.77-.33.63-.28 1.21-.56 1.77-.87l.8-.47c.25-.15.51-.31.75-.48l.37-.24.09-.07.31-.22.18-.13a13.41 13.41 0 0 0-7.56-11.73 13.46 13.46 0 0 0-19.35 11.73zm28.39.73z"
                  class="color0a1c1b svgShape"></path>
                <path fill="#2e222f"
                  d="M46.94 52.52a1.5 1.5 0 0 1-1.49-1.63v-.24a13.42 13.42 0 0 0-7.56-12.11 1.5 1.5 0 0 1 .44-2.83 17.53 17.53 0 0 1 2.41-.17 16.45 16.45 0 0 1 13.69 7.33 1.49 1.49 0 0 1 .07 1.55 25.9 25.9 0 0 1-6.63 7.78 1.52 1.52 0 0 1-.93.32zm-3.49-13.71a16.32 16.32 0 0 1 4.77 9 23 23 0 0 0 3.18-4.07 13.48 13.48 0 0 0-7.95-4.93zM23.82 34a9.57 9.57 0 1 1 3.74-18.38 1.5 1.5 0 0 1 .36 2.56 6.5 6.5 0 0 0-2.48 5.13 6.57 6.57 0 0 0 4 6 1.5 1.5 0 0 1 .35 2.55A9.53 9.53 0 0 1 23.82 34zm0-16.13a6.57 6.57 0 1 0 0 13.13 6.4 6.4 0 0 0 2.06-.33 9.6 9.6 0 0 1-1.75-12.8zm-6.76 34.65a1.52 1.52 0 0 1-.93-.32 25.6 25.6 0 0 1-6.42-7.41 1.5 1.5 0 0 1 0-1.52 16.36 16.36 0 0 1 14.09-8 17.19 17.19 0 0 1 2.35.16 1.5 1.5 0 0 1 .41 2.86 13.49 13.49 0 0 0-8 12.32v.24a1.5 1.5 0 0 1-1.49 1.63zm-4.28-8.44a23.2 23.2 0 0 0 3 3.79 16.5 16.5 0 0 1 4.94-9.21 13.36 13.36 0 0 0-7.94 5.42z"
                  class="color0a1c1b svgShape"></path>
                <path fill="#2e222f"
                  d="M32 57.7h-1.81c-.41 0-.85-.07-1.29-.13a4.6 4.6 0 0 1-.6-.07l-.7-.1-.6-.2c-.38-.08-.71-.15-1-.24s-.72-.17-1.11-.29l-.89-.25c-.32-.1-.63-.21-.95-.34a23.66 23.66 0 0 1-3.82-1.79L18.8 54l-.21-.13a25.72 25.72 0 1 1 29.28-1.67c-.27.21-.54.42-.81.61l-.39.27c-.14.11-.32.23-.49.34s-.59.39-.9.57-.59.35-.88.51a24.852 24.852 0 0 1-2.93 1.39c-.32.12-.44.17-.7.27l-.15.05-.88.3-.67.2-.72.19-.74.19c-.83.18-1.66.32-2.46.42l-1 .1a6.71 6.71 0 0 1-.67 0h-.8Zm.47-3ZM32 9.3a22.68 22.68 0 0 0-14 40.54 23.85 23.85 0 0 0 2.16 1.5l.23.14.36.21a20.28 20.28 0 0 0 3.4 1.59c.3.12.54.2.8.28a7.63 7.63 0 0 0 .73.23c.33.1.65.19 1 .26s.58.14.84.2l.68.12.62.1.43.05a11.44 11.44 0 0 0 1.19.11 7.59 7.59 0 0 0 .79 0 7.59 7.59 0 0 0 .8 0h1.94c.32 0 .58 0 .84-.09a21.74 21.74 0 0 0 2.19-.4c.22 0 .43-.1.64-.16l.6-.15.63-.19.77-.26.13-.05.63-.24c.31-.12.55-.23.79-.34.63-.28 1.21-.56 1.77-.87l.8-.47c.25-.15.51-.31.75-.48l.37-.24.09-.07.31-.22c.28-.2.51-.38.74-.56A22.69 22.69 0 0 0 32 9.3Z"
                  class="color0a1c1b svgShape"></path>
              </svg>
              <span>Accounts</span>
            </a>
          </li>
        </ul>
      </div>

      <img class="logoSideNav" src="images/bannerLogo.png" alt="ByteSize Logo">
    </nav>
  </label>

  <!-- for main content checkerts and charts -->
  <div class="mainContent">
    <section id="dashboardSection" class="Page-Section">
      <div class="summaryOverview">
        <div class="customerOverview">

        </div>

        <div class="orderOverview">

        </div>

        <div class="inventoryOverview">

        </div>

        <div class="salesOverview">

        </div>
      </div>
    </section>

    <section id="orderSection" class="Page-Section">
      <h1>Tapusin</h1>
    </section>

    <!-- Inventory Section -->
    <section id="inventorySection" class="Page-Section">

      <div class="ProductForm-Container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">Add
          Product</button>

        <table class="table table-bordered table-striped table-hover" id="productTable"
          style="min-width: 1000px; width: 100%;">
          <thead class="table-dark text-center">
            <tr>
              <th>Product ID</th>
              <th>Category</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Image</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody class="text-center align-middle">
            <?php
            $query = "SELECT * FROM `tbl_product_id`";
            $result = mysqli_query($conn, $query);
            if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                  <td><?= $row['product_ID']; ?></td>
                  <td><?= $row['productCategory']; ?></td>
                  <td><?= $row['productName']; ?></td>
                  <td><?= $row['productDescription']; ?></td>
                  <td><?= 'Php ' . number_format($row['productPrice'], 2); ?></td>
                  <td><?= $row['productStock']; ?></td>
                  <td>
                    <img src="<?= $row['productImage']; ?>" alt="Product Image"
                      style="max-width: 80px; height: auto; border-radius: 5px;">
                  </td>
                  <td><a href="#" class="btn btn-success updateBtn" data-id="<?= $row['product_ID']; ?>">Update</a></td>
                  <td><a href="#" class="btn btn-danger deleteBtn" data-id="<?= $row['product_ID']; ?>">Delete</a></td>

                  <?php
              }
            }
            ?>
          </tbody>
        </table>
      <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="updateForm" method="post" enctype="multipart/form-data" action="update_product.php">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Update Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="product_ID" id="edit_product_ID">
                  <!-- Add input fields for category, name, etc. -->
                  <div class="mb-3">
                    <label for="edit_productCategory" class="form-label">Category</label>
                    <input type="text" class="form-control" name="productCategory" id="edit_productCategory">
                  </div>
                  <div class="mb-3">
                    <label for="edit_productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="productName" id="edit_productName">
                  </div>
                  <div class="mb-3">
                    <label for="edit_productDescription" class="form-label">Description</label>
                    <input type="text" class="form-control" name="productDescription" id="edit_productDescription">
                  </div>
                  <div class="mb-3">
                    <label for="edit_productPrice" class="form-label">Price</label>
                    <input type="number" class="form-control" name="productPrice" id="edit_productPrice">
                  </div>
                  <div class="mb-3">
                    <label for="edit_productStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="productStock" id="edit_productStock">
                  </div>
                  <div class="mb-3">
                    <label for="edit_productImage" class="form-label">Image</label>
                    <input type="file" class="form-control" name="productImage" id="edit_productImage">
                  </div>
                  <!-- Repeat for description, price, stock, etc. -->
                </div>
                <div class="modal-footer">
                  <button type="submit" name="update_product" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
     
      </div>
    </section>



    <!-- Account section -->
    <section id="accountSection" class="Page-Section">
      <div class="Account-Container">
        <form id="AdminForm" method="POST" action="adminDashboard.php">
          <div class="Fname-Container">
            <input type="text" class="inputFN" id="Fname" name="firstName" placeholder="First Name (ex. Juan)"
              maxlength="50" />
          </div>
          <div class="Lname-Container">
            <input type="text" class="inputLN" id="Lname" name="lastName" placeholder="Last Name (ex. Dela Cruz)"
              maxlength="50" />
          </div>

          <div class="emailAddress-Container">
            <input type="email" class="inputEmailSignUp" id="email" name="emailAddress"
              placeholder="Email (ex. juandelacruz@gmail.com)" />
          </div>
          <div class="phoneNum-Container">
            <input type="number" class="inputPhoneNum" id="Phone" name="phoneNumber"
              placeholder="Phone Number (09991234567)" oninput="this.value=this.value.slice(0,11)" />
          </div>

          <div class="Gender-Container">
            <label for="Gender">Gender:</label>
            <input type="radio" id="Male" name="Gender" value="Male" />
            <label for="Male">Male</label>
            <input type="radio" id="Female" name="Gender" value="Female" />
            <label for="Female">Female</label>
          </div>

          <div class="adminPassword-Container">
            <input type="password" class="inputSignUpPass" id="password" name="Password" placeholder="Password" />
          </div>

          <div class="confirmPass-Container">
            <input type="password" class="inputSignUpCPass" id="Cpass" name="ConfirmPass"
              placeholder="Confirm Password" />
          </div>

          <button type="submit">Create Admin</button>
        </form>


        <div class="tableAdmin">
          <table id="adminTable" class="display">

            <thead>
              <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Gender</th>
                <th>User Role</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Include your DB connection
              include('Db_connection.php');
              $sql = "SELECT * FROM tbl_user_id WHERE userRole = 'admin'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['user_ID']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['emailAddress']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['userRole']) . "</td>";
                  echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- Login Activity -->
        <div class="LoginAct">
          <!-- <h2>Login Activity</h2> -->
          <table id="loginTable" class="display">
            <thead>
              <tr>
                <th>login_ID</th>
                <th>user_ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Login Time</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </section>
  </div>

     
<!-- add product modal -->
  <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" enctype="multipart/form-data" action="add_Product.php" id="productForm">
        <!-- Add action="your_handler.php" if needed -->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <!-- Product Category -->
            <label for="productCategory" name="productCategory">Category: </label>
            <input type="text" name="productCategory" id="productCategory" class="form-control">
            <span class="error-msg text-danger" id="productCategoryError"></span>

            <!-- Product Name -->
            <label for="productName" name="productName">Product Name: </label>
            <input type="text" name="productName" id="productName" class="form-control">
            <span class="error-msg text-danger" id="productNameError"></span>

            <!-- Product Description -->
            <label for="productCategory" name="productCategory">Description: </label>
            <input type="text" name="productDescription" id="productDescription" class="form-control">
            <span class="error-msg text-danger" id="productDescriptionError"></span>

            <!-- Product Price -->
            <label for="productCategory" name="productCategory">Price: </label>
            <input type="number" name="productPrice" id="productPrice" class="form-control">
            <span class="error-msg text-danger" id="productPriceError"></span>

            <!-- Stock Quantity -->
            <label for="productCategory" name="productCategory">Stock: </label>
            <input type="number" name="productStock" id="productStock" class="form-control">
            <span class="error-msg text-danger" id="productStockError"></span>

            <!-- Product Image -->
            <label for="productCategory" name="productCategory">Product Image: </label>
            <input type="file" name="productImage" id="productImage" class="form-control" required>
            <span class="error-msg text-danger" id="productImageError"></span>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
          </div>
      </form>
    </div>
  </div>

    <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p id="successMessage">Product added successfully!</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p id="errorMessage"></p>
              </div>
            </div>
          </div>
        </div>

  <script>

    document.addEventListener("DOMContentLoaded", () => {
      const links = document.querySelectorAll(".nav-link a");
      const sections = document.querySelectorAll("section");

      // Hide all sections initially
      sections.forEach(section => section.style.display = "none");

      // Show dashboard by default
      const defaultSection = document.querySelector("#dashboardSection");
      if (defaultSection) defaultSection.style.display = "block";

      links.forEach(link => {
        link.addEventListener("click", function (e) {
          // e.preventDefault();

          // Hide all sections
          sections.forEach(section => section.style.display = "none");

          // Get the target section from href
          const targetId = this.getAttribute("href").substring(1);
          const targetSection = document.getElementById(targetId);

          // Show the selected section
          if (targetSection) targetSection.style.display = "block";
        });
      });
    });
    // for admin creation DataTables
    // $(document).ready(function () {
    //   $('#adminTable').DataTable();
    // });


    // $(document).ready(function () {
    //   var loginTable = $('#loginTable').DataTable({
    //     ajax: 'fetch_Login.php',
    //     columns: [
    //       { data: 'login_ID' },
    //       { data: 'user_ID' },
    //       { data: 'emailAddress' },
    //       { data: 'userRole' },
    //       { data: 'loginTime' }
    //     ]
    //   });

    // Optionally reload table after form submission
    $('#adminForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'adminDashboard.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            Swal.fire('Success', response.message, 'success');
            loginTable.ajax.reload(); // 🔁 Refresh login data
            $('#adminForm')[0].reset(); // clear form
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        }
      });
    });



    // Datatables Products
    new DataTable('#productTable', {
      responsive: {
        details: {
          type: 'inline', // or 'column' if you want an icon
          target: '0' // clicking the row reveals hidden columns
        }
      },
      order: [1, 'asc'],
      scrollX: true
    });


    // product message
    $('#productForm').on('submit', function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    url: 'add_product.php',
    method: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function (res) {
      $('#productModal').modal('hide');
      $('#productModal').one('hidden.bs.modal', function () {
        $('#productForm')[0].reset();
        // Remove any lingering modal-backdrop and modal-open class
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        Swal.fire({
          icon: res.success ? 'success' : 'error',
          title: res.success ? 'Success' : 'Error',
          text: res.message,
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          location.reload();
        });
      });
    },
    error: function () {
      $('#productModal').modal('hide');
      $('#productModal').one('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred. Please try again.',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          location.reload();
        });
      });
    }
  });
});

  // 1. When clicking the update button, fetch product data and show modal
$(document).on('click', '.updateBtn', function () {
  let productId = $(this).data('id');
  $.ajax({
    url: 'update_product.php',
    type: 'POST',
    data: { product_ID: productId },
    dataType: 'json',
    success: function (data) {
      $('#edit_product_ID').val(data.product_ID);
      $('#edit_productCategory').val(data.productCategory);
      $('#edit_productName').val(data.productName);
      $('#edit_productDescription').val(data.productDescription);
      $('#edit_productPrice').val(data.productPrice);
      $('#edit_productStock').val(data.productStock);
      $('#updateModal').modal('show');
    }
  });
});

// 2. When submitting the update form, send data via AJAX
$('#updateForm').on('submit', function (e) {
  e.preventDefault();
  var formData = new FormData(this);
  formData.append('update_product', true);

  $.ajax({
    url: 'update_product.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function (response) {
      $('#updateModal').modal('hide');
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Product updated successfully!',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response.error || 'Update failed.'
        });
      }
    },
    error: function () {
      $('#updateModal').modal('hide');
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'An error occurred.'
      });
    }
  });
});

    $(document).on('click', '.deleteBtn', function () {
  let productId = $(this).data('id');
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'delete_product.php',
        type: 'POST',
        data: { product_ID: productId },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Product deleted successfully!',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            location.reload();
          });
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while deleting.'
          });
        }
      });
    }
  });
});


  </script>
</body>

</html>