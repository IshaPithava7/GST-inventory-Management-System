<?php

// Include necessary files
include "./config.php";
include "./include/constant.php";

// Set the content type to JSON
header("Content-Type: application/json");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the action from the POST request
    $action = $_POST['action'] ?? '';
    $status = false;
    $message = ERROR_MSG;
    $response = "";

    // Check if action is set
    if (!$action) {
        $response = ["status" => false, "message" => $message];
        echo json_encode($response);
        exit();
    }

    // Perform actions based on the action type
    switch ($action) {
        case 'read':
            // Fetch data from the database
            $sql = "SELECT * FROM tbl_products_information";
            $result = $connect->query($sql);

            // Check if the query returned any results
            if ($result->num_rows > 0) {
                $status = true;
                $message = "Successfully fetched table data.";
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                $html = "";
                foreach ($rows as $row) {

                    $html .= "<tr data-id='{$row['id']}''>
                                <td>{$row['id']}</td>
                                <td>{$row['v_product_name']}</td>
                                <td>{$row['i_product_quantity']}</td>
                                <td>{$row['i_product_price']}</td>
                                <td>{$row['i_product_total_price']}</td>
                                <td>
                                    <button class='btn btn-primary btn-sm update_product' 
                                        data-id='{$row['id']}'    data-id='{$row['id']}'
                                        data-name='{$row['v_product_name']}'
                                        data-quantity='{$row['i_product_quantity']}'
                                        data-price='{$row['i_product_price']}'
                                    >Edit</button>
                                    <button class='btn btn-danger btn-sm delete_product' data-id='{$row['id']}'>Delete</button>
                                </td>
                            </tr>";

                }
                $response = [
                    "status" => $status,
                    "html" => $html,
                ];
            } else {
                $status = false;
                $message = "No records found";
            }
            break;


        case 'add':

            // Get form data
            $product_name = $_POST['v_product_name'];
            $product_quantity = $_POST['i_product_quntity'];
            $product_price = $_POST['i_product_price'];

            $total_price = $product_quantity * $product_price;

            // Insert data into the database
            $sql = "INSERT INTO tbl_products_information (v_product_name,i_product_quantity, i_product_price, i_product_total_price) VALUES ('$product_name', '$product_quantity', '$product_price', '$total_price')";

            if (mysqli_query($connect, $sql)) {
                $status = true;
                $message = "New record created successfully";
            } else {
                $message = "Error: " . mysqli_error($connect);
            }
            break;

        case 'update':
            // Get form data    
            $id = $_POST['id'];
            $product_name = $_POST['v_product_name'];
            $product_quantity = $_POST['i_product_quntity'];
            $product_price = $_POST['i_product_price'];
            $total_price = $product_quantity * $product_price;

            // Update data in the database
            $sql = "UPDATE tbl_products_information SET v_product_name = '$product_name',i_product_quantity = '$product_quantity', i_product_price = '$product_price', i_product_total_price = '$total_price' WHERE id = '$id'";
            if (mysqli_query($connect, $sql)) {
                $status = true;
                $message = "Record updated successfully";
            } else {
                $message = "Error: " . mysqli_error($connect);
            }
            break;


        case 'delete':
            // Get the ID of the record to delete
            $id = $_POST['id'];

            // Delete data from the database
            $sql = "DELETE FROM tbl_products_information WHERE id = '$id'";

            if (mysqli_query($connect, $sql)) {
                $status = true;
                $message = "Record deleted successfully";
            } else {
                $message = "Error: " . mysqli_error($connect);
            }
            break;


        default:
            $message = "Invalid action";
            break;
    }

    // Return the response as JSON
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $response
    ]);
}

// Close the database connection
mysqli_close($connect);
