<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

require_once 'classes/DBConnector.php';
require_once "classes/User.php";


use classes\DBConnector;
use classes\Club;
use classes\Undergraduate;

$con = DBConnector::getConnection();

$undergraduate = new Undergraduate('','','','','','');
$user1= $undergraduate->getUndergraduates($con);

$club = new Club('','','','');
$user2 = $club->getClubs($con);
$user3 = $club->getRequests($con);
$user4 = $club->getRowCount($con);

?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $selected_menuNo = 1;
    if (isset($_GET['tab'])) {
        $selected_menuNo = $_GET['tab'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assests/scss/style.scss"> -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="assets/css/projectdashboard.css">
    <link rel="stylesheet" href="assets/css/admindashboard.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- ===== Boostrap CSS ==== -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


</head>

<body style="box-sizing: border-box;">

<!-- =======  side bar ======= -->
<div class="sideBar w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:block;" id="mySidebar">


    <!-- ======== side bar content ======= -->
    <div class="d-flex flex-column flex-shrink-0 p-3">

        <ion-icon id="openNav" class="d-block m-2" onclick="sideBarControl()"
                  name="chevron-back-circle-outline"></ion-icon>

        <!-- <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 m-2">Sidebar</span>
        </a> -->

        <div id="project-details" class="my-2" style="font-weight:bold; font-size: 1.5rem;">
            <span class="d-block w3-text-light-blue">Super Admin</span>
            <span class="d-block w3-text-cyan">Dashboard</span>
        </div>

        <hr>
        <ul class="nav nav-pills flex-column navbar-text mb-auto">
            <li id="menu-1" class="sideBar-btn" onclick="showMenuContent(1)">
                <a href="#" class="nav-link d-flex justify-content-start">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <span class="sideBar-btn-text my-auto">Undergraduates</span>
                </a>
            </li>
            <li id="menu-2" class="sideBar-btn" onclick="showMenuContent(2)">
                <a href="#" class="nav-link d-flex justify-content-start">
                    <ion-icon name="document-outline"></ion-icon>
                    <span class="sideBar-btn-text my-auto">Club/Society</span>
                </a>
            </li>
            <li id="menu-3" class="sideBar-btn" onclick="showMenuContent(3)">
                <a href="#" class="nav-link d-flex justify-content-start">
                    <ion-icon name="git-pull-request-outline"></ion-icon>
                    <span class="sideBar-btn-text my-auto">New Clubs</span>
                </a>
            </li>

            <!-- <li id="menu-5" class="sideBar-btn" onclick="showMenuContent(5)">
                <a href="#" class="nav-link d-flex justify-content-start">
                    <ion-icon name="settings-outline"></ion-icon>
                    <span class="sideBar-btn-text my-auto">Settings</span>
                </a>
            </li> -->
        </ul>
        <hr>
    </div>
</div>
<!-- ============== main content ===================== -->
<div id="main" style="height: 100vh;">

    <!-- ======= Navigation Bar =======    -->
    <div class="">
        <div class="navbar navbar-light bg-light container-fluid px-4 d-flex justify-content-between">
            <a class="navbar-brand text-primary d-none d-sm-block" href="index.html">UWU<span
                        class="text-dark">Event</span><span class="text-warning">z</span></a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->

            <div class="d-flex" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> -->
                </ul>

                <a href="superadmindashboard.php?tab=3"><div class="bell-notification" current-count="<?php echo $user4 ;?>">
                    <ion-icon name="notifications-outline"></ion-icon></a>
    
                </div>
                <form action="process/logout.php" method="post">
                    <button class="my-2 btn btn-outline-secondary d-flex align-items-center" type="submit" name="submit5"><Span
                                class="d-none d-lg-inline pe-2">Logout</Span>
                        <ion-icon style="font-size: 1.3rem;"
                                  name="log-out-outline"></ion-icon>
                    </button>
                </form>
                <!--                    <div class="btn-group ms-auto me-0">-->
                <!--                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"-->
                <!--                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--                            <img id="user-img" src="https://github.com/mdo.png" alt="" width="40"-->
                <!--                                class="rounded-circle">-->
                <!--                        </a>-->
                <!--                        <ul class="dropdown-menu shadow dropdown-menu-end">-->
                <!--                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Userboard</span><ion-icon-->
                <!--                                    name="arrow-undo-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>-->
                <!--                            </li>-->
                <!--                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Profile</span><ion-icon-->
                <!--                                    name="person-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon></li>-->
                <!--                            <li>-->
                <!--                                <hr class="dropdown-divider">-->
                <!--                            </li>-->
                <!--                            <li class="dropdown-item d-flex justify-content-start px-4" type="button">-->
                <!--                                <span>Logout</span><ion-icon name="log-out-outline" class="ms-auto"-->
                <!--                                    style="font-size: 1.2rem;"></ion-icon></li>-->
                <!--                        </ul>-->
                <!--                    </div>-->
            </div>
        </div>
    </div>


    <div id="menu-content-1" class="main-content hide">
        <h1 class="text-center fw-bold">Undergraduates Details</h1>
        <section class="table_header mx-auto"; style="color:#1D2561">
            <div>
                <input type="text" id="myInput" placeholder="Search for names..." onkeyup="searchUndergrad();">
                <ion-icon name="search-outline"></ion-icon>
            </div>
        </section>
        <div class="table-2 mx-auto">
            <section class="table_body">
                <table id="myTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th class="text-center">Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    foreach ($user1 as $users) {
                        if($users->status !== "delete"){

                        ?>
                        <tr>
                            <td><img class="shadow-sm" src="assets/images/profile_img/ug/<?php echo $users->profile_image; ?>" style="border-radius:50%; width:46px; height:46px"></td>
                            <td><?php echo $users->first_name; ?> <?php echo $users->last_name; ?></td>
                            <td><?php echo $users->user_name; ?></td>
                            <td><?php echo $users->contact_no; ?></td>
                            <td>
                             
                            <?php
                                if($users->status == "active"){
                                   echo "<a class='my-auto btn btn-outline-success' href='process/admindashboard/status.php?user_id=$users->user_id&status=deactive' style='text-decoration:none;'>Active</a>";
                                }elseif($users->status == "deactive"){
                                   echo "<a class='my-auto btn btn-outline-warning' href='process/admindashboard/status.php?user_id=$users->user_id&status=active'  style='text-decoration:none;'>Deactive</a>";
                                }
                                 
                            ?>
                              
                              
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary "
                                        style="border: none;width: 96px;height: 38px;">Edit
                                </button>
                            </td>
                
                            <td>
                            <form action="process/admindashboard/ugdelete.php" method="post">
                                                <input type="hidden" name="user_id" value="<?php echo $users->user_id; ?>">
                                <button type="submit" class="btn btn-danger "
                                        style="border: none;width: 96px;height: 38px;">Delete
                                </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    
                        }                       
                    }
                    ?>
                    </tbody>
                </table>

            </section>

        </div>
    </div>
    <div id="menu-content-2" class="main-content hide">
        <h1 class="text-center fw-bold">Club Details</h1>
        <section class="table_header mx-auto">
            <div>
                <input type="text" id="clubInput" placeholder="Search for names..." onkeyup="searchClub();">
                <ion-icon name="search-outline"></ion-icon>
            </div>
        </section>
        <div class="table-2 mx-auto">
            <section class="table_body">
                <table id="clubTable">
                    <thead>
                    <tr>
                        
                        <th></th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Contact No</th>
                        <th>description</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    foreach ($user2 as $users) {
                        ?>
                        <tr>
                            <td><img class="img-thumbnail shadow-sm" src="assets/images/profile_img/club/<?php echo $users->profile_image; ?>" style="border-radius:50%; width:46px; height:46px"></td>
                            <td><?php echo $users->name; ?></td>
                            <td><?php echo $users->user_name; ?></td>
                            <td><?php echo $users->contact_no; ?></td>
                            <td><?php echo $users->description; ?></td>
                            <td>
                            <?php
                                 if($users->status == "active"){
                                    echo "<a class='my-auto btn btn-outline-success' href='process/admindashboard/clubStatus.php?user_id=$users->user_id&status=deactive' style='text-decoration:none;'>Active</a>";
                                 }elseif($users->status == "deactive"){
                                    echo "<a class='my-auto btn btn-outline-warning' href='process/admindashboard/clubStatus.php?user_id=$users->user_id&status=active' style='text-decoration:none;'>Deactive</a>";
                                 }
                                 ?>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary "
                                        style="border: none;width: 96px;height: 38px;">Edit
                                </button>
                            </td>
                            
                            <td>
                            <form action="process/admindashboard/clubdelete.php" method="post">
                                                <input type="hidden" name="user_id"
                                                       value="<?php echo $users->user_id; ?>">
                                <button type="submit" class="btn btn-danger "
                                        style="border: none;width: 96px;height: 38px;">Delete
                                </button>
                    </form>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    ?>

                    </tbody>
                </table>

            </section>

        </div>
    </div>
    <div id="menu-content-3"  class="main-content hide" >
        <h1 class="text-center fw-bold">New Club Requests</h1>
        <div class="table mx-auto" >
            <section class="table_body">
        <table>
                    <thead>
                    <tr>
                        <th>Club Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $newClubNo=1;
                    foreach ($user3 as $users) {
 
                        
                    ?>
                    <tr>
                        <td><?php echo $users->name; ?></td>
                        <td><?php echo $users->user_name; ?> </td>
                        <td><?php echo $users->contact_no; ?> </td>
                        <td><?php echo $users->register_date; ?></td>
                        <td>
                        <button type="button" id="viewButton" class="btn btn-primary   btnedit" data-bs-toggle="modal"
                                 data-bs-target="#viewModal-<?=$newClubNo ?>">View Pdf</button>
                                <div class="modal fade" id="viewModal-<?=$newClubNo ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:var(--darker-primary); color:white">
                                            <h5 class="modal-title">PDF Viewer</h5>

                                        </div>
                                        <div class="modal-body" style="font-size: 20px">
                                            <iframe style="height:400px; width:450px;marging:10px;padding-left:15px" src="assets/uploads/<?php echo $users->approval_documents;?>" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer" style="background-color:var(--darker-primary)">

                                            <button type="button" class="btn btn-secondary" id="no"
                                                    data-bs-dismiss="modal">Cancel
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>


                        <td>
                         <button type="button" id="acceptButton" class="btn btn-success   btnedit" data-bs-toggle="modal"
                                 data-bs-target="#confirmModal-<?=$newClubNo ?>">Accept</button>

                            <!-- Bootstrap Modal -->
                            <div class="modal fade" id="confirmModal-<?=$newClubNo ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:var(--darker-primary); color:white">
                                            <h5 class="modal-title">Confirmation</h5>

                                        </div>
                                        <div class="modal-body" style="font-size: 20px">
                                            Are you sure you want to accept?
                                        </div>
                                        <div class="modal-footer" style="background-color:var(--darker-primary)">
                                            <form action="process/admindashboard/updateStatus.php" method="post">
                                                <input type="hidden" name="user_id"
                                                       value="<?php echo $users->user_id; ?>">
                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" id="no"
                                                    data-bs-dismiss="modal">No
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger  btnedit" data-bs-toggle="modal"
                                 data-bs-target="#declineModal-<?=$newClubNo ?>">Decline</button>

                            <!-- Bootstrap Modal for Decline -->
                            <div class="modal fade" id="declineModal-<?=$newClubNo ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered"
                                 role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:var(--darker-primary); color:white">
                                            <h5 class="modal-title">Confirmation</h5>

                                        </div>
                                        <div class="modal-body" style="font-size: 20px">
                                            Are you sure you want to decline?
                                        </div>
                                        <div class="modal-footer" style="background-color:var(--darker-primary)">
                                            <form action="process/admindashboard/declineRequest.php" method="post">
                                                <input type="hidden" name="user_id"
                                                       value="<?php echo $users->user_id; ?>">
                                                <button type="submit" class="btn btn-danger">Yes</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" id="decline"
                                                    data-bs-dismiss="modal">No
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <?php
                        $newClubNo++;
                        }
                        ?>

                    </tbody>

                </table>
            </section>
        </div>
    </div>

    <div id="menu-content-5" class="main-content hide">
        <h1>Content 5</h1>
    </div>

</div>
<!--=== pre loader ===-->
<?php include_once "content/preloader.php" ?>
<!--=== Preloader Script file ===-->
<?php include_once "content/commonJS.php" ?>
 <!--=========== Selected Menu change when loading ============-->
 <script>
        document.getElementById("menu-<?php echo $selected_menuNo ?>").classList.add("activate");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.remove("hide");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.add("show");
    </script>

<!-- ==== Boostrap Script ==== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>


<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->


<!-- ========= Ionicons Scripts ===== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- ====== Script files ===== -->
<script src="assets/js/projectdashboard.js"></script>
<script src="assets/js/admindashboardsearch.js"></script>
<script src="assets/js/adminscript.js"></script>



</body>

</html>