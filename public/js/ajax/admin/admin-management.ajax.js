// Create an instance of Notyf
const notyf = new Notyf();

$( document ).ready(function() {
    getOfficeChoice();
    getAdmin();
    getOffice();
});

// Preventing to Put any numbers in input type 'text'
document.querySelectorAll('input[type="text"].no-numbers').forEach(function(input) {
    input.addEventListener('input', function(event) {
        // Remove numbers from the input value
        event.target.value = event.target.value.replace(/[0-9]/g, '');
    });
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

    const add_office = $('#add_office'); 
    const edit_office = $('#edit_office'); 

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
                    <option value="${officeData.office_id}">${officeData.office_name}</option>
                    `

                    add_office.append(officeChoices);
                    edit_office.append(officeChoices);
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
                    else if (row.gender === 'Prefer not to say') {
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
                    return `
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAdmin-modal" onclick="getOneAdmin('${row.profile_id}')">Edit</button>
                    <button class="btn btn-danger" onclick="removeAdmin('${row.profile_id}', '${row.last_name}', '${row.first_name}')">Remove</button>`
                }
            },
        ]
    });
}

// Add Admin Function
$( "#registerAdminForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        last_name: $( "#add_last_name" ).val(),
        first_name: $( "#add_first_name" ).val(),
        middle_name: $( "#add_middle_name" ).val(),
        gender: $( "#add_gender" ).val(),
        email: $( "#add_email" ).val(),
        office: $( "#add_office" ).val(),
        is_technician: $( "#add_is_technician" ).prop('checked'),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#registerAdminFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/addAdmin",
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

                $('form#registerAdminForm')[0].reset();

                var modalElement = document.getElementById('addAdmin-modal');
                var modal = new bootstrap.Modal(modalElement);
                modal.hide();

                location.reload();
            }
            
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

            $('#registerAdminFormSubmit').attr('disabled', false)
        }
    });
});

// Get One Admin Data
function getOneAdmin (profile_id) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getOneAdmin/${profile_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#edit_profile_id').val(response.data.profile_id)
            $('#edit_name').html(response.data.first_name +" " + response.data.last_name)
            $('#edit_office').val(response.data.office_id)
            if (response.data.is_technician == true) {
                $('#edit_add_is_technician').prop('checked' , true)
            }
            else {
                $('#edit_add_is_technician').prop('checked' , false)
            }
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving admin.",
            });
        }
    });
}

// Edit Admin Function
$( "#editregisterAdminForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        profile_id: $( "#edit_profile_id" ).val(),
        office_id: $( "#edit_office" ).val(),
        is_technician: $( "#edit_add_is_technician" ).prop('checked')
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#editregisterAdminFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Saving...',
        background: '#f76707'
    });
    $.ajax({
        type: "PUT",
        url: `/backend/admin/editAdmin/${formData.profile_id}`,
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

                $('form#editregisterAdminForm')[0].reset();

                var modalElement = document.getElementById('editAdmin-modal');
                var modal = new bootstrap.Modal(modalElement);
                modal.hide();

                location.reload();
            }
            
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

            $('#editregisterAdminFormSubmit').attr('disabled', false)
        }
    });
});

// Remove Office
function removeAdmin (profile_id, last_name, first_name) {
    Swal.fire({
        title: 'Are you Sure?',
        text: `Do you want to remove ${first_name} ${last_name} as Admin?`,
        icon: 'question',
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#d63939',
        showCancelButton: true,  // Optionally show a cancel button
        cancelButtonText: 'Cancel',
    })
    .then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `/backend/admin/removeAdmin/${profile_id}`,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response){
                    notyf.success({
                        position: {x: 'right', y: 'top'},
                        duration: 2000,
                        ripple: true,
                        message: response.message,
                    });
    
                    location.reload();
                },
                error: function(response) {
                    if (response.responseJSON.status == 'error') {
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
                }
            });    
        }
    })
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
                    return `
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editOffice-modal" onclick="getOneOffice('${row.office_id}')">Edit</button>
                    <button class="btn btn-danger" onclick="removeOffice('${row.office_id}','${row.office_name}')">Remove</button>
                    `
                }
            },
        ]
    });
}

// Add Office Function
$( "#registerOfficeForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        office: $( "#register_office" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#registerOfficeFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/addOffice",
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

                $('form#registerOfficeForm')[0].reset();

                var modalElement = document.getElementById('addOffice-modal');
                var modal = new bootstrap.Modal(modalElement);
                modal.hide();

                location.reload();
            }
            
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

            $('#registerOfficeFormSubmit').attr('disabled', false)
        }
    });
});

// Get One Office Data
function getOneOffice (office_id) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getOneOffice/${office_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#edit_register_office_id').val(response.data.office_id)
            $('#edit_register_office').val(response.data.office_name)
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving office.",
            });
        }
    });
}

// Edit Office Function
$( "#editregisterOfficeForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        office_id: $( "#edit_register_office_id" ).val(),
        office_name: $( "#edit_register_office" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#editregisterOfficeFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Saving...',
        background: '#f76707'
    });
    $.ajax({
        type: "PUT",
        url: `/backend/admin/editOffice/${formData.office_id}`,
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

                $('form#editregisterOfficeForm')[0].reset();

                var modalElement = document.getElementById('editOffice-modal');
                var modal = new bootstrap.Modal(modalElement);
                modal.hide();

                location.reload();
            }
            
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

            $('#editregisterOfficeFormSubmit').attr('disabled', false)
        }
    });
});

// Remove Office
function removeOffice (office_id, office_name) {
    Swal.fire({
        title: 'Are you Sure?',
        text: `Do you want to remove ${office_name}`,
        icon: 'question',
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#d63939',
        showCancelButton: true,  // Optionally show a cancel button
        cancelButtonText: 'Cancel',
    })
    .then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `/backend/admin/removeOffice/${office_id}`,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response){
                    notyf.success({
                        position: {x: 'right', y: 'top'},
                        duration: 2000,
                        ripple: true,
                        message: response.message,
                    });
    
                    location.reload();
                },
                error: function(response) {
                    if (response.responseJSON.status == 'error') {
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
                }
            });    
        }
    })
}