// Create an instance of Notyf
const notyf = new Notyf();

$(document).ready(function() {
    getFolders();
    getFolderChoice();
})

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Get Folder Choices
function getFolderChoice() {

    const topic_folder = $('#topic_folder'); 

    $.ajax({
        type: "GET",
        url: "/backend/admin/getFolders",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            if (response.data && response.data.length > 0) {
                response.data.forEach((folderData) => {
                    let folderChoices = `
                    <option value="${folderData.folder_id}">${folderData.folder_name}</option>
                    `

                    topic_folder.append(folderChoices);
                });
            }
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving folders.",
            });
        }
    });
}

// Add Folder Function
$( "#addFolderForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        folder_name: $( "#add_folder" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#addFolderFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/addFolder",
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

                $('form#addFolderForm')[0].reset();

                var modalElement = document.getElementById('addFolder-modal');
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

            $('#addFolderFormSubmit').attr('disabled', false)
        }
    });
});

function getFolders () {
    $.ajax({
        type: "GET",
        url: '/backend/admin/getFolders',
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            let folder_lists = $('#folder_lists');

            if (response.data.length > 0) {
                // Loop through each comment in the array
                response.data.forEach(function(list) {
        
                    let layout =
                        `
                        <div class="card">
                            <div class="card-body">
                                    <h4 class="text-primary" style="cursor:pointer;" onclick="getTopics('${list.folder_id}')">
                                        ${list.folder_name}
                                    </h4>
                            </div>
                        </div>
                        `;
        
                        folder_lists.append(layout);
                        
                    });
            }
            else {
                let folder_lists = $('#folder_lists');

                let layout =
                    `
                        <h4 class="text-primary">
                            No Folders Available
                        </h4>
                    `;
    
                    folder_lists.append(layout);
            }
        },        
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving folders info.",
            });
        }
    });
}

function getTopics (folder_id) {
    let topic_lists = $('#topic_lists');
    topic_lists.html(null);

    $.ajax({
        type: "GET",
        url: `/backend/admin/getTopics/${folder_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            let topic_lists = $('#topic_lists');
            let topic_title = $('#topic_title');

            topic_title.html(null);

            let title =
            `
            <div class="col-9 d-flex align-content-center">
                <h2>${response.folder[0].folder_name}</h2>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editFolder-modal" onclick="getFolderInfo('${response.folder[0].folder_id}')">Edit</button>
                <button class="btn btn-danger m-1" onclick="deleteFolder('${response.folder[0].folder_id}')">Delete</button>
            </div>
            `
            
            topic_title.append(title);
            
            if (response.data.length > 0) {
                // Loop through each comment in the array
                response.data.forEach(function(list) {
        
                    let layout =
                        `
                        <div class="card m-1" style="cursor:pointer;">
                            <div class="card-body">
                                    <h4 class="text-primary" onclick="getShabu()">
                                        ${list.title}
                                    </h4>
                            </div>
                        </div>
                        `;
        
                        topic_lists.append(layout);

                });
            }
            else {
                let topic_lists = $('#topic_lists');

                let layout =
                    `
                        <div class="d-flex justify-content-center mt-5">
                            <h2>No Topics Available.</h2>
                        </div>
                    `;
    
                    topic_lists.append(layout);
            }
        },        
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving topics info.",
            });
        }
    }); 
}

function getFolderInfo(folder_id) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getFolderInfo/${folder_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#edit_folder_id').val(response.data.folder_id)
            $('#edit_folder').val(response.data.folder_name);
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving folder info.",
            });
        }
    });
}

// Edit Folder Function
$( "#editFolderForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();
    
    const folder_id = $( "#edit_folder_id" ).val();

    var formData = {
        folder_name: $( "#edit_folder" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#editFolderFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Saving...',
        background: '#f76707'
    });
    $.ajax({
        type: "PUT",
        url: `/backend/admin/editFolder/${folder_id}`,
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

                $('form#editFolderForm')[0].reset();

                var modalElement = document.getElementById('editFolder-modal');
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

            $('#editFolderFormSubmit').attr('disabled', false)
        }
    });
});

// Delete Folder
function deleteFolder(folder_id) {
    Swal.fire({
        title: 'Deleting Folder?',
        text: `Do you want to delete this Folder?`,
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
                url: `/backend/admin/deleteFolder/${folder_id}`,
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

// ------------------------------------------
// Topic Section
// ------------------------------------------

// Add Folder Function
$( "#addTopicForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        folder_id: $(" #topic_folder ").val(),
        topic_name: $( "#add_topic" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#addTopicFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/addTopic",
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

                $('form#addTopicForm')[0].reset();

                var modalElement = document.getElementById('addTopic-modal');
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

            $('#addTopicFormSubmit').attr('disabled', false)
        }
    });
});