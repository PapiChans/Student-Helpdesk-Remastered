// Create an instance of Notyf
const notyf = new Notyf();

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$( document ).ready(function() {
    getTicket();
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

// Render Tickets on Tables
function getTicket() {
    const dt = $('#ticketTable');

    if (dt.length) {
        dt.DataTable ({
            ajax: {
                type: 'GET',
                url: '/backend/user/getTickets',
                ContentType: 'application/x-www-form-urlencoded',
                headers: {'X-CSRFToken': csrfToken},
                dataSrc: 'data',
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.log('Response Text:', xhr.responseText);
                    notyf.error({
                        position: {x: 'right', y: 'top'},
                        duration: 2000,
                        ripple: true,
                        message: "There was an error while retrieving ticket data.",
                    });
                },
                success: function(data) {
                    console.log('Data received:', data);  // Log successful response
                }
            },
            language: {
                emptyTable: "No data found"  // Custom message when the table has no data
            },
            columns: [
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return row.ticket_number;
                    }
                },
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return row.type;
                    }
                },
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return row.priority;
                    }
                },
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return row.status;
                    }
                },
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return row.office;
                    }
                },
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        return formatTimestamp(row.date_added);
                    }
                },
            ],
            order: [[5, 'desc']],
        });
    }
}