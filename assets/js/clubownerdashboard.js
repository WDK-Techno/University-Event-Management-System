var sidebarExpand;
var firstTime = true;
var deviceSizeIsSmalle;
// real time device size handler function
function handleWindowSizeChange(x) {
  if (x.matches) {
    // small devices (max-width: 700px)
    if(firstTime){
      //when smaller devices load first time
      sidebarExpand = false;
      document.getElementById("openNav").setAttribute("name","chevron-forward-circle-outline");
      firstTime = false;
    }
    deviceSizeIsSmalle= true;

  }else {
    if(firstTime){
      // when larger device load first time
      sidebarExpand = true;
      firstTime =false;
    }
    deviceSizeIsSmalle= false;
  }
}




function sideBarControl() {
  // ==== side bar expanding =====
  if (sidebarExpand == false) {
   // ====== side bar expanding for smaller devices =====
    if(deviceSizeIsSmalle){
      document.getElementById("main").style.marginLeft = "80px";
      document.getElementById("mySidebar").style.width = "280px";
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("openNav").style.display = "block";
      
      document.getElementById("openNav").setAttribute("name","chevron-back-circle-outline");

      var elememts = document.getElementsByClassName("sideBar-btn-text");
      for(var i=0;i<elememts.length;i++){
        document.getElementsByClassName("sideBar-btn-text")[i].style.display = "block";
      }
      document.getElementById("user-name").style.display = "block";
      document.getElementById("project-details").style.display = "block";
      
      sidebarExpand = true;

    }
    // ====== side bar expanding for lager devices =====
    else{
      document.getElementById("main").style.marginLeft = "280px";
      document.getElementById("mySidebar").style.width = "280px";
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("openNav").style.display = "block";
      
      document.getElementById("openNav").setAttribute("name","chevron-back-circle-outline");

      var elememts = document.getElementsByClassName("sideBar-btn-text");
      for(var i=0;i<elememts.length;i++){
        document.getElementsByClassName("sideBar-btn-text")[i].style.display = "block";
      }
      document.getElementById("user-name").style.display = "block";
      document.getElementById("project-details").style.display = "block";
      
      sidebarExpand = true;
    }
    

  } else {
    // ===== Side bar smalling ====
    document.getElementById("main").style.marginLeft = "80px";
    document.getElementById("mySidebar").style.width = "80px";
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("openNav").style.display = "block";
    
    document.getElementById("openNav").setAttribute("name","chevron-forward-circle-outline");
    
    var elememts = document.getElementsByClassName("sideBar-btn-text");
    for(var i=0;i<elememts.length;i++){
      document.getElementsByClassName("sideBar-btn-text")[i].style.display = "none";
    }
    document.getElementById("user-name").style.display = "none";
    document.getElementById("project-details").style.display = "none";
    
    sidebarExpand = false;
  }
  
}


// Create media queries for different device sizes
var x = window.matchMedia("(max-width: 768px)");
// Call the function to apply initial styles based on the current window size
handleWindowSizeChange(x);
// Attach listener functions to handle state changes
x.addListener(function(event) {
  handleWindowSizeChange(x);
});



// ========= change main content =========
function showMenuContent(menuNo){
  document.getElementsByClassName("activate")[0].classList.remove("activate");
  document.getElementsByClassName("show")[0].classList.add("hide");
  document.getElementsByClassName("show")[0].classList.remove("show");
  document.getElementById("menu-"+menuNo).classList.add("activate");
  document.getElementById("menu-content-"+menuNo).classList.remove("hide");
  document.getElementById("menu-content-"+menuNo).classList.add("show");
}
