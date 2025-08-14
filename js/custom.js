$(document).ready(function () {

    fetchData();

    function fetchData() {
        $.ajax({
            url: './php/custom.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'read' },
            success: function (response) {
                if (response.status) {
                    const html = response.data?.html || '';
                    $(".table_body_data").html(html.length ? html : "<p>No data found.</p>");
                } else {
                    $(".table_body_data").html("<p>Error: " + response.message + "</p>");
                }
            },
            error: function () {
                $.notify("Error loading data!", "error");
            }
        });
    }

    // Add / Update Product
    $('#addProductForm').on('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        let actionType = $('#product_id').val() ? 'update' : 'add';
        let successMsg = actionType === 'add' ? 'Product added successfully!' : 'Product updated successfully!';

        $.ajax({
            url: './php/custom.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: actionType,
                id: $('#product_id').val(),
                v_product_name: $('#v_product_name').val(),
                i_product_quntity: $('#i_product_quantity').val(),
                i_product_price: $('#i_product_price').val(),
                gst: $('#gst').val(),
                gst_amount: $('#gst_amount').val(),
                taxable_amount: $('#taxable_amount').val(),
                total_amount: $('#total_amount').val()
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: successMsg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    fetchData();
                    $('#addProductForm')[0].reset();
                    $('#product_id').val('');
                } else {
                    $.notify(response.message, "error");
                }
            },
            error: function () {
                $.notify("Error saving product!", "error");
            }
        });
    });

    // Delete Product
    $(document).on('click', '.delete_product', function () {
        const productId = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the product.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: './php/custom.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'delete', id: productId },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Product deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            fetchData();
                        } else {
                            $.notify(response.message, "error");
                        }
                    },
                    error: function () {
                        $.notify("Error deleting product!", "error");
                    }
                });
            }
        });
    });

    // Fill form for update
    $(document).on('click', '.update_product', function () {
        $('#product_id').val($(this).data('id'));
        $('#v_product_name').val($(this).data('name'));
        $('#i_product_quantity').val($(this).data('quantity'));
        $('#i_product_price').val($(this).data('price'));
        $('#gst').val($(this).data('gst'));
        $('#gst_amount').val($(this).data('gst_amount'));
        $('#taxable_amount').val($(this).data('taxable_amount'));
        $('#total_amount').val($(this).data('total_amount'));
    });

    // Validate form
    function validateForm() {
        let isValid = true;
        let firstErrorShown = false;

        const namePattern = /^[A-Za-z\s]+$/;  // Only letters and spaces
        const numberPattern = /^[0-9]+$/;     // Only whole numbers
        const pricePattern = /^[0-9]+(\.[0-9]{1,2})?$/; // Digits with optional decimal

        $('.required').each(function () {
            let value = $(this).val().trim();
            let fieldId = $(this).attr('id');

            // Empty field check
            if (value === '') {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstErrorShown) {
                    $.notify("Please fill all required fields.", "error");
                    firstErrorShown = true;
                }
            }
            // Product Name: only letters
            else if (fieldId === 'v_product_name' && !namePattern.test(value)) {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstErrorShown) {
                    $.notify("Product name must contain only letters.", "error");
                    firstErrorShown = true;
                }
            }
            // Quantity: only digits
            else if (fieldId === 'i_product_quantity' && !numberPattern.test(value)) {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstErrorShown) {
                    $.notify("Quantity must contain only digits.", "error");
                    firstErrorShown = true;
                }
            }
            // Price: only digits or decimal
            else if (fieldId === 'i_product_price' && !pricePattern.test(value)) {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstErrorShown) {
                    $.notify("Price must be a valid number.", "error");
                    firstErrorShown = true;
                }
            }
            else {
                $(this).removeClass('is-invalid');
            }
        });

        return isValid;
    }


    // Auto calculate total price
    $(document).on('input', '#i_product_quantity, #i_product_price', function () {
        let quantity = parseFloat($('#i_product_quantity').val()) || 0;
        let price = parseFloat($('#i_product_price').val()) || 0;
        let total = quantity * price;
        $('#i_product_total_price').val(total.toFixed(2));
    });



    // Calculate GST, Taxable, and Total Amount
    function calculateAmounts() {
        let qty = parseFloat($('#i_product_quantity').val()) || 0;
        let price = parseFloat($('#i_product_price').val()) || 0;
        let gstPercent = parseFloat($('#gst').val()) || 0;

        let taxableAmount = qty * price;
        let gstAmount = (taxableAmount * gstPercent) / 100;
        let totalAmount = taxableAmount + gstAmount;

        $('#taxable_amount').val(taxableAmount.toFixed(2));
        $('#gst_amount').val(gstAmount.toFixed(2));
        $('#total_amount').val(totalAmount.toFixed(2));
    }

    $(document).on('input', '#i_product_quantity, #i_product_price, #gst', function () {
        calculateAmounts();
    });

});
