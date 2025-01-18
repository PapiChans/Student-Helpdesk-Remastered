$( document ).ready(function() {
    
});

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

function session_logout() {
    $.ajax({
        type: "GET",
        url: "/backend/logout",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            notyf.success({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: response.message,
            });

            window.location.href = '/login';
        },
        error: function(xhr, status, error) {
            // Log the error details
            console.log('Error Status: ' + status);
            console.log('Error: ' + error);
            console.log('Response Text: ' + xhr.responseText);
            
            // You can also print out the response JSON if it's available
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                console.log('Error Response:', errorResponse);
            } catch (e) {
                console.log('Unable to parse response JSON');
            }
            
            Swal.fire({
                title: 'Oops!',
                text: 'There was an error while processing. Please try again.',
                icon: 'error',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Okay',
                confirmButtonColor: '#0054a6',
            })  
        }
    });
}