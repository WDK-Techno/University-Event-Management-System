function handleWindowSizeChange(x) {
    if (x.matches) {
      // Code for small devices (max-width: 700px)
      document.body.style.backgroundColor = "yellow";
      // Add more code specific to small devices here
    } else if (y.matches) {
      // Code for medium devices (max-width: 1000px)
      document.body.style.backgroundColor = "blue";
      // Add more code specific to medium devices here
    } else {
      // Default code for larger devices
      document.body.style.backgroundColor = "pink";
      // Add more code for larger devices here
    }
  }
  
  // Create media queries for different device sizes
  var x = window.matchMedia("(max-width: 700px)");
  var y = window.matchMedia("(max-width: 1000px)");
  
  // Call the function to apply initial styles based on the current window size
  handleWindowSizeChange(x);
  handleWindowSizeChange(y);
  
  // Attach listener functions to handle state changes
  x.addListener(function(event) {
    handleWindowSizeChange(x);
  });
  
  y.addListener(function(event) {
    handleWindowSizeChange(y);
  });
  