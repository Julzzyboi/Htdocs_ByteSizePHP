<?php
    include("DBConn.php");
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $obj = json_decode($_POST["myJson"]);
            $action = $obj ->action;
            if (isset($action)) {
                switch ($action) {
                    case 'addNewRecord':
                        $id = $obj ->user_id;
                        $fName = $obj ->user_fName;
                        $lName = $obj ->user_lName;
                        $address = $obj ->user_address;
                        $sql = "INSERT INTO basicform_tbl(id, fName, lName, userAddress)  VALUES ('$id', '$fName', '$lName', '$address')";
                        if ($conn->query($sql)===TRUE){
                            echo "NEW RECORD!!";
                        }
                        else{
                            echo "Error";
                        }
                    break;
                    case 'updateRecord':
                        $id = $obj ->user_id;
                        $fName = $obj ->user_fName;
                        $lName = $obj ->user_lName;
                        $address = $obj ->user_address;
                        $sql = "UPDATE basicform_tbl  SET fName = '$fName', lName = '$lName', userAddress = '$address' where id = '$id'";
                        // $sql = "INSERT INTO basicform_tbl(id, fName, lName, userAddress)  VALUES ('1234567841', '$fName', 'Santos' , 'address ko')";
                        if ($conn->query($sql)===TRUE){
                            echo "NEW RECORD!!";
                        }
                        else{
                            echo "Error";
                        }
                    break;
                    case 'delRecord':
                        $id = $obj ->user_id;

                        $sql = "DELETE FROM basicform_tbl where id = '$id'";
                        // $sql = "INSERT INTO basicform_tbl(id, fName, lName, userAddress)  VALUES ('1234567841', '$fName', 'Santos' , 'address ko')";
                        if ($conn->query($sql)===TRUE){
                            echo "DELETED!!";
                        }
                        else{
                            echo "Error";
                        }
                    break;
                    case 'showRecords':
                        $sql = "SELECT * FROM basicform_tbl";
                        $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "id: " . $row["id"]. " - Name: " . $row["fName"]. " " . $row["lName"]. "<br>";
                            }
                            } else {
                            echo "0 results";
                            }
                        break;
                }
            }
        }
    }catch(Exception $e){
        http_response_code(404);
    }
?>