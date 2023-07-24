sidebarExpand = true;
function sideBarControl() {
  if (sidebarExpand == false) {
    document.getElementById("main").style.marginLeft = "280px";
    document.getElementById("mySidebar").style.width = "280px";
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("openNav").style.display = "block";

    sidebarExpand = true;
  } else {
    document.getElementById("main").style.marginLeft = "80px";
    document.getElementById("mySidebar").style.width = "80px";
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("openNav").style.display = "block";

    sidebarExpand = false;
  }
}
