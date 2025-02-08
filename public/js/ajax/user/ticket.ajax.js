// Create an instance of Notyf
const notyf = new Notyf();

$( document ).ready(function() {
    getOfficeChoice();
});

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Preventing to Put any numbers in input type 'text'
document.querySelectorAll('input[type="text"].no-numbers').forEach(function(input) {
    input.addEventListener('input', function(event) {
        // Remove numbers from the input value
        event.target.value = event.target.value.replace(/[0-9]/g, '');
    });
});

// Get office Choices
function getOfficeChoice() {

    const add_office = $('#add_Office'); 

    $.ajax({
        type: "GET",
        url: "/backend/user/getOffice",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            if (response.data && response.data.length > 0) {
                response.data.forEach((officeData) => {
                    let officeChoices = `
                    <option value="${officeData.office_id}">${officeData.office_name}</option>
                    `

                    add_office.append(officeChoices);
                });
            }
        },
        error: function(xhr) {
            console.log(xhr)
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving offices.",
            });
        }
    });
}

// Generate Ticket Number
function generateTicketNumber() {
    const date = new Date();
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-based
    const day = date.getDate().toString().padStart(2, '0');

    // Generate a random 4-letter string
    const randomLetters = Array.from({ length: 4 }, () => {
        const charCode = Math.floor(Math.random() * 26) + 65; // Random letter between A-Z
        return String.fromCharCode(charCode);
    }).join('');

    // Construct the ticket number
    const TicketNumber = `T${year}-${month}-${day}-${randomLetters}`;

    return TicketNumber;
}

// Create Ticket
$( "#addTicketForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        ticket_number: generateTicketNumber(),
        affiliation: $( "#add_Affiliation" ).val(),
        priority: $( "#add_Priority" ).val(),
        type: $( "#add_Type" ).val(),
        office: $( "#add_Office" ).val(),
        service: $( "#add_Service" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#addTicketFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/user/addTicket",
        data: formData,
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            notyf.dismissAll();

            if (response.status == 'success'){
                notyf.success({
                    position: {x: 'right', y: 'top'},
                    duration: 2000,
                    ripple: true,
                    message: response.message,
                });

                $('form#addTicketForm')[0].reset();

                window.location.href = '/user/home';
            }
            
        },
        error: function(response, xhr) {
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

            $('#addTicketFormSubmit').attr('disabled', false)
        }
    });
});