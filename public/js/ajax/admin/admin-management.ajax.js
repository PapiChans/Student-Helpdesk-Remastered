// Create an instance of Notyf
const notyf = new Notyf();

$( document ).ready(function() {
    getOfficeChoice();
    getAdmin();
    getOffice();
});

// Forming Name Function
function formName(fname, mname, lname) {
    const getmiddle = mname;
    if (getmiddle) {
        return fname[0].toUpperCase() + fname.slice(1) + " " + getmiddle[0].toUpperCase() + "." + " " + lname[0].toUpperCase() + lname.slice(1);
    }
    else {
        return fname[0].toUpperCase() + fname.slice(1) + " " + lname[0].toUpperCase() + lname.slice(1);
    }
}

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

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Get office Choices
function getOfficeChoice() {

    const office = $('#add_office'); 

    $.ajax({
        type: "GET",
        url: "/backend/admin/getOffice",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            if (response.data && response.data.length > 0) {
                response.data.forEach((officeData) => {
                    let officeChoices = `
                    <option value="${officeData.office_name}">${officeData.office_name}</option>
                    `

                    office.append(officeChoices);
                });
            }
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving offices.",
            });
        }
    });
}

// Render Admins on Tables
function getAdmin() {
    let adminTable = new DataTable('#adminTable', {
        responsive: true,
        ajax: {
            type: "GET",
            url: "/backend/admin/getAdmin",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },  
            error: function() {
                notyf.error({
                    position: {x: 'right', y: 'top'},
                    duration: 2000,
                    ripple: true,
                    message: "There was an error while retrieving admin data.",
                });
            }
        },
        columns: [
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return formName(row.first_name, row.middle_name, row.last_name);
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    if (row.gender === 'Male') {
                        return `<span class="badge bg-blue text-blue-fg">${row.gender}</span>`;
                    }
                    else if (row.gender === 'Female') {
                        return `<span class="badge bg-red text-red-fg">${row.gender}</span>`;
                    }
                    else if (row.gender === 'Prefer Not to Say') {
                        return `<span class="badge bg-dark text-dark-fg">${row.gender}</span>`;
                    }
                    else{
                        return `<span class="badge bg-dark text-dark-fg">Unknown</span>`;
                    }
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return row.office_name;
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    if (row.is_master_admin == true) {
                        return `<span class="badge bg-blue text-blue-fg">True</span>`;
                    }
                    else{
                        return `<span class="badge bg-red text-red-fg">False</span>`;
                    }
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    if (row.is_technician == true) {
                        return `<span class="badge bg-blue text-blue-fg">True</span>`;
                    }
                    else{
                        return `<span class="badge bg-red text-red-fg">False</span>`;
                    }
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return `<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAdmin-modal">Edit</button>`
                }
            },
        ]
    });
}


// ----------------------------------
// Office Management
// ----------------------------------


// Render Offices on Tables
function getOffice() {
    let officeTable = new DataTable('#officeTable', {
        responsive: true,
        ajax: {
            type: "GET",
            url: "/backend/admin/getOffice",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },  
            error: function() {
                notyf.error({
                    position: {x: 'right', y: 'top'},
                    duration: 2000,
                    ripple: true,
                    message: "There was an error while retrieving office data.",
                });
            }
        },
        columns: [
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return row.office_name;
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return row.added_by;
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return formatTimestamp(row.date_added);
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return formatTimestamp(row.last_modified);
                }
            },
            { 
                data: null,
                className: 'text-center align-content-center',
                render: function(row) {
                    return `<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editOffice-modal">Edit</button>`
                }
            },
        ]
    });
}

