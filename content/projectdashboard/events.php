<?php
require_once "classes/Event.php";

use classes\Event;

?>
<div class="col-12 p-5 d-flex justify-content-center ">
    <div class="col-md-12 mx-auto">
        <div class=" d-flex w-100">

            <div class="btn btn-success fw-bold my-auto ms-auto me-2 d-flex"
                 type="button" data-bs-toggle="modal"
                 data-bs-target="#add-new-event">
                <ion-icon class="my-auto" name="add-outline"></ion-icon>
                <div class="my-auto d-flex">New</div>
            </div>
            <!-- =========== add new event button model =========== -->
            <div class="modal fade"
                 id="add-new-event"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"
                     role="document">
                    <div class="modal-content">
                        <!--=== form =====-->
                        <form action="process/projectdashboard/addNewEvent.php" method="post">
                            <div class="modal-header py-2 px-2"
                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                <div class="d-flex flex-row w-100 justify-content-between">

                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                        Event
                                    </div>

                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                        New
                                    </div>
                                </div>

                                <!--======= hidden ==========-->
                                <input type="hidden" name="menuNo" value="6">
                                <input type="hidden" name="project_id"
                                       value="<?= $project->getProjectID() ?>">
                            </div>

                            <div class="modal-body"
                                 style="background-color: var(--lighter-secondary);">
                                <div class="d-flex flex-column p-2">
                                    <input class="form-control text-center" type="text" required
                                           name="name" placeholder="Event Name"/><br>
                                    <input class="form-control text-center" type="text" required
                                           name="description" placeholder="Description"/><br>
                                    <input class="form-control text-center" type="date" required
                                           name="event_date" placeholder="Event Date"/><br>
                                    <div class="d-flex mx-auto">
                                            <span class="d-flex me-5">
                                                <div class="my-auto me-3">Start<br>Time</div>
                                            <input class="form-control text-center" style="width: fit-content"
                                                   type="time" required
                                                   name="event_start_time"/>
                                            </span>

                                        <span class="d-flex">
                                               <div class="my-auto me-3">End<br>Time</div>
                                            <input class="form-control text-center" style="width: fit-content"
                                                   type="time" required
                                                   name="event_end_time"/>
                                            </span>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color: var(--primary);">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit"
                                        name="submit"
                                        class="btn fw-bold"
                                        style="background-color: var(--secondary); color: var(--primary);">
                                    ADD
                                </button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- ========== Event list body =========== -->
        <div class="">
            <div class="d-flex col-md-12 m-1">
                <?php
                $eventNo = 1;
                foreach ($events as $event) {
                    $event = new Event($event->getEventId(), null, null, null,
                        null, null, null);
                    $event->loadDataFromeventId($con);
                    ?>
                    <div class="card p-0 shadow-sm mb-3 mx-3" style="width: 200px; max-height: 330px">

                        <div class="card-header d-flex" style="background-color: var(--primary);">
                                <span class="fw-bold fs-3 mx-auto"
                                      style="color: var(--lighter-secondary);"><?= $event->getEventName() ?></span>
                        </div>

                        <div class="card-body container" style="background-color: var(--lighter-secondary);">
                            <div class="row mt-0">
                                <div class="col-6 d-flex text-center">
                                                <span class="fs-1 m-auto py-2 px-3 fw-bold rounded-circle text-danger-emphasis bg-warning">
                                                    <?= date('d', strtotime($event->getEventStartDate())); ?>
                                                </span>
                                </div>
                                <div class="col-6 d-flex flex-column">
                                               <span class="fs-2 fw-bold mb-0 p-0 text-danger">
                                                   <?= strtoupper(date('M', strtotime($event->getEventStartDate()))); ?>
                                               </span>
                                    <span class="fs-5 ps-1 fw-bold mt-0 p-0 text-secondary"><?= strtoupper(date('Y', strtotime($event->getEventStartDate()))); ?></span>
                                </div>
                            </div>

                            <!--                                        <div class="row mt-2">-->
                            <!--                                            <p class="my-auto text-center">-->
                            <?php //=$event->getEventDescription()?><!--</p>-->
                            <!---->
                            <!--                                        </div>-->
                            <div class="row mt-2">
                                <div class="d-flex justify-content-center mx-auto">
                                    <ion-icon class="mx-1 my-auto"
                                              style="font-size: 1.7rem; color: var(--darker-primary);"
                                              name="alarm-outline"></ion-icon>
                                    <div class="fw-bold my-auto"
                                         style="font-size: 1.4rem; color: var(--darker-primary);"><?= date('g:i A', strtotime($event->getEventStartDate())) ?></div>
                                </div>
                                <div class="d-flex mt-1 justify-content-center mx-auto">
                                    <div class="d-flex fw-bold shadow-sm" style="font-size: 1.0rem;">
                                        <?php
                                        $startDate = new DateTime(strval($event->getEventStartDate()));
                                        $endDate = new DateTime(strval($event->getEventEndDate()));

                                        $diff = date_diff($endDate, $startDate);
                                        $hours = $diff->format("%H");
                                        $minutes = $diff->format("%i");
                                        if ($minutes < 10) {
                                            $minutes = "0" . $minutes;
                                        }
                                        ?>
                                        <div class="d-flex px-1 py-0"
                                             style="background-color: var(--darker-primary)">
                                            <span class="text-light"><?= $hours ?></span>
                                            <span class="" style="color: var(--secondary)">H</span>
                                        </div>
                                        <div class="d-flex px-1 py-0"
                                             style="background-color: var(--accent-color)">
                                            <span class="text-light"><?= $minutes ?></span>
                                            <span class="" style="color: var(--accent-color2)">Min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end bg-warning-subtle card-list-option-buttons"
                             style="font-size: 1.7rem;">
                            <!--========== edit event button =========-->
                            <ion-icon class="my-1" type="button"
                                      data-bs-toggle="modal"
                                      data-bs-target="#edit-event<?= $eventNo ?>"
                                      name="create-outline"></ion-icon>

                            <!-- =========== edit event button model =========== -->
                            <div class="modal fade"
                                 id="edit-event<?= $eventNo ?>"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                     role="document">
                                    <div class="modal-content">
                                        <!--=== form =====-->
                                        <form action="process/projectdashboard/editEvent.php"
                                              method="post">
                                            <div class="modal-header py-2 px-2"
                                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                        Event
                                                    </div>

                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                                        Edit
                                                    </div>
                                                </div>

                                                <!--======= hidden ==========-->
                                                <input type="hidden" name="menuNo"
                                                       value="6">
                                                <input type="hidden" name="event_id"
                                                       value="<?= $event->getEventId() ?>">
                                            </div>

                                            <div class="modal-body"
                                                 style="background-color: var(--lighter-secondary);">
                                                <div class="d-flex flex-column p-2">
                                                    <input class="form-control text-center" type="text" required
                                                           name="name" placeholder="Event Name"
                                                           value="<?= $event->getEventName() ?>"/><br>
                                                    <input class="form-control text-center" type="text"
                                                           value="<?= $event->getEventDescription() ?>" required
                                                           name="description" placeholder="Description"/><br>
                                                    <input class="form-control text-center" type="date"
                                                           value="<?= date('Y-m-d', strtotime($event->getEventStartDate())); ?>"
                                                           required
                                                           name="event_date" placeholder="Event Date"/><br>

                                                    <div class="d-flex mx-auto" style="font-size: 1.0rem">
                                                        <!--start time-->
                                                        <span class="d-flex me-5">
                                                                <div class="my-auto me-3">Start<br>Time</div>
                                                            <input class="form-control text-center"
                                                                   style="width: fit-content"
                                                                   type="time"
                                                                   value="<?= date('H:i', strtotime($event->getEventStartDate())); ?>"
                                                                   required
                                                                   name="event_start_time"/>
                                                            </span>
                                                        <!--end time-->
                                                        <span class="d-flex">
                                                               <div class="my-auto me-3">End<br>Time</div>
                                                            <input class="form-control text-center"
                                                                   style="width: fit-content"
                                                                   type="time"
                                                                   value="<?= date('H:i', strtotime($event->getEventEndDate())); ?>"
                                                                   required
                                                                   name="event_end_time"/>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer"
                                                 style="background-color: var(--primary);">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit"
                                                        name="submit"
                                                        class="btn fw-bold"
                                                        style="background-color: var(--secondary); color: var(--primary);">
                                                    Update
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <!--========== Delete event button =========-->
                            <ion-icon class="my-1 ms-2 me-0" type="button"
                                      data-bs-toggle="modal"
                                      data-bs-target="#delete-event<?= $eventNo ?>"
                                      name="trash-outline"></ion-icon>
                            <!-- =========== Delete event button model =========== -->
                            <div class="modal fade"
                                 id="delete-event<?= $eventNo ?>"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                     role="document">
                                    <div class="modal-content">
                                        <!--=== form =====-->
                                        <form action="process/projectdashboard/deleteevent.php"
                                              method="post">
                                            <div class="modal-header py-2 px-2"
                                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                        <?= $event->getEventName() ?>
                                                    </div>

                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                         style="font-size: 1.3rem; color: var(--accent-color3);">
                                                        Delete
                                                    </div>
                                                </div>

                                                <!--======= hidden ==========-->
                                                <input type="hidden" name="menuNo"
                                                       value="6">
                                                <input type="hidden" name="event_id"
                                                       value="<?= $event->getEventId() ?>">
                                            </div>

                                            <div class="modal-body"
                                                 style="background-color: var(--lighter-secondary);">
                                                <div class="d-flex fw-normal fs-5">
                                                    Do you want to Delete this Event ?
                                                </div>
                                            </div>
                                            <div class="modal-footer"
                                                 style="background-color: var(--primary);">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit"
                                                        name="submit"
                                                        class="btn fw-bold"
                                                        style="background-color: var(--accent-color3); color: var(--primary);">
                                                    Delete
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php

                    $eventNo++;
                }

                ?>


            </div>
        </div>
    </div>
</div>

