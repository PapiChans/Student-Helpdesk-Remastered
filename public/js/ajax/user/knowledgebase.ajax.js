// Create an instance of Notyf
const notyf = new Notyf();

$(document).ready(function() {
    getFolders();
})

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');


function getFolders () {
    $.ajax({
        type: "GET",
        url: '/backend/user/getFolders',
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
        url: `/backend/user/getTopics/${folder_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            let topic_lists = $('#topic_lists');
            let topic_title = $('#topic_title');

            topic_title.html(null);

            let title =
            `
            <div class="col-12 d-flex align-content-center">
                <h2>${response.folder[0].folder_name}</h2>
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
                                <a href="/user/view/knowledgebase?k=${list.topic_id}">
                                    <h4 class="text-primary">
                                        ${list.title}
                                    </h4>
                                </a>
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