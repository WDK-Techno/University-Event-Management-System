$(document).ready(function() {
    // When "Accept" button is clicked
    $("#acceptButton").click(function() {
        // Show the confirmation modal
        $("#confirmModal").modal("show");
    });

     /// When "Decline" button is clicked
     $("#declineButton").click(function() {
        
        // Show the confirmation modal for Decline
        $("#declineModal").modal("show");
    });


   
     // When "No" button is clicked in the modal
     $("#no").click(function() {
        // Perform your desired action here after confirming
        // For example: send a request to the server or update data

        // Close the modal
        $("#confirmModal").modal("hide");
    });

    // When "No" button is clicked in the Decline modal
    $("#decline").click(function() {
        // Perform your desired action for Decline
        // For example: send a request to the server or update data

        // Close the modal
        $("#declineModal").modal("hide")
    });
    
});






    