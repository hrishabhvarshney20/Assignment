window.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('healthReportForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(form);

        // Send form data to PHP file for processing
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'process_form.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Form submission successful
                console.log(xhr.responseText);
                // Reset the form
                form.reset();
            } else {
                // Form submission failed
                console.error('Form submission failed. Error code:', xhr.status);
            }
        };
        xhr.send(formData);
    });
});
