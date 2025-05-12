
$(document).ready(function () {
    $('#productForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way

        // Prepare form data
        var formData = new FormData(this);

        // Make the AJAX request
        $.ajax({
            url: 'add_Product.php',
            type: 'POST',
            data: formData,
            contentType: false,  // Do not set content type for form data
            processData: false,  // Do not process data
            dataType: 'json',    // Expect a JSON response
            success: function (data) {
                // Check for success
                if (data.status === 'error') {
                    // Display errors in alert
                    alert('Error: ' + data.message);
                } else if (data.status === 'success') {
                    // Display success message
                    alert('Success: ' + data.message);

                    // Optionally, reset the form after successful submission
                    $('#productForm')[0].reset();
                }
            },
            error: function (xhr, status, error) {
                // Handle AJAX errors
                alert('An error occurred while processing the form.');
            }
        });
    });
});
