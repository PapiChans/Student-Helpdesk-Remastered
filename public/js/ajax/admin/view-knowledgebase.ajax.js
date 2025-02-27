// Create an instance of Notyf
const notyf = new Notyf();

$(document).ready(function() {
    getFolderChoice();
    getTopicInfo(topic_id);
})

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// This will search the Ticket from the URL Parameter
const searchParams = new URLSearchParams(window.location.search);
const topic_id = searchParams.get('k');


// Get Folder Choices
function getFolderChoice() {

    const edit_topic_folder = $('#edit_topic_folder'); 

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

                    edit_topic_folder.append(folderChoices);
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

function getTopicInfo(topic_id) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getTopicInfo/${topic_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#edit_content').val(response.data.content);
            $('#edit_title').val(response.data.title);
            $('#edit_topic_folder').val(response.data.folder_id);
            $('#edit_status').val(response.data.status);
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving topic info.",
            });

            setTimeout(() => {
                window.location.href = '/admin/knowledgebase';
            }, 1000)
        }
    });
}

// Edit Topic Function
$( "#editTopicForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        title: $( "#edit_title" ).val(),
        content: $( "#edit_content" ).val(),
        folder_id: $( "#edit_topic_folder" ).val(),
        status: $( "#edit_status" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#editTopicFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Saving...',
        background: '#f76707'
    });
    $.ajax({
        type: "PUT",
        url: `/backend/admin/editTopic/${topic_id}`,
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

                $('form#editTopicForm')[0].reset();

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

            $('#editTopicFormSubmit').attr('disabled', false)
        }
    });
});

// Preview Function
function preview() {
    let preview_area = $( "#preview-area" );

    let content =  $( "#edit_content" ).val();

    preview_area.html(null);

    var converter = new showdown.Converter(),
    text      = content,
    html      = converter.makeHtml(text);

    preview_area.append(html)
}

// Delete Folder
function deleteTopic() {
    Swal.fire({
        title: 'Deleting Topic?',
        text: `Do you want to delete this Topic?`,
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
                url: `/backend/admin/deleteTopic/${topic_id}`,
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
    
                    window.location.href = '/admin/knowledgebase';
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