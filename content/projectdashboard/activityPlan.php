<?php

require_once "classes/User.php";
require_once "classes/TeamCategory.php";
require_once "classes/MainTask.php";
require_once "classes/SubTask.php";

use classes\Undergraduate;
use classes\TeamCategory;
use classes\MainTask;
use classes\SubTask;

$teamCategories = TeamCategory::getTeamCategoeryListFromProjectID($con, $project->getProjectID());
$mainTasks = MainTask::getMainTaskListFromProjectID($con, $project->getProjectID());
$subTasks = SubTask::getSubTasksListFromProjectID($con, $project->getProjectID());
?>

<div class="container-fluid">
    <div class="row d-flex">
        <div class="col-11 mx-auto">

            <!-- ======= add Task button ======== -->
            <div class="d-flex mt-3 mb-2">
                <div class="btn fw-bold my-auto me-0 ms-auto d-flex"
                     style="color: var(--lighter-secondary) !important; background-color: var(--primary);"
                     type="button" data-bs-toggle="modal"
                     data-bs-target="#add-new-sub-task">
                    <ion-icon class="my-auto" name="add-outline"></ion-icon>
                    <div class="my-auto">Task</div>
                </div>
            </div>

            <!-- ========= add task button model ========== -->
            <div class="modal fade"
                 id="add-new-sub-task"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"
                     role="document">
                    <div class="modal-content">
                        <!--=== form =====-->
                        <form action="process/projectdashboard/addNewSubTask.php" method="POST">
                            <div class="modal-header py-2 px-2"
                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                <div class="d-flex flex-row w-100 justify-content-between">

                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                        Sub Task
                                    </div>

                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                        New
                                    </div>
                                </div>

                                <!--======= hidden ==========-->
                                <input type="hidden" name="menuNo" value="4">
                            </div>

                            <div class="modal-body"
                                 style="background-color: var(--lighter-secondary);">

                                <!-- ===== select Main Task ======= -->
                                <div class="d-flex mt-2 px-5">
                                    <div class="d-flex w-100 rounded p-2" style="background-color: var(--secondary)">
                                        <div class="ms-1 me-auto my-auto fw-bold" style="font-size: 0.8rem;">Select <br>
                                            Main Task
                                        </div>
                                        <select class="form-select ms-auto me-0"
                                                style="width: 50%;"
                                                name="main_task" id="" required>
                                            <option class="text-center" value="" selected>-- Main Task --
                                            </option>
                                            <?php
                                            foreach ($mainTasks as $mainTask) {
                                                $mainT = new MainTask($mainTask->getMainTaskID());
                                                $mainT->loadMainTaskFromTaskID($con);
                                                ?>
                                                <option value="<?= $mainT->getMainTaskID() ?>"><?= $mainT->getMainTaskName() ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- ====== input Sub Task & Description ====== -->
                                <div class="d-flex mt-2 px-5">
                                    <input class="form-control text-center"
                                           name="sub_task"
                                           placeholder="Sub Task" required/>
                                </div>
                                <div class="d-flex mt-2 px-5">
                                    <input class="form-control text-center"
                                           name="description"
                                           placeholder="Description"/>
                                </div>

                                <!-- ===== select Team Category ======= -->
                                <div class="d-flex mt-2 px-5">
                                    <div class="d-flex w-100 rounded p-2" style="background-color: var(--secondary)">
                                        <div class="ms-1 me-auto my-auto fw-bold" style="font-size: 0.8rem;">Select <br>
                                            Team Category

                                        </div>
                                        <select class="form-select ms-auto me-0"
                                                style="width: 50%;"
                                                name="team_category"
                                                onchange="displaySelectedTeamMembers()"
                                                id="selected-team-cat-in-add-subtask" required>
                                            <option class="text-center" value="" selected>-- Team Category --
                                            </option>
                                            <?php

                                            foreach ($teamCategories as $teamCategory) {
                                                ?>
                                                <option value="<?= $teamCategory->getCategoryID() ?>"><?= $teamCategory->getCategoryName() ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- ===== select Team Member ======= -->
                                <div class="d-flex mt-2 px-5">
                                    <div class="d-flex w-100 rounded p-2" style="background-color: var(--secondary)">
                                        <div class="ms-1 me-auto my-auto fw-bold" style="font-size: 0.8rem;">Select <br>
                                            Team Member

                                        </div>
                                        <select class="form-select ms-auto me-0"
                                                style="width: 50%;"
                                                name="selected-team-cat-members" id="selected-team-cat-members"
                                                required>
                                            <option class="text-center" value="" selected>-- Team Member --
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex mt-2 px-5 w-100">
                                    <div class="d-flex w-100 rounded p-2" style="background-color: var(--secondary)">
                                        <div class="ms-1 me-auto my-auto fw-bold" style="font-size: 0.8rem;">completion
                                            <br>
                                            Date & Time
                                        </div>
                                        <div class="d-flex ms-auto me-0">
                                            <input class="form-control text-center me-2" type="date" required
                                                   style="width: fit-content"
                                                   name="completion_date"/>
                                            <input class="form-control text-center" style="width: fit-content"
                                                   type="time" required
                                                   name="completion_time"/>
                                        </div>

                                    </div>
                                </div>
                                <!--====== display error ========-->
                                <div class="mt-2 text-center" id="add-member-team-error"
                                     style="color: var(--accent-color3)"></div>

                            </div>
                            <div class="modal-footer" style="background-color: var(--primary);">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit"
                                        name="add_new_sub_task"
                                        class="btn fw-bold"
                                        style="background-color: var(--secondary); color: var(--primary);">
                                    ADD
                                </button>

                            </div>
                        </form>
                    </div>


                </div>
            </div>


            <!-- ========== Sub task table ============ -->
            <div class="card" style="">
                <div class="card-header team-member-table pb-0"
                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                    <div class="row p-0 fw-bold">
                        <div class="col-1 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">
                            Complete
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Main Task
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">
                            Sub Task
                        </div>
                        <div class="col-3 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Description
                        </div>
                        <div class="col-1 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">
                            Member
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Deadline
                        </div>
                        <div class="col-1">

                        </div>
                    </div>

                </div>

                <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                     style="background-color: var(--secondary);">
                    <div class="container p-0 scrollable-div-inside">

                        <?php
                        $subTaskNo = 1;

                        foreach ($subTasks

                                 as $subTask) {
                            $task = new SubTask($subTask->getSubTaskID(), null, null, null, null, null, null, null);
                            $task->loadSubTaskFromSubTaskID($con);
                            ?>

                            <div class="row mb-2 shadow-sm set-border" style="height: 50px;">
                                <div class="col-1 d-flex tabel-column-type-1 justify-content-center"
                                     style="font-size: 1.8rem;">
                                    <form action="process/projectdashboard/editSubTask.php" class="d-flex" method="POST">
                                        <input type="checkbox"
                                               class="my-auto ms-0 me-auto form-check-input"
                                               style="background-color: var(--primary);border-color: var(--accent-color3);border-width:2.5px;"
                                               name="is_completed"
                                               value="completed"
                                            <?php if ($task->getIsTaskCompleted() == 1) echo "checked" ?>
                                               onchange="updateSubTaskComplete(<?= $subTaskNo ?>)">
                                        <!--======= hidden ==========-->
                                        <input type="hidden" name="menuNo" value="4">
                                        <input type="hidden" name="sub_task_id"
                                               value="<?= $task->getSubTaskID() ?>">
                                        <input class="d-none" type="submit" name="sub_task_update_submit"
                                               id="sub_task_update_submit_<?= $subTaskNo ?>"/>
                                    </form>
                                </div>
                                <div class="col-2 tabel-column-type-2 d-flex justify-content-center">
                                    <div class="my-auto fw-bold text-center"><?= $task->getMainTaskName() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-1 justify-content-center">
                                    <div class="my-auto fw-bold text-center"><?= $task->getSubTaskName() ?></div>
                                </div>
                                <div class="col-3 d-flex tabel-column-type-2 justify-content-center">
                                    <div class="my-auto text-center"><?= $task->getDescription() ?></div>
                                </div>
                                <div class="col-1 d-flex tabel-column-type-1 justify-content-center"
                                     style="font-size: 0.8rem; text-align: center">
                                    <?php
                                    $asignedMember = new Undergraduate(null, null, null, null, null, null);
                                    $asignedMember->setUserId($task->getAssignedMemberID());
                                    $asignedMember->loadDataFromUserID($con);
                                    ?>
                                    <div class="my-auto"><?= $asignedMember->getFirstName() ?>
                                        <br><?= $asignedMember->getLastName() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-2 justify-content-center">
                                    <div class="my-auto me-4 d-flex flex-column">
                                        <div class="d-flex mx-auto fw-lighter"
                                             style="font-size: 0.8rem;"><?= date("Y", strtotime($task->getDeadline())) ?></div>
                                        <div class="d-flex mx-auto">
                                            <div class="me-1"><?= date("M", strtotime($task->getDeadline())) ?></div>
                                            <div><?= date("d", strtotime($task->getDeadline())) ?></div>
                                        </div>
                                    </div>
                                    <div class="my-auto d-flex">
                                        <div class="my-auto"><?= date("g:i A", strtotime($task->getDeadline())) ?></div>
                                    </div>
                                </div>
                                <div class="col-1 tabel-column-type-1 d-flex justify-content-center">
                                    <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">
                                        <!--========== Edit Sub task button =========-->
                                        <ion-icon class="my-auto me-2" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#edit-sub-task-<?= $subTaskNo ?>"
                                                  name="create-outline"></ion-icon>
                                        <!--========== Delete Sub task button =========-->
                                        <ion-icon class="my-auto" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#delete-sub-task-<?= $subTaskNo ?>"
                                                  name="trash-outline"></ion-icon>
                                    </div>
                                    <!-- =========== Edit Subtask button model =========== -->
                                    <div class="modal fade"
                                         id="edit-sub-task-<?= $subTaskNo ?>"
                                         tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="exampleModalCenterTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <!--=== form =====-->
                                                <form action="process/projectdashboard/editSubTask.php"
                                                      method="POST">
                                                    <div class="modal-header py-2 px-2"
                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-row w-100 justifys-content-between">

                                                            <div class="ms-2 my-auto fs-4 fw-bold">
                                                                Sub Task
                                                            </div>

                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                            <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                 style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                New
                                                            </div>
                                                        </div>

                                                        <!--======= hidden ==========-->
                                                        <input type="hidden" name="menuNo" value="4">
                                                        <input type="hidden" name="sub_task_id"
                                                               value="<?= $task->getSubTaskID() ?>">
                                                    </div>

                                                    <div class="modal-body"
                                                         style="background-color: var(--lighter-secondary);">

                                                        <!-- ===== select Main Task ======= -->
                                                        <div class="d-flex mt-2 px-5">
                                                            <div class="d-flex w-100 rounded p-2"
                                                                 style="background-color: var(--secondary)">
                                                                <div class="ms-1 me-auto my-auto fw-bold"
                                                                     style="font-size: 0.8rem;">Select <br>
                                                                    Main Task
                                                                </div>
                                                                <select class="form-select ms-auto me-0"
                                                                        style="width: 50%;"
                                                                        name="main_task" id="" required>
                                                                    <option class="text-center" value="" selected>--
                                                                        Main Task --
                                                                    </option>
                                                                    <?php
                                                                    foreach ($mainTasks as $mainTask) {
                                                                        $mainT = new MainTask($mainTask->getMainTaskID());
                                                                        $mainT->loadMainTaskFromTaskID($con);
                                                                        ?>
                                                                        <option value="<?= $mainT->getMainTaskID() ?>" <?php if ($task->getMainTaskID() == $mainT->getMainTaskID()) echo "selected" ?>> <?= $mainT->getMainTaskName() ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- ====== input Sub Task & Description ====== -->
                                                        <div class="d-flex mt-2 px-5">
                                                            <input class="form-control text-center"
                                                                   name="sub_task"
                                                                   value="<?= $task->getSubTaskName() ?>"
                                                                   placeholder="Sub Task" required/>
                                                        </div>
                                                        <div class="d-flex mt-2 px-5">
                                                            <input class="form-control text-center"
                                                                   name="description"
                                                                   value="<?= $task->getDescription() ?>"
                                                                   placeholder="Description"/>
                                                        </div>

                                                        <!-- ===== select Team Category ======= -->
                                                        <div class="d-flex mt-2 px-5">
                                                            <div class="d-flex w-100 rounded p-2"
                                                                 style="background-color: var(--secondary)">
                                                                <div class="ms-1 me-auto my-auto fw-bold"
                                                                     style="font-size: 0.8rem;">Select <br>
                                                                    Team Category

                                                                </div>
                                                                <select class="form-select ms-auto me-0"
                                                                        style="width: 50%;"
                                                                        name="team_category"
                                                                        onchange="displaySelectedTeamMembersInEdit(<?= $subTaskNo ?>)"
                                                                        id="selected-team-cat-in-edit-subtask-<?= $subTaskNo ?>">
                                                                    <option class="text-center" value="" selected>--
                                                                        Team Category --
                                                                    </option>
                                                                    <?php

                                                                    foreach ($teamCategories as $teamCategory) {
                                                                        ?>
                                                                        <option value="<?= $teamCategory->getCategoryID() ?>"><?= $teamCategory->getCategoryName() ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- ===== select Team Member ======= -->
                                                        <div class="d-flex mt-2 px-5">
                                                            <div class="d-flex w-100 rounded p-2"
                                                                 style="background-color: var(--secondary)">
                                                                <div class="ms-1 me-auto my-auto fw-bold"
                                                                     style="font-size: 0.8rem;">Select <br>
                                                                    Team Member

                                                                </div>
                                                                <select class="form-select ms-auto me-0"
                                                                        style="width: 50%;"
                                                                        name="selected-team-cat-members"
                                                                        id="selected-team-cat-members-in-edit-<?= $subTaskNo ?>"
                                                                        required>
                                                                    <option class="text-center"
                                                                            value="<?= $task->getAssignedMemberID() ?>"
                                                                            selected>
                                                                        <?php
                                                                        $member = new Undergraduate(null, null, null, null, null, null);
                                                                        $member->setUserId($task->getAssignedMemberID());
                                                                        $member->loadDataFromUserID($con);
                                                                        echo $member->getFirstName() . " " . $member->getLastName();
                                                                        ?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex mt-2 px-5 w-100">
                                                            <div class="d-flex w-100 rounded p-2"
                                                                 style="background-color: var(--secondary)">
                                                                <div class="ms-1 me-auto my-auto fw-bold"
                                                                     style="font-size: 0.8rem;">completion
                                                                    <br>
                                                                    Date & Time
                                                                </div>
                                                                <div class="d-flex ms-auto me-0">
                                                                    <input class="form-control text-center me-2"
                                                                           type="date" required
                                                                           style="width: fit-content"
                                                                           value="<?= date('Y-m-d', strtotime($task->getDeadline())); ?>"
                                                                           name="completion_date"/>
                                                                    <input class="form-control text-center"
                                                                           style="width: fit-content"
                                                                           value="<?= date('H:i', strtotime($task->getDeadline())); ?>"
                                                                           type="time" required
                                                                           name="completion_time"/>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!--====== display error ========-->
                                                        <div class="mt-2 text-center" id="add-member-team-error"
                                                             style="color: var(--accent-color3)"></div>

                                                    </div>
                                                    <div class="modal-footer"
                                                         style="background-color: var(--primary);">
                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                name="edit_sub_task"
                                                                class="btn fw-bold"
                                                                style="background-color: var(--secondary); color: var(--primary);">
                                                            ADD
                                                        </button>

                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                    </div>

                                    <!-- =========== Delete Subtask button model =========== -->
                                    <div class="modal fade"
                                         id="delete-sub-task-<?= $subTaskNo ?>"
                                         tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="exampleModalCenterTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <!--=== form =====-->
                                                <form action="process/projectdashboard/deleteSubTask.php"
                                                      method="post">
                                                    <div class="modal-header py-2 px-2"
                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                            <div class="ms-2 my-auto fs-4 fw-bold">Sub Task
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
                                                               value="4">
                                                        <input type="hidden" name="sub_task_id"
                                                               value="<?= $task->getSubTaskID() ?>">

                                                    </div>

                                                    <div class="modal-body"
                                                         style="background-color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-column fw-normal fs-5">
                                                            <div class="fw-bold">
                                                                Do you want to Delete this Sub Task ?
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="fw-bold rounded d-flex p-1"
                                                                     style="background-color: var(--primary);color: var(--lighter-secondary); font-size: 1.1rem;">
                                                                    <div class="me-2 my-auto"><?= $task->getMainTaskName() ?></div>

                                                                    <div class="fw-bold rounded-end p-1"
                                                                         style="background-color: var(--lighter-secondary);color: var(--primary); font-size: 1.1rem;">
                                                                        <?= $task->getSubTaskName() ?>
                                                                    </div>
                                                                </div>
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
                            $subTaskNo++;
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
