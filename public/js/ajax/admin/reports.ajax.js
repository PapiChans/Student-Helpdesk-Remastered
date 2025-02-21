// Create an instance of Notyf
const notyf = new Notyf();

// Get CSRF token from meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Flatpickr
flatpickr("#selectMonth", {
    maxDate: "today",
    dateFormat: "Y-m",
    mode: "single",
  });