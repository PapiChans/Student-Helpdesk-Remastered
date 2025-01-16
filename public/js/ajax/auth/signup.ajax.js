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

        // This disables the button
        $('#signupFormSubmit').attr('disabled', true)

        if (formData.password != formData.password_confirmation ){
            Swal.fire({
                title: 'Oops!',
                text: 'Password does not match',
                icon: 'error',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Okay',
                confirmButtonColor: '#0054a6',
            })
            $('#signupFormSubmit').attr('disabled', false)
        }
        else {
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
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'Back to Log In',
                        confirmButtonColor: '#0054a6',
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    })
                    
                },
                error: function(response) {
                    if (response.responseJSON.status == 'error'){
                        Swal.fire({
                            title: 'Oops!',
                            text: response.responseJSON.message,
                            icon: 'error',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Okay',
                            confirmButtonColor: '#0054a6',
                        })
                    }
                    else {
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
                    $('#signupFormSubmit').attr('disabled', false)
                }
            });
        }
    });
});