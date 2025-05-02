<?php
if (isset($_POST['action']) && $_POST['action'] === 'login') {
        header('Content-Type: application/json');

        $email = trim(strtolower($_POST['LogEmail']));
        $passwordInput = $_POST['LogPassword'];

        $stmt = $conn->prepare("SELECT * FROM tbl_user_id WHERE LOWER(emailAddress) = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password_Hash'];
            

            if ( password_verify($passwordInput, $hashedPassword)) {
                // Password correct
                // $_SESSION['user_id'] = $user['user_ID'];
                // $_SESSION['user_Email'] = $user['emailAddress'];
                // $_SESSION['user_role'] = $user['userRole'];

                // Insert login record into user_login
                $loginTime = date('Y-m-d H:i:s');
                $insertLogin = $conn->prepare("INSERT INTO user_login (user_ID, email, loginTime) VALUES (?, ?, ?)");
                $insertLogin->bind_param("iss", $user['user_ID'], $user['emailAddress'], $loginTime);
                $insertLogin->execute();
                echo var_dump($insertLogin);

                echo json_encode(["success" => true]);
                exit();
            } else {
                echo json_encode(["success" => false, "message" => "Incorrect password."]);
                exit();
            }
        } else {
            echo json_encode(["success" => false, "message" => "Email not found."]);
            exit();
        }
    }
?>