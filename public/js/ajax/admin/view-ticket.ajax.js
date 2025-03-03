// Create an instance of Notyf
const notyf = new Notyf();

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// This will search the Ticket from the URL Parameter
const searchParams = new URLSearchParams(window.location.search);
const ticket_number = searchParams.get('t');

$( document ).ready(function() {
    getTicketInfo(ticket_number);
    $('#comment_Submit').attr('disabled', true)
});


// Get office Choices
function getOfficeChoice() {

    const add_office = $('#re_assign_office'); 

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

                // Check if the Admin is an Maser Admin  / Technician for Changing office function
                if (response.admin == false) {
                    let showChangeOffice = $('#showChangeOffice');
                        showChangeOffice.html(null);
                }
                else {
                    getOfficeChoice();
                }

                // Check the Status of the Ticket for Resolved button
                if (response.data[0].status == 'Resolved' || response.data[0].status == 'Closed') {
                    let show_resolved_button = $('#show-resolved-button');
                    show_resolved_button.html(null);

                    // Also call a function where it closes the Comment form
                    changeForm(response.data[0].status);
                }
                else {
                    let resolve_Button = $('#resolve_Button');

                    resolve_Button.attr('disabled', false);
                }

                // Disables the Submit Comment Button
                $('#comment_Submit').attr('disabled', false)
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

// Resolved Ticket
function resolveTicket() {
    Swal.fire({
        title: 'Resolving Ticket?',
        text: `Do you want to resolved this Ticket?`,
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
                type: "PUT",
                url: `/backend/admin/resolveTicket/${ticket_number}`,
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
                    console.log(response)
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

// Closed Ticket
function closeTicket() {
    Swal.fire({
        title: 'Close Ticket?',
        text: `Do you want to close this Ticket?`,
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
                type: "PUT",
                url: `/backend/admin/closeTicket/${ticket_number}`,
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
                    console.log(response)
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

// Change forms
function changeForm(status) {
    let formshoworhide = $('#formshoworhide');
    formshoworhide.html(null);
    resolved_layout = `
    <div class="justify-content-center">
        <div class="col-12 justify-content-center d-flex">
            <h3>Ticket Resolved.</h3>
        </div>
        <div class="col-12 justify-content-center d-flex">
            <p>The client will informed in this action.</p>
        </div>
        <div class="row">
            <div class="col-12 justify-content-center d-flex">
                <a class="btn btn-info m-1" data-bs-toggle="offcanvas" href="#trailOffCanvas" role="button" aria-controls="offcanvasEnd">View trail</a>
                <button class="btn btn-success m-1" id="close_Button" onclick="closeTicket()">Close Ticket</button>
                <button class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#rateTicket-modal">Ratings</button>
            </div>
        </div>
    </div>
    `
    closed_layout = `
    <div class="justify-content-center">
        <div class="col-12 justify-content-center d-flex">
            <h3>Ticket Closed.</h3>
        </div>
        <div class="col-12 justify-content-center d-flex">
            <p>This Ticket is now closed.</p>
        </div>
        <div class="col-12 justify-content-center d-flex">
            <a class="btn btn-info m-1" data-bs-toggle="offcanvas" href="#trailOffCanvas" role="button" aria-controls="offcanvasEnd">View trail</a>
            <button class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#rateTicket-modal">Ratings</button>
        </div>
    </div>
    `
    if (status == 'Resolved') {
        formshoworhide.append(resolved_layout)
    }
    else if (status == 'Closed') {
        formshoworhide.append(closed_layout)
    }

    checkTicketRatings(ticket_number);
}

// Change Office Function
$( "#reassignOfficeForm" ).submit(function( event ) {
    // Prevent the form from submitting
    event.preventDefault();

    var formData = {
        ticket_id: $(" #ticket_Id_info").val(),
        office_id: $( "#re_assign_office" ).val(),
    };

    // Check if the form is valid using HTML5 validation
    if (!this.checkValidity()) {
        return;  // Stop further execution
    }

    // This disables the button
    $('#reassignOfficeFormSubmit').attr('disabled', true)

    notyf.open({
        position: {x: 'right', y: 'top'},
        duration: 2000,
        ripple: true,
        message: 'Saving...',
        background: '#f76707'
    });
    $.ajax({
        type: "POST",
        url: "/backend/admin/changeTicketOffice",
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

                $('form#reassignOfficeForm')[0].reset();

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

            $('#reassignOfficeFormSubmit').attr('disabled', false)
        }
    });
});

// Custom function to add text fro ticket rating
function RatingConvert(number) {
    let RatingSpan = null;
    if (number == 1) {
        RatingSpan = `<span class="text-danger">${number} - Poor</span>`
    }
    else if (number == 2) {
        RatingSpan = `<span class="text-danger">${number} - Fair</span>`
    }
    else if (number == 3) {
        RatingSpan = `<span class="text-warning">${number} - Average</span>`
    }
    else if (number == 4) {
        RatingSpan = `<span class="text-info">${number} - Good</span>`
    }
    else if (number == 5) {
        RatingSpan = `<span class="text-success">${number} - Excellent</span>`
    }

    return RatingSpan;
}

function checkTicketRatings(ticket_number) {
    $.ajax({
        type: "GET",
        url: `/backend/admin/checkTicketRatings/${ticket_number}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            if (response.found == true) {
                let ratingData = response.rating;
                let evalData = response.evaluation;
                let Ratingremarks = ratingData.remarks ? ratingData.remarks : '';
                let Evalremarks = evalData.remarks ? evalData.remarks : '';


                $('#rateTicketFormSubmit').attr('disabled', true)
                let ticket_rate_body = $('#ticket_rate_body');
    
                ticket_rate_body.html(null);
    
                let layoutItem =
                    `
                    <div class="alert alert-success" role="alert">
                            <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2"><path d="M5 12l5 5l10 -10"></path></svg>
                            </div>
                                <div>
                                    This ticket has been rated.
                                </div>
                            </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ticket Rating</label>
                        <div class="input-group mb-2">
                            <h4>Rating: ${RatingConvert(ratingData.rating)}</h4>
                        </div>
                        <div class="input-group mb-2">
                            <h4>Remarks: ${Ratingremarks}</h4>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Evaluation</label>
                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>A. Responsiveness: The willingness to help, assist, and provide prompt service to citizens/clients:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QA)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>B. Reliability(Quality): Provision of what was promised with zero to a minimal error:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QB)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>C. Access & Facilities: The convenience of location, ample amenities for comfortable transactions:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QC)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>D. Communication: The act of keeping clients informed in a language they can easily understand:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QD)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>E. Costs: The satisfaction with timeliness of the billing, billing process/es:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QE)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>F. Integrity: Assurance that there is honesty, justice, fairness, and trust in service:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QF)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>G. Assurance: The capability of frontline staff to perform their duties:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QG)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-9">
                                    <h4>H. Outcome: Extent of achieving outcomes or realizing the intended benefits of government services:</h4>
                                </div>
                                <div class="col-3">
                                    <h3>${RatingConvert(evalData.QH)}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="col-12 row">
                                <div class="col-1">
                                    <h4>Remarks:</h4>
                                </div>
                                <div class="col-11">
                                    <h4>${Evalremarks}</h4>
                                </div>
                            </div>
                        </div>

                    </div>
                    `;
    
                ticket_rate_body.append(layoutItem);
            }
            else {
                $('#rateTicketFormSubmit').attr('disabled', false)
            }

        },        
        error: function(x) {
            console.log(x)
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving rate info.",
            });
        }
    }
)};