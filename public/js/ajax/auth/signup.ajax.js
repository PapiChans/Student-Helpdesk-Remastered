$( document ).ready(function() {
    $( "#signupForm" ).submit(function( event ) {

        // Prevent the form from submitting
        event.preventDefault();

        const last_name = $( "#last_name" ).val();
        const first_name = $( "#first_name" ).val();
        const middle_name = $( "#middle_name" ).val();
        const gender = $( "#gender" ).val();
        const email = $( "#email" ).val();
        const password = $( "#password" ).val();
        const agreement = $( "#agreement" ).prop('checked');

        // Check if the form is valid using HTML5 validation
        if (!this.checkValidity()) {
            return;  // Stop further execution
        }

        const data = [
            last_name = last_name,
            first_name = first_name,
            middle_name = middle_name,
            gender = gender,
            email = email,
            password = password,
            agreement = agreement
        ];

        console.log(data)

    });
});