$( document ).ready(function() {
    $( "#signupForm" ).submit(function( event ) {

        // Prevent the form from submitting
        event.preventDefault();

        var formData = {
            last_name: $( "#last_name" ).val(),
            first_name: $( "#first_name" ).val(),
            middle_name: $( "#middle_name" ).val(),
            gender: $( "#gender" ).val(),
            email: $( "#email" ).val(),
            password: $( "#password" ).val(),
            password_confirmation: $( "#password_confirmation" ).val(),
            agreement: $( "#agreement" ).prop('checked')
        };

        // Check if the form is valid using HTML5 validation
        if (!this.checkValidity()) {
            return;  // Stop further execution
        }

        // Get CSRF token from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "POST",
            url: "/backend/signup",
            data: formData,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
            },
            success: function(response){
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log("Error occurred with the request:");
                console.log("Status: " + status);
                console.log("Error: " + error);
                console.log("Response Text: " + xhr.responseText);  // Shows the response body from the server
                try {
                    var jsonResponse = JSON.parse(xhr.responseText);  // Try to parse the error response
                    if (jsonResponse.errors) {
                        console.log("Validation Errors:", jsonResponse.errors);
                    }
                } catch (e) {
                    console.log("Could not parse JSON response:", e);
                }
            }
        });

    });
});