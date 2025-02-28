// Create an instance of Notyf
const notyf = new Notyf();

$(document).ready(function() {
    getTopicInfo(topic_id);
})

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// This will search the Ticket from the URL Parameter
const searchParams = new URLSearchParams(window.location.search);
const topic_id = searchParams.get('k');


function getTopicInfo(topic_id) {
    $.ajax({
        type: "GET",
        url: `/backend/user/getTopicInfo/${topic_id}`,
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#topic_folder').html(response.data[0].folder);
            $('#topic_title').html(response.data[0].title);
            
            var converter = new showdown.Converter(),
            text      = response.data[0].content,
            html      = converter.makeHtml(text);
            
            $('#topic_content').html(html);
        },
        error: function(x) {
            console.log(x)
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving topic info.",
            });

            // setTimeout(() => {
            //     window.location.href = '/user/knowledgebase';
            // }, 1000)
        }
    });
}