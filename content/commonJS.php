<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show the pre-loader
        var preloader = document.getElementById("preloader");
        preloader.style.display = "flex";

        // Hide the pre-loader after a delay (e.g., 3000 milliseconds or 3 seconds)
        setTimeout(function() {
            preloader.style.display = "none";
        }, 300); // Adjust the delay time as needed (in milliseconds)

    });
</script>

