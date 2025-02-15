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
                url: '/backend/admin/getTickets',
                ContentType: 'application/x-www-form-urlencoded',
                headers: {'X-CSRFToken': csrfToken},
                dataSrc: function (json) {
                    // Check if the data field exists and is an array
                    if (json.data && Array.isArray(json.data)) {
                        // If data is empty, show the "No data found" message in the table
                        if (json.data.length === 0) {
                            return []; // Empty array triggers "No data found"
                        }
                        return json.data;
                    }
                    return []; // In case there's no data field or invalid response
                },
            },
            language: {
                emptyTable: "No data found"  // Custom message when the table has no data
            },
            columns: [
                {
                    data: null,
                    className: 'text-center align-content-center',
                    render: function(row) {
                        let link = `<a href="/admin/view/ticket?t=${row.ticket_number}">${row.ticket_number}</a>`
                        return link;
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
                        let badge = null;
                        if (row.status == 'Pending') {
                            badge =`<div class="badge bg-dark text-white">${row.status}</div>`
                        }
                        else if (row.status == 'In Progress') {
                            badge =`<div class="badge bg-primary text-white">${row.status}</div>`
                        }
                        else if (row.status == 'Resolved') {
                            badge =`<div class="badge bg-success text-white">${row.status}</div>`
                        }
                        else if (row.status == 'Closed') {
                            badge =`<div class="badge bg-dark text-white">${row.status}</div>`
                        }
                        else {
                            badge =`<div class="badge bg-dark">Unknown</div>`
                        }
                        return badge;
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