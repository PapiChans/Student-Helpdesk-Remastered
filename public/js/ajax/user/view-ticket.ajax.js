// Create an instance of Notyf
const notyf = new Notyf();

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// This will search the Ticket from the URL Parameter
const searchParams = new URLSearchParams(window.location.search);
const ticket_number = searchParams.get('t');

$( document ).ready(function() {
    getTicketInfo(ticket_number);
});

// Posgres Timestamp Function
function formatTimestamp(timestamp) {
    const date = new Date(timestamp);
    
    const options = { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    };
    
    return date.toLocaleDateString('en-US', options);
  }


// Get One Office Data
function getTicketInfo (ticket_number) {
    $.ajax({
        type: "GET",
        url: `/backend/user/getTicketInfo/${ticket_number}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            if (response.verify == 'matched') {
                $('#ticket_Id_info').val(response.data[0].ticket_id); 
                $('#ticket_Number_info').html(response.data[0].ticket_number); 
                $('#ticket_Name_info').html(response.data[0].user); 
                $('#ticket_Affiliation_info').html(response.data[0].affiliation); 
                $('#ticket_Date_info').html(formatTimestamp(response.data[0].created_at)); 
                $('#ticket_Office_info').html(response.data[0].office); 
                $('#ticket_Service_info').html(response.data[0].service); 
                $('#ticket_Type_info').html(response.data[0].type); 
                $('#ticket_Status_info').html(response.data[0].status); 
                $('#ticket_Priority_info').html(response.data[0].priority); 
                
                if (response.data[0].resolved_date != null) {
                    $('#resolved_Date_info').html(formatTimestamp(response.data[0].resolved_date)); 
                }
                else {
                    $('#resolved_Date_info').html('Not Yet Resolved'); 
                }
            }
            else {
                notyf.error({
                    position: {x: 'right', y: 'top'},
                    duration: 2000,
                    ripple: true,
                    message: "Unauthorized Access. Redirecting...",
                });

                setTimeout(() => {
                    window.location.href = '/user/home';
                }, 1000)

            }
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving ticket info.",
            });
        }
    });
}