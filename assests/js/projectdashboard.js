var sidebarExpand = true;
function sideBarControl() {
  if (sidebarExpand == false) {
    // ==== side bar expand =====
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
    
    sidebarExpand = true;

  } else {
    // ===== Side bar small ====
    document.getElementById("main").style.marginLeft = "80px";
    document.getElementById("mySidebar").style.width = "80px";
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("openNav").style.display = "block";
    // document.getElementById("user-img").st yle.margin = "auto";
    
    document.getElementById("openNav").setAttribute("name","chevron-forward-circle-outline");
    
    var elememts = document.getElementsByClassName("sideBar-btn-text");
    for(var i=0;i<elememts.length;i++){
      document.getElementsByClassName("sideBar-btn-text")[i].style.display = "none";
    }
    document.getElementById("user-name").style.display = "none";
    
    sidebarExpand = false;
  }
}

function showMenuContent(menuNo){
  document.getElementsByClassName("activate")[0].classList.remove("activate");
  document.getElementsByClassName("show")[0].classList.add("hide");
  document.getElementsByClassName("show")[0].classList.remove("show");
  document.getElementById("menu-"+menuNo).classList.add("activate");
  document.getElementById("menu-content-"+menuNo).classList.remove("hide");
  document.getElementById("menu-content-"+menuNo).classList.add("show");
}
