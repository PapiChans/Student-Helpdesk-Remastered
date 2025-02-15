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

// Time difference Function
function formatTimeAgo(timestamp) {
    var currentTime = new Date();
    var jsDate = new Date(timestamp);
    var timeDifference = currentTime.getTime() - jsDate.getTime();

    var secondsDifference = Math.floor(timeDifference / 1000);
    var minutesDifference = Math.floor(secondsDifference / 60);
    var hoursDifference = Math.floor(minutesDifference / 60);
    var daysDifference = Math.floor(hoursDifference / 24);
    var weeksDifference = Math.floor(daysDifference / 7);
    var monthsDifference = Math.floor(daysDifference / 30);
    var yearsDifference = Math.floor(daysDifference / 365);

    var result;
    if (yearsDifference > 0) {
        result = yearsDifference + (yearsDifference === 1 ? " year ago" : " years ago");
    } else if (monthsDifference > 0) {
        result = monthsDifference + (monthsDifference === 1 ? " month ago" : " months ago");
    } else if (weeksDifference > 0) {
        result = weeksDifference + (weeksDifference === 1 ? " week ago" : " weeks ago");
    } else if (daysDifference > 0) {
        result = daysDifference + (daysDifference === 1 ? " day ago" : " days ago");
    } else if (hoursDifference > 0) {
        result = hoursDifference + (hoursDifference === 1 ? " hour ago" : " hours ago");
    } else if (minutesDifference > 0) {
        result = minutesDifference + (minutesDifference === 1 ? " minute ago" : " minutes ago");
    } else {
        result = "Just now";
    }

    return result;
}

// Get One Office Data
function getTicketInfo (ticket_number) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getTicketInfo/${ticket_number}`,
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
                
                $('#comment_ticket_Id').val(response.data[0].ticket_id);

                // Get the Comments
                getTicketComment(ticket_number);
                // Get the Trails
                getTicketTrails(ticket_number);
                
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
                    window.location.href = '/admin/ticket';
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

            setTimeout(() => {
                window.location.href = '/admin/ticket';
            }, 1000)
        }
    });
}

// Add Comment Function
$( "#AddCommentForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        ticket_id: $( "#comment_ticket_Id" ).val(),
        comment: $( "#comment_Text" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#comment_Submit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Adding...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/addTicketComment",
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

                $('form#AddCommentForm')[0].reset();

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

            $('#comment_Submit').attr('disabled', false)
        }
    });
});

function getTicketComment (ticket_number) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getTicketComment/${ticket_number}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            let chat_display = $('#chat_display');
            
            if (response.data.length > 0) {
                // Loop through each comment in the array
                response.data.forEach(function(comment) {
                    let text = (comment.comment)?.replace(/\n/g, '</p><p>');
        
                    let userchat =
                        `
                        <div class="chat-item mb-3">
                            <div class="row align-items-end justify-content-end">
                                <div class="col col-lg-6">
                                    <div class="card bg-primary-lt">
                                        <div class="card-body">
                                            <div class="chat-bubble-title">
                                                <div class="row mb-2">
                                                    <div class="col chat-bubble-author text-black"></div>
                                                    <div class="col-auto chat-bubble-date text-black">${formatTimestamp(comment.created_at)} (${formatTimeAgo(comment.created_at)})</div>
                                                </div>
                                            </div>
                                            <div class="chat-bubble-body text-black">
                                                <p>${text}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
        
                    let adminchat =
                        `
                        <div class="chat-item mb-3">
                            <div class="row align-items-end">
                                <div class="col col-lg-6">
                                    <div class="card bg-secondary-lt">
                                        <div class="card-body">
                                            <div class="chat-bubble-title">
                                                <div class="row mb-2">
                                                    <div class="col chat-bubble-author text-black"></div>
                                                    <div class="col-auto chat-bubble-date text-black">${formatTimestamp(comment.created_at)} (${formatTimeAgo(comment.created_at)})</div>
                                                </div>
                                            </div>
                                            <div class="chat-bubble-body text-black">
                                                <p>${text}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
        
                    // Compare comment.user_id with the current user_id
                    if (comment.user_id == response.user_id) {
                        chat_display.append(userchat);
                    } else {
                        chat_display.append(adminchat);
                    }
                });
            }
        },        
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving comment info.",
            });
        }
    });
}

function getTicketTrails(ticket_number) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/getAuditTrails/${ticket_number}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            let trail_list = $('#trail-list');

            if (response.data.length > 0) {
                // Loop through each comment in the array
                response.data.forEach(function(trail) {
        
                    let trailItem =
                        `
                        <div class="card-body">
                            <p class="h4 text-primary">${trail.action}</p>
                            <p class="h5">${trail.description}</p>
                            <p class="h5">${formatTimestamp(trail.created_at)}</p>
                        </div>
                        `;

                    trail_list.append(trailItem);
                });
            }

        },        
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving trails info.",
            });
        }
    }
)};