// Create an instance of Notyf
const notyf = new Notyf();

$( document ).ready(function() {
    $( "#loginForm" ).submit(function( event ) {    
        // Prevent the form from submitting
        event.preventDefault();

        var formData = {
            email: $( "#email" ).val(),
            password: $( "#password" ).val(),
            as_admin: $( "#as_admin" ).prop('checked'),
        };

        // Check if the form is valid using HTML5 validation
        if (!this.checkValidity()) {
            return;  // Stop further execution
        }

        // This disables the button
        $('#loginFormSubmit').attr('disabled', true)

        // Get CSRF token from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        notyf.open({
            position: {x: 'right', y: 'top'},
            duration: 2000,
            ripple: true,
            message: 'Loggin In...',
            background: '#f76707'
        });

        $.ajax({
            type: "POST",
            url: "/backend/login",
            data: formData,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
            },
            success: function(response){
                notyf.dismissAll();
                console.log(response)

                if (response.status == 'success'){
                    notyf.success({
                        position: {x: 'right', y: 'top'},
                        duration: 2000,
                        ripple: true,
                        message: 'Log In Successful',
                    });
                    if (response.admin == true){
                        window.location.href = 'admin/home';
                    }
                    else{
                        window.location.href = 'user/home';
                    }
                }
                else {
                    console.log(response)
                    Swal.fire({
                        title: 'Oops!',
                        text: response.message,
                        icon: 'error',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'Okay',
                        confirmButtonColor: '#0054a6',
                    })  
                }

                $('#loginFormSubmit').attr('disabled', false) // Remove once everything is OK
            },
            error: function(response) {
                notyf.dismissAll();
                console.log(response)
                Swal.fire({
                    title: 'Oops!',
                    text: response.responseJSON.message,
                    icon: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#0054a6',
                })  
                $('#loginFormSubmit').attr('disabled', false)
            }
        });

    });
});