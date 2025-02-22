// Create an instance of Notyf
const notyf = new Notyf();

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$(document).ready( function () {
  getTicketStatus();
})

// Flatpickr
flatpickr("#selectMonth", {
    maxDate: "today",
    dateFormat: "Y-m",
    mode: "single",
  });

  // Render Ticket Status on Tables
function getTicketStatus() {
  const dt = $('#ticketStatusTable');

  if (dt.length) {
      dt.DataTable({
          ajax: {
              type: 'GET',
              url: '/backend/admin/getReportTicketStatus',
              contentType: 'application/x-www-form-urlencoded',
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
                  data: 'office_name',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display office name directly
                  }
              },
              {
                  data: 'pending',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display pending ticket count
                  }
              },
              {
                  data: 'in_progress',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display in-progress ticket count
                  }
              },
              {
                  data: 'resolved',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display resolved ticket count
                  }
              },
              {
                  data: 'closed',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display closed ticket count
                  }
              },
              {
                  data: 'total',
                  className: 'text-center align-content-center',
                  render: function (data) {
                      return data; // Display total ticket count
                  }
              }
          ],
          order: [[0, 'asc']],
          dom: 'Bfrtip',  // Required for buttons to show up
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
      });
  }
}
