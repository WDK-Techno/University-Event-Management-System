$(document).ready(function() {
    // When "Accept" button is clicked
    $("#acceptButton").click(function() {
        // Show the confirmation modal
        $("#confirmModal").modal("show");
    });


     // When "No" button is clicked in the modal
     $("#confirmNo").click(function() {
        // Perform your desired action here after confirming
        // For example: send a request to the server or update data

        // Close the modal
        $("#confirmModal").modal("hide");
    });
});