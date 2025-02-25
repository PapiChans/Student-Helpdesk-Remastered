// Create an instance of Notyf
const notyf = new Notyf();

$(document).ready(function() {
    getFolders();
})

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

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
                                    <h4 class="text-primary" onclick="getTopics('${list.folder_id}')">
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
            
            if (response.data.length > 0) {
                // Loop through each comment in the array
                response.data.forEach(function(list) {
        
                    let layout =
                        `
                        <div class="card">
                            <div class="card-body">
                                    <h4 class="text-primary" onclick="get()">
                                        ${list.topic_name}
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
                        <div class="d-flex justify-content-center">
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