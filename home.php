<?php require_once('db-connect.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/scss/style.scss">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/calender.css">
    <link rel="stylesheet" href="./assets/css/carousel.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- ===== Boostrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
</head>

<body>
<!-- ======= Navigation Bar =======    -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top position-relative">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-primary" href="home.php">UWU<span class="text-dark">Event</span><span
                    class="text-warning">z</span></a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> -->
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
        <div class="" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li> -->
            </ul>
            <form class="d-flex">
                <button class="btn btn-outline-secondary d-flex align-items-center" type="submit"><Span
                            class="d-none d-lg-inline pe-2">SignUp</Span>
                    <ion-icon style="font-size: 1.0rem;;"
                    " name=" person-add-outline"></ion-icon>
                </button>
                <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span
                            class="d-none d-lg-inline-block pe-2">LogIn</Span>
                    <ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- ======= Main Content ====== -->
<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Event Calender
                    </div>
                    <div class="card-body">
                        <div class="container-fluid" id="page-container">
                            <div class="row">
                                <div class="col-md-9">
                                    <div id="calendar"></div>
                                </div>
                                <div class="col-md-3">
                                    <div><h2 class="p-3" style="color: #0b5ed7">Eventz 2023</h2></div><br><br><br><br>
                                    <div><img src="assets/images/homepage/calender.gif" </div>
                                </div>
                            </div>
                        </div>
                        <!-- Event Details Modal -->
                        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-0">
                                    <div class="modal-header rounded-0">
                                        <h5 class="modal-title">Schedule Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body rounded-0">
                                        <div class="container-fluid">
                                            <dl>
                                                <dt class="text-muted">Title</dt>
                                                <dd id="title" class="fw-bold fs-4"></dd>
                                                <dt class="text-muted">Description</dt>
                                                <dd id="description" class=""></dd>
                                                <dt class="text-muted">Start</dt>
                                                <dd id="start" class=""></dd>
                                                <dt class="text-muted">End</dt>
                                                <dd id="end" class=""></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="modal-footer rounded-0">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Event Details Modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container3-fluid py-6 mb-6"> -->
    <div class="container p-5">
        <h2 class="title">
            <span class="title-word title-word-1">Upcomming</span>
            <span class="title-word title-word-2">News</span>
        </h2>
        <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleSlidesOnly">
            <div class="carousel-inner justify-content-center">
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front  w-100">
                                    <img alt="" src="assets/images/homepage/f1.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        IEEE is a leader in engineering and technology education, providing resources
                                        for pre-university,
                                        university, and continuing professional education.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front ">
                                    <img alt="" src="assets/images/homepage/f2.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        Students of Faculty of Management annually organize “ENM Trophy Cricket
                                        Encounter” inviting the
                                        students of fellow degree programs of the University.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f3.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        Students of Animal Science degree program annually organize “ANS Trophy Football
                                        Tournament”
                                        inviting the students of fellow degree programs of the University.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f4.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        Empowering of Youth as Agri-Entrepreneurs Faculty of Animal Science and Export
                                        Agriculture, Uva
                                        Wellassa University.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f5.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        The Faculty of Applied Sciences of Uva Wellassa University of Sri Lanka (UWU) is
                                        organizing UWU EXPO.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f6.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        UBL Cell is organizing a Business Plan Competition to identify potential
                                        undergraduate entrepreneurs
                                        who have realistic business ideas and to assist them to grow up as sustainable
                                        entrepreneurs
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f7.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        A workshop on “How to start your own business?” was conducted at the university
                                        on 20th Wednesday
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/f8.jpg">
                                </div>
                                <div class="box back">
                                    <p>
                                        The LAN Challenge is an annual gaming extravagance commemorating its fifth
                                        chapter in 2023. Since
                                        the challenge has brought together epic gamers in the Uva Wellassa
                                        student community.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="height: 500px; width: 400px">
                            <div class="card h-100">
                                <div class="box front">
                                    <img alt="" src="assets/images/homepage/aurora.png">
                                </div>
                                <div class="box back">
                                    <p>
                                        The Aurora is always a highly anticipated event on UWU’s annual event calendar
                                        hosted by students of
                                        Department of Animal Science under the guidance of Academic staff, Department of
                                        Animal Science.
                                    </p>
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="title">
        <h1>Our Services</h1>
    </div>
    <div class="d-flex col-md-12  p-5 justify-content-start">
        <div class=" mb-3 " style="max-width: 80%;">
            <div class="row ">
                <div class="col-md-4">
                    <img src="assets/images/homepage/calender.jpg" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <h5 class="title-service">UWU Event Calender</h5>
                    <p class="text">
                        Many events or projects happen every week in our university. In such a situation, the
                        days will last
                        Events are held by different degrees or different clubs, and when you book the hall for
                        those events, there
                        Many problems such as events that collide with each other on the same day.
                        Those events happen on the same day at the same time. And here some students may be in
                        several events
                        Several clubs. Then it becomes easier for him to plan his work and manage his time.
                        A calendar of events and projects organized by the university's students will help in
                        the assignment
                        Dates for an event.
                    </p>
                    <div class="content-btn">
                        <a href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex col-md-12  p-5 justify-content-end">
        <div class=" mb-3" style="max-width: 80%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="assets/images/homepage/prPlan.jpg" class="img-fluid rounded-start">
                </div>
                <div class=" col-md-8">
                    <h5 class="title-service">PR Plan Tool</h5>
                    <p class="text">
                        The tool should allow the project manager to define PR activities, such as press releases, media
                        interviews, or social media campaigns. Further,
                        The system can provide a platform for managing PR tasks, assigning responsibilities, and setting
                        deadlines.
                    </p>
                    <div class="content-btn">
                        <a href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex col-md-12 p-5 justify-content-start">
        <div class=" mb-3 " style="max-width: 80%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="assets/images/homepage/ganttChart.jpg" class="img-fluid rounded-start">
                </div>
                <div class=" col-md-8">
                    <h5 class="title-service">Gantt Chart</h5>
                    <p class="text">
                        The system generates a visual representation of the project timeline, highlighting task start
                        and finish dates. as well as
                        Project members are able to update the timeline as the project progresses, making adjustments to
                        task timelines or dependencies as needed.
                    </p>
                    <div class="content-btn">
                        <a href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex col-md-12 p-5 justify-content-end">
        <div class="mb-3" style="max-width: 80%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="assets/images/homepage/activity.jpg" class="img-fluid rounded-start">
                </div>
                <div class="content col-md-8">
                    <h5 class="title-service">Activity Plan Tool</h5>
                    <p class="text">
                        Here users can add sub-tasks under the main task.
                        This tool allows project managers to define project activities. And also
                        Project users are able to update the activity plan, mark activities as completed and track the
                        overall progress of the project.

                    </p>
                    <div class="content-btn">
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h1 class="heading">Our Team</h1>
<div class="row row-cols-1 row-cols-md-5 g-4 p-5">
    <div class="col d-flex justify-content-center">
        <div class="card-profile d-flex flex-column justify-content-center">
                <img src="assets/images/homepage/kavindra.jpg" class="card-img-top position-sticky " style="width: 290px;height: 330px" alt="...">
            <div class="card-profile-body">
                <h5 class="card-title">Kavindra Weerasingha</h5>
                <p class="card-text">UWU/CST/20/068</p>
            </div>
            <div class="d-flex justify-content-evenly p-4">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-linkedin"></i>
                <i class="bi bi-envelope-fill"></i>
                <i class="bi bi-whatsapp"></i>
            </div>
        </div>
    </div>
    <div class="col d-flex justify-content-center">
        <div class="card-profile d-flex flex-column justify-content-center">
            <img src="assets/images/homepage/heli.jpg" class="card-img-top position-sticky" style="width: 290px;height: 330px" alt="...">
            <div class="card-profile-body">
                <h5 class="card-title">Kavinda Helitha</h5>
                <p class="card-text">UWU/CST/20/070</p>
            </div>
            <div class="d-flex justify-content-evenly p-4">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-linkedin"></i>
                <i class="bi bi-envelope-fill"></i>
                <i class="bi bi-whatsapp"></i>
            </div>
        </div>
    </div>
    <div class="col d-flex justify-content-center">
        <div class="card-profile d-flex flex-column justify-content-center">
            <img src="assets/images/homepage/anuranga.jpg" class="card-img-top position-sticky" style="width: 290px;height: 330px" alt="...">
            <div class="card-profile-body">
                <h5 class="card-title">Anuranga</h5>
                <p class="card-text">UWU/CST/20/085</p>
            </div>
            <div class="d-flex justify-content-evenly p-4">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-linkedin"></i>
                <i class="bi bi-envelope-fill"></i>
                <i class="bi bi-whatsapp"></i>
            </div>
        </div>
    </div>
    <div class="col d-flex justify-content-center">
        <div class="card-profile d-flex flex-column justify-content-center">
            <img src="assets/images/homepage/ishara.jpg" class="card-img-top position-sticky" style="width: 290px;height: 330px" alt="...">
            <div class="card-profile-body">
                <h5 class="card-title">Ishara Suvini</h5>
                <p class="card-text">UWU/CST/20/087</p>
            </div>
            <div class="d-flex justify-content-evenly p-4">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-linkedin"></i>
                <i class="bi bi-envelope-fill"></i>
                <i class="bi bi-whatsapp"></i>
            </div>
        </div>
    </div>
    <div class="col d-flex justify-content-center">
        <div class="card-profile d-flex flex-column justify-content-center">
            <img src="assets/images/homepage/thilini.jpg" class="card-img-top position-sticky" style="width: 290px;height: 330px" alt="...">
            <div class="card-profile-body">
                <h5 class="card-title">Thilini Priyangika</h5>
                <p class="card-text">UWU/CST/20/089</p>
            </div>
            <div class="d-flex justify-content-evenly p-4">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-linkedin"></i>
                <i class="bi bi-envelope-fill"></i>
                <i class="bi bi-whatsapp"></i>
            </div>
        </div>
    </div>

</div>


<!-- ======== Footer ======== -->
<?php include('content/footer.php') ?>

<?php
$schedules = $conn->query("SELECT * FROM `schedule_list`");
$sched_res = [];
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
?>
<?php
if (isset($conn)) $conn->close();
?>

<!-- ==== Boostrap Script ==== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<!-- ========= Ionicons Scripts ===== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- ====== Script files ===== -->
<script src="assets/js/home.js"></script>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>

