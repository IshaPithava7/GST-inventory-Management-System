<?php

// Include necessary files
include "./php/config.php";

?>

<!-- html -->
<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>

    <!-- meta tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Isha Pithava" />
    <meta name="discription" content="GST Inventory Management System" />
    <meta name="keywords" content="Form, PHP, HTML, CSS, jQuery, MySQl Database">

    <!-- external link css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sweetalert2.min.css">
    <link rel="stylesheet" href="./css/custom.css">

    <!-- title -->
    <title>GST Inventory Management System</title>
</head>

<body>

    <div class="div_container">

        <h1 class="text-center">GST Inventory Management System</h1>
        <hr>
        <form action="" class="border border-2 p-4" method="post" id="addProductForm">

            <!-- hidden -->
            <input type="hidden" id="product_id" name="id">

            <!-- Row 1 -->
            <div class="row g-3">
                <!-- product name -->
                <div class="col-md-3">
                    <input type="text" class="form-control required" name="v_product_name" id="v_product_name"
                        placeholder="Product Name">
                </div>
                <!-- product quantity -->
                <div class="col-md-3">
                    <input type="text" class="form-control required" name="i_product_quantity" id="i_product_quantity"
                        placeholder="Product Quantity">
                </div>
                <!-- product price -->
                <div class="col-md-3">
                    <input type="text" class="form-control required" name="i_product_price" id="i_product_price"
                        placeholder="Product Price">
                </div>
                <!-- product total price -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="i_product_total_price" id="i_product_total_price"
                        placeholder="Total Price" readonly>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-3 mt-2">
                <!-- GST related fields -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="gst" id="gst" placeholder="GST %">
                </div>
                <!-- GST amount -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="gst_amount" id="gst_amount" placeholder="GST Amount"
                        readonly>
                </div>
                <!-- taxable amount -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="taxable_amount" id="taxable_amount"
                        placeholder="Taxable Amount" readonly>
                </div>
                <!-- total amount -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="total_amount" id="total_amount"
                        placeholder="Total Amount" readonly>
                </div>
            </div>

            <!-- Row 3 (Buttons) -->
            <div class="row g-3 mt-3 text-center">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary w-50">Submit</button>
                </div>
                <div class="col-md-6">
                    <button type="reset" class="btn btn-secondary w-50">Reset</button>
                </div>
            </div>
        </form>

        <br>
        <hr>
        <br>
        <!-- table data -->
        <table class="table table-bordered text-center">
            <!-- table head -->
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Product Name</th>
                    <th>Product Quantity</th>
                    <th>Product Price</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <!-- table body -->
            <tbody class="table_body_data">
            </tbody>
        </table>
    </div>
</body>

<!-- external link js -->
<script src="./js/bootstrap.min.js"></script>
<script src="./js/jquery.min.js"></script>
<script src="./js/notify.min.js"></script>
<script src="./js/sweetalert2.min.js"></script>
<script src="./js/custom.js"></script>
<script src="./php/include/constant_js.php"></script>

</html>