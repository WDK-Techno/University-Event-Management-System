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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <!-- ===== Boostrap CSS ==== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <script src="./assets/js/jquery-3.6.0.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <script src="./fullcalendar/lib/main.min.js"></script>
</head>

<body>
  <!-- ======= Navigation Bar =======    -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top position-relative">
    <div class="container-fluid px-4">
      <a class="navbar-brand text-primary" href="index.html">UWU<span class="text-dark">Event</span><span class="text-warning">z</span></a>
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
          <button class="btn btn-outline-secondary d-flex align-items-center" type="submit"><Span class="d-none d-lg-inline pe-2">SignUp</Span>
            <ion-icon style="font-size: 1.0rem;;"" name=" person-add-outline"></ion-icon>
          </button>
          <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span class="d-none d-lg-inline-block pe-2">LogIn</Span>
            <ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon>
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- ======= Main Content ====== -->
<div>
  <div class="container py-4">
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
                  <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-warning text-dark">
                      <h5 class="card-title">Schedule Form</h5>
                    </div>
                    <div class="card-body">
                      <div class="container-fluid">
                        <form action="process/home/save_schedule.php" method="post" id="schedule-form">
                          <input type="hidden" name="id" value="">
                          <div class="form-group mb-2">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                          </div>
                          <div class="form-group mb-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                          </div>
                          <div class="form-group mb-2">
                            <label for="start_datetime" class="control-label">Start</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                          </div>
                          <div class="form-group mb-2">
                            <label for="end_datetime" class="control-label">End</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-center">
                        <button class="btn btn-success btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Event Details Modal -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                  <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <div class="text-end">
                      <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                      <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                      <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
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
  <div class="container">
    <h2 class="title">
      <span class="title-word title-word-1">Upcomming</span>
      <span class="title-word title-word-2">Events</span>
    </h2>
  </div>
  <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleSlidesOnly">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="row">
          <div class="col-lg-4" style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/ieee.png">
                <h2>IEEE Open Day</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  IEEE is a leader in engineering and technology education, providing resources for pre-university,
                  university, and continuing professional education.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4" style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/enmthrophy.jpg">
                <h2>ENM Trophy</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  Students of Faculty of Management annually organize “ENM Trophy Cricket Encounter” inviting the
                  students of fellow degree programs of the University.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4" style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/ansTropy.png">
                <h2>ANS Trophy</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  Students of Animal Science degree program annually organize “ANS Trophy Football Tournament”
                  inviting the students of fellow degree programs of the University.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="row">
          <div class="col-lg-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/community.jpg">

                <h2> Community Development Project</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  Empowering of Youth as Agri-Entrepreneurs Faculty of Animal Science and Export Agriculture, Uva
                  Wellassa University.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/expo.jpg">
                <h2>UWU Expo</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  The Faculty of Applied Sciences of Uva Wellassa University of Sri Lanka (UWU) is organizing UWU EXPO.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-md-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/bussiness.jpg">
                <h2>Bussiness plan Competition</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  UBL Cell is organizing a Business Plan Competition to identify potential undergraduate entrepreneurs
                  who have realistic business ideas and to assist them to grow up as sustainable entrepreneurs
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="row">
          <div class="col-lg-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/CapWorkshop.jpg">
                <h2>Workshop</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  A workshop on “How to start your own business?” was conducted at the university on 20th Wednesday
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/lanChallenge.png">
                <h2>CST Lan Challenge</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  The LAN Challenge is an annual gaming extravagance commemorating its fifth chapter in 2023. Since
                  the challenge has brought together epic gamers in the Uva Wellassa
                  student community.
                </p>
                <button class="btn btn-success">Register</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4"  style="height: 300px;">
            <div class="card h-100">
              <div class="box front p-4">
                <img alt="" src="assets/images/aurora.png">
                <h2>Aurora Food Festival</h2>
                <h4></h4>
              </div>
              <div class="box back">
                <p>
                  The Aurora is always a highly anticipated event on UWU’s annual event calendar hosted by students of
                  Department of Animal Science under the guidance of Academic staff, Department of Animal Science.
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

  <header class="pt-lg-4 py-2 px-2">
    <div class="overlay">
      <h1>About UWU Event Calender</h1>
      <p>Many events or projects happen every week in our university. In such a situation, the days will last
        Events are held by different degrees or different clubs, and when you book the hall for those events, there
        Many problems such as events that collide with each other on the same day.
        Those events happen on the same day at the same time. And here some students may be in several events
        Several clubs. Then it becomes easier for him to plan his work and manage his time.
        A calendar of events and projects organized by the university's students will help in the assignment
        Dates for an event.</p>
      <br>
      <button>READ MORE</button>
    </div>
  </header>


  <!-- ======== Footer ======== -->
  
  <footer class="py-0 px-0 text-dark bottom-0 position-relative w-100">
    <div class="d-flex flex-column align-items-center flex-lg-row justify-content-lg-between py-1 my-1 border-top">
      <p class="text-center">© 2023 UWUEventz, Inc. <span class="d-block d-md-inline">All rights reserved.</span>
      </p>
      <ul class="list-unstyled d-flex">
        <li class="m-1"><a class="link-dark" href="#">
            <ion-icon name="logo-tumblr"></ion-icon>
          </a></li>
        <li class="m-1"><a class="link-dark" href="#">
            <ion-icon name="logo-instagram"></ion-icon>
          </a></li>
        <li class="m-1"><a class="link-dark" href="#">
            <ion-icon name="logo-facebook"></ion-icon>
          </a></li>
      </ul>
    </div>
  </footer>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
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
</body>

</html>

