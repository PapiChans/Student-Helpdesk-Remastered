// Create an instance of Notyf
const notyf = new Notyf();

document.querySelectorAll('input[type="text"].no-numbers').forEach(function(input) {
    input.addEventListener('input', function(event) {
        // Remove numbers from the input value
        event.target.value = event.target.value.replace(/[0-9]/g, '');
    });
});

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
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: 'Passwords does not match.',
            });
            $('#signupFormSubmit').attr('disabled', false)
        }
        else {
            // Get CSRF token from meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            notyf.open({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: 'Signing Up...',
                background: '#f76707'
            });
    
            $.ajax({
                type: "POST",
                url: "/backend/signup",
                data: formData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
                },
                success: function(response){
                    notyf.dismissAll();

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
                    notyf.dismissAll();
                    if (response.responseJSON.status == 'error'){
                        notyf.error({
                            position: {x: 'right', y: 'top'},
                            duration: 2000,
                            ripple: true,
                            message: response.responseJSON.message,
                        });
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