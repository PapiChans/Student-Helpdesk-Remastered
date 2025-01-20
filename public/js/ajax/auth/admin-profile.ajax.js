$( document ).ready(function() {
    getProfile();
});

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Forming Letter Function
function formName(fname, mname, lname) {
    const getmiddle = mname;
    if (getmiddle) {
        return fname[0].toUpperCase() + fname.slice(1) + " " + getmiddle[0].toUpperCase() + "." + " " + lname[0].toUpperCase() + lname.slice(1);
    }
    else {
        return fname[0].toUpperCase() + fname.slice(1) + " " + lname[0].toUpperCase() + lname.slice(1);
    }
}

function getProfile () {
    $.ajax({
        type: "GET",
        url: "/backend/admin/getProfile",
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
        },
        success: function(response){
            $('#profile_name').html(formName(response.data.first_name, response.data.middle_name, response.data.last_name));
            $('#office').html(response.office_name)
        },
        error: function() {
            notyf.error({
                position: {x: 'right', y: 'top'},
                duration: 2000,
                ripple: true,
                message: "There was an error while retrieving profile.",
            });
        }
    });
}