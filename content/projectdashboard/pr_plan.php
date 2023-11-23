<?php
require_once "classes/PRTask.php";
require_once "classes/User.php";

use classes\PRTask;
use classes\Undergraduate;
?>

<div class="container-fluid">
    <div class="row d-flex">
        <div class="col-11 mx-auto">
            <div class="d-flex flex-column mt-3 mb-2">
                <div class="d-flex my-3 mx-auto w-100">
                    <!-- ======= define PR dropdowns ======== -->
                    <div class="d-flex ms-0 me-auto my-auto">
                        <form action="process/projectdashboard/definePRTeams.php" method="POST" class="d-flex"
                              style="height: fit-content">
                            <div class="d-flex w-100 rounded p-2"
                                 style="background-color: var(--secondary)">
                                <div class="ms-1 me-auto my-auto fw-bold"
                                     style="font-size: 0.8rem;">Define<br>Design Team

                                </div>
                                <select id="design_team_id" class="form-select" onchange="defineSubmit()"
                                        style="width: 50%;"
                                        name="design_team_id" id="" required>

                                    <option class="text-center" value="null">-- Define Design Team --
                                    </option>
                                    <?php
                                    $isSelected = "";
                                    foreach ($teamCategories as $teamCategory) {
                                        if ($project->getDesignTeamID() == $teamCategory->getCategoryID()) {
                                            $isSelected = "selected";
                                        } else {
                                            $isSelected = "";
                                        }
                                        ?>
                                        <option value="<?= $teamCategory->getCategoryID() ?>" <?= $isSelected ?>><?= $teamCategory->getCategoryName() ?></option>
                                        <?php

                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex ms-2 w-100 rounded p-2"
                                 style="background-color: var(--secondary)">
                                <select id="sec_team_id" class="form-select ms-2" onchange="defineSubmit()"
                                        style="width: 50%;"
                                        name="sec_team_id" id="" required>
                                    <option class="text-center" value="null" selected>-- Define Writing Team --
                                    </option>
                                    <?php
                                    $isSelected = "";
                                    foreach ($teamCategories as $teamCategory) {
                                        if ($project->getWritingTeamID() == $teamCategory->getCategoryID()) {
                                            $isSelected = "selected";
                                        } else {
                                            $isSelected = "";
                                        }
                                        ?>
                                        <option value="<?= $teamCategory->getCategoryID() ?>" <?= $isSelected ?>><?= $teamCategory->getCategoryName() ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="ms-auto me-1 my-auto fw-bold text-end"
                                     style="font-size: 0.8rem;">Define<br>Writing Team

                                </div>
                            </div>
                            <!--======= hidden ==========-->
                            <input type="hidden" name="menuNo" value="5">
                            <input type="hidden" name="project_id"
                                   value="<?= $project->getProjectID() ?>">
                            <input class="d-none" type="submit" name="define_submit"
                                   id="define_submit"/>

                        </form>
                    </div>

                    <!-- ======= add task button ======== -->
                    <?php
                    $isDisabled = "disabled";
                    if ($project->getDesignTeamID() != null && $project->getWritingTeamID() != null) {
                        $isDisabled = "";
                    }
                    ?>
                    <div class="btn fw-bold my-auto me-0 ms-auto d-flex <?= $isDisabled ?>"
                         style="color: var(--lighter-secondary) !important; background-color: var(--primary); height: fit-content"
                         type="button" data-bs-toggle="modal"
                         data-bs-target="#add-new-task">
                        <ion-icon class="my-auto" name="add-outline"></ion-icon>
                        <div class="my-auto">Task</div>
                    </div>
                </div>

                <!-- ========= add task button model ========== -->
                <div class="modal fade"
                     id="add-new-task"
                     tabindex="-1"
                     role="dialog"
                     aria-labelledby="exampleModalCenterTitle"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"
                         role="document">
                        <div class="modal-content">
                            <!--=== form =====-->
                            <form action="process/projectdashboard/addNewPRTask.php" method="POST">
                                <div class="modal-header py-2 px-2"
                                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                    <div class="d-flex flex-row w-100 justify-content-between">

                                        <div class="ms-2 my-auto fs-4 fw-bold">
                                            Task
                                        </div>

                                        <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                        <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                        <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                             style="font-size: 1.3rem; color: var(--accent-color2);">
                                            New
                                        </div>
                                    </div>

                                    <!--======= hidden ==========-->
                                    <input type="hidden" name="menuNo" value="5">
                                </div>

                                <div class="modal-body"
                                     style="background-color: var(--lighter-secondary);">
                                    <!-- ====== input topic and description ====== -->
                                    <div class="d-flex mt-2 px-5">
                                        <input class="form-control text-center"
                                               name="topic" id="add-topic"
                                               placeholder="Topic" required/>
                                    </div>
                                    <div class="d-flex mt-2 px-5">
                                        <input class="form-control text-center"
                                               name="description" id="add-description"
                                               placeholder="Description"/>
                                    </div>
                                    <!-- ===== select team ======= -->
                                    <div class="d-flex mt-2 px-5">
                                        <div class="d-flex w-100 rounded p-2"
                                             style="background-color: var(--secondary)">
                                            <div class="ms-1 me-auto my-auto fw-bold"
                                                 style="font-size: 0.8rem;">Select
                                                Design <br>
                                                Team Member

                                            </div>
                                            <select id="designer_id" class="form-select ms-auto me-0"
                                                    style="width: 50%;"
                                                    name="designer_id" id="" required>
                                                <option class="text-center" value="" selected>-- Select Designer
                                                    --
                                                </option>
                                                <?php
                                                foreach ($desingTeamMembers as $desingTeamMember) {
                                                    $member = new Undergraduate(null, null, null, null, null, null);
                                                    $member->setUserId($desingTeamMember->getUgID());
                                                    $member->loadDataFromUserID($con);
                                                    ?>
                                                    <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2 px-5">
                                        <div class="d-flex w-100 rounded p-2"
                                             style="background-color: var(--secondary)">
                                            <div class="ms-1 me-auto my-auto fw-bold"
                                                 style="font-size: 0.8rem;">Select
                                                Writing <br>
                                                Team Member

                                            </div>
                                            <select id="caption_writer_id" class="form-select ms-auto me-0"
                                                    style="width: 50%;"
                                                    name="caption_writer_id" id="" required>
                                                <option class="text-center" value="" selected>-- Select Caption
                                                    Writter
                                                    --
                                                </option>
                                                <?php
                                                foreach ($writingTeamMembers as $writingTeamMember) {
                                                    $member = new Undergraduate(null, null, null, null, null, null);
                                                    $member->setUserId($writingTeamMember->getUgID());
                                                    $member->loadDataFromUserID($con);
                                                    ?>
                                                    <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="mt-2 text-center" id="add-member-team-error"
                                         style="color: var(--accent-color3)"></div>

                                    <div class="d-flex mt-2 px-5 w-100">
                                        <div class="d-flex w-100 rounded p-2"
                                             style="background-color: var(--secondary)">
                                            <div class="ms-1 me-auto my-auto fw-bold"
                                                 style="font-size: 0.8rem;">Publish <br> Date & Time
                                            </div>
                                            <div class="d-flex ms-auto me-0">
                                                <input class="form-control text-center me-2" type="date"
                                                       required
                                                       style="width: fit-content"
                                                       name="publish_date"/>
                                                <input class="form-control text-center"
                                                       style="width: fit-content"
                                                       type="time" required
                                                       name="publish_time"/>
                                            </div>

                                        </div>
                                    </div>
                                    <!--======= hidden ==========-->
                                    <input type="hidden" name="menuNo" value="5">
                                    <input type="hidden" name="project_id"
                                           value="<?= $project->getProjectID() ?>">

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


                <!-- ========== member table ============ -->
                <div class="card" style="height: fit-content;">
                    <div class="card-header team-member-table pb-0"
                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                        <div class="row p-0 fw-bold">
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--primary);">
                                Published
                            </div>
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                Publish Date
                            </div>
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--primary);">Time
                            </div>
                            <div class="col-2 text-center py-2 rounded-top-3"
                                 style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                Topic
                            </div>
                            <div class="col-3 text-center py-2 rounded-top-3"
                                 style="background-color: var(--primary);">
                                Description
                            </div>
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                Designer
                            </div>
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--primary);">
                                Caption Writter
                            </div>
                            <div class="col-1 text-center py-2 rounded-top-3"
                                 style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                Verify
                            </div>
                            <div class="col-1">

                            </div>
                        </div>

                    </div>

                    <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                         style="background-color: var(--secondary);">
                        <div class="container p-0 scrollable-div-inside">

                            <?php
                            $prTaskNo = 1;
                            foreach ($PRTasks as $PRTask) {
                                $task = new PRTask($PRTask->getprID(), null, null, null, null, null, null);
                                $task->loadTaskFromPRId($con);

                                ?>

                                <div class="row mb-2 shadow-sm set-border" style="height: 50px;">

                                    <div class="col-1 tabel-column-type-1 d-flex"
                                         style="font-size: 1.8rem; ">
                                        <form action="process/projectdashboard/editPRTask.php" class="d-flex"
                                              method="POST">
                                            <input type="checkbox"
                                                   class="my-auto ms-3 me-auto form-check-input"
                                                   style="background-color: var(--primary);border-color: var(--accent-color3) ; border-width: 2.5px;"
                                                   name="is_published"
                                                   value="published"
                                                <?php if ($task->getisVerifyByProjectChair() == 0) echo "disabled" ?>
                                                <?php if ($task->getisPublished() == 1) echo "checked" ?>
                                                   onchange="updatePRSubmit(<?= $prTaskNo ?>,1)">
                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="5">
                                            <input type="hidden" name="pr_id"
                                                   value="<?= $task->getprID() ?>">
                                            <input class="d-none" type="submit" name="pr_update_submit_1"
                                                   id="pr_update_submit_1_<?= $prTaskNo ?>"/>
                                        </form>
                                    </div>
                                    <div class="col-1 tabel-column-type-2 d-flex justify-content-center">
                                        <div class="my-auto d-flex flex-column">
                                            <div class="d-flex mx-auto fw-lighter"
                                                 style="font-size: 0.8rem;"><?= date("Y", strtotime($task->getpublishDate())) ?></div>
                                            <div class="d-flex mx-auto">
                                                <div class="me-1"><?= date("M", strtotime($task->getpublishDate())) ?></div>
                                                <div><?= date("d", strtotime($task->getpublishDate())) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1 tabel-column-type-1 d-flex justify-content-center">
                                        <div class="my-auto"><?= date("g:i A", strtotime($task->getpublishDate())) ?></div>
                                    </div>
                                    <div class="col-2 tabel-column-type-2 d-flex justify-content-center">
                                        <div class="my-auto fw-bold"><?= $task->gettopic() ?></div>
                                    </div>
                                    <div class="col-3 tabel-column-type-1 d-flex justify-content-center">
                                        <div class="my-auto text-center"><?= $task->getdescription() ?></div>
                                    </div>
                                    <div class="col-1 tabel-column-type-2 d-flex justify-content-center"
                                         style="font-size: 0.8rem; text-align: center">
                                        <?php
                                        $disgner = new Undergraduate(null, null, null, null, null, null);
                                        $disgner->setUserId($task->getdesignerID());
                                        $disgner->loadDataFromUserID($con);
                                        ?>
                                        <div class="my-auto"><?= $disgner->getFirstName() ?>
                                            <br><?= $disgner->getLastName() ?></div>
                                    </div>
                                    <div class="col-1 tabel-column-type-1 d-flex justify-content-center"
                                         style="font-size:0.8rem ;text-align: center;">
                                        <?php
                                        $writer = new Undergraduate(null, null, null, null, null, null);
                                        $writer->setUserId($task->getcaptionWriterID());
                                        $writer->loadDataFromUserID($con);
                                        ?>
                                        <div class="my-auto"><?= $writer->getFirstName() ?>
                                            <br><?= $writer->getLastName() ?></div>
                                    </div>

                                    <div class="col-1 tabel-column-type-2 d-flex justify-content-center"
                                         style="font-size: 1.3rem;">
                                        <form action="process/projectdashboard/editPRTask.php" class="d-flex"
                                              method="POST">
                                            <input type="checkbox"
                                                   class="my-auto form-check-input"
                                                   style="background-color: var(--accent-color3); border-color: yellow;border-width: 1.2px"
                                                   name="is_verify" value="verified"
                                                <?php if ($task->getisPublished() == 1) echo "disabled" ?>
                                                <?php if ($task->getisVerifyByProjectChair() == 1) echo "checked" ?>
                                                   onchange="updatePRSubmit(<?= $prTaskNo ?>,2)">
                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="5">
                                            <input type="hidden" name="pr_id"
                                                   value="<?= $task->getprID() ?>">
                                            <input class="d-none" type="submit" name="pr_update_submit_2"
                                                   id="pr_update_submit_2_<?= $prTaskNo ?>"/>
                                        </form>
                                    </div>

                                    <div class="col-1 tabel-column-type-1 d-flex justify-content-center"
                                         style="font-size: 1.5rem">
                                        <!-- ========= edit task button ========== -->
                                        <ion-icon class="my-auto me-2" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#edit-pr-task-<?= $prTaskNo ?>"
                                                  name="create-outline"></ion-icon>

                                        <!-- ========= edit task button model ========== -->
                                        <div class="modal fade"
                                             id="edit-pr-task-<?= $prTaskNo ?>"
                                             tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="exampleModalCenterTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered"
                                                 role="document">
                                                <div class="modal-content">
                                                    <!--=== form =====-->
                                                    <form action="process/projectdashboard/editPRTask.php"
                                                          class=""
                                                          method="POST">
                                                        <div class="modal-header py-2 px-2"
                                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                                    Task
                                                                </div>

                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                    Edit
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-body"
                                                             style="background-color: var(--lighter-secondary);">
                                                            <!-- ====== edit topic and description ====== -->
                                                            <div class="d-flex mt-2 px-5">
                                                                <input class="form-control text-center"
                                                                       name="topic" id="edit-topic"
                                                                       value="<?= $task->gettopic() ?>"/>

                                                            </div>
                                                            <div class="d-flex mt-2 px-5">
                                                                <input class="form-control text-center"
                                                                       name="description"
                                                                       id="edit-description"
                                                                       value="<?= $task->getdescription() ?>"/>

                                                            </div>
                                                            <!-- ===== select design team member ======= -->
                                                            <div class="d-flex mt-2 px-5">
                                                                <div class="d-flex w-100 rounded p-2"
                                                                     style="background-color: var(--secondary)">
                                                                    <div class="ms-1 me-auto my-auto fw-bold"
                                                                         style="font-size: 0.8rem;">Select
                                                                        Design <br>
                                                                        Team Member

                                                                    </div>
                                                                    <select id="designer_id"
                                                                            class="form-select ms-auto me-0"
                                                                            style="width: 50%;"
                                                                            name="designer_id" required>
                                                                        <?php
                                                                        $member = new Undergraduate(null, null, null, null, null, null);
                                                                        $member->setUserId($task->getdesignerID());
                                                                        $member->loadDataFromUserID($con);
                                                                        ?>
                                                                        <option
                                                                                value="<?= $member->getUserId() ?>"
                                                                                selected><?= $member->getFirstName() ?> <?= $member->getLastName() ?>
                                                                        </option>
                                                                        <?php
                                                                        foreach ($desingTeamMembers as $desingTeamMember) {
                                                                            $member = new Undergraduate(null, null, null, null, null, null);
                                                                            $member->setUserId($desingTeamMember->getUgID());
                                                                            $member->loadDataFromUserID($con);
                                                                            if ($task->getdesignerID() !== $member->getUserId()) { // prevent print same name twice
                                                                                ?>
                                                                                <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <!-- ===== select design team member ======= -->
                                                            <div class="d-flex mt-2 px-5">
                                                                <div class="d-flex w-100 rounded p-2"
                                                                     style="background-color: var(--secondary)">
                                                                    <div class="ms-1 me-auto my-auto fw-bold"
                                                                         style="font-size: 0.8rem;">Select
                                                                        Writing <br>
                                                                        Team Member

                                                                    </div>
                                                                    <select id="caption_writer_id"
                                                                            class="form-select ms-auto me-0"
                                                                            style="width: 50%;"
                                                                            name="caption_writer_id" id=""
                                                                            required>
                                                                        <?php
                                                                        $member = new Undergraduate(null, null, null, null, null, null);
                                                                        $member->setUserId($task->getcaptionWriterID());
                                                                        $member->loadDataFromUserID($con);
                                                                        ?>
                                                                        <option
                                                                                value="<?= $member->getUserId() ?>"
                                                                                selected><?= $member->getFirstName() ?> <?= $member->getLastName() ?>
                                                                        </option>
                                                                        <?php
                                                                        foreach ($writingTeamMembers as $writingTeamMember) {
                                                                            $member = new Undergraduate(null, null, null, null, null, null);
                                                                            $member->setUserId($writingTeamMember->getUgID());
                                                                            $member->loadDataFromUserID($con);
                                                                            if ($task->getcaptionWriterID() !== $member->getUserId()) { // prevent print same name twice
                                                                                ?>
                                                                                <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                </div>

                                                            </div>


                                                            <div class="mt-2 text-center"
                                                                 id="add-member-team-error"
                                                                 style="color: var(--accent-color3)"></div>

                                                            <div class="d-flex mt-2 px-5 w-100">
                                                                <div class="d-flex w-100 rounded p-2"
                                                                     style="background-color: var(--secondary)">
                                                                    <div class="ms-1 me-auto my-auto fw-bold"
                                                                         style="font-size: 0.8rem;">Publish
                                                                        <br> Date & Time
                                                                    </div>
                                                                    <div class="d-flex ms-auto me-0">
                                                                        <input class="form-control text-center me-2"
                                                                               type="date" required
                                                                               style="width: fit-content"
                                                                               value="<?= date('Y-m-d', strtotime($task->getpublishDate())); ?>"
                                                                               name="publish_date"/>
                                                                        <input class="form-control text-center"
                                                                               style="width: fit-content"
                                                                               type="time" required
                                                                               value="<?= date('H:i', strtotime($task->getpublishDate())); ?>"
                                                                               name="publish_time"/>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <!--======= hidden ==========-->
                                                            <input type="hidden" name="menuNo" value="5">
                                                            <input type="hidden" name="pr_id"
                                                                   value="<?= $task->getprID() ?>">
                                                        </div>
                                                        <div class="modal-footer"
                                                             style="background-color: var(--primary);">
                                                            <button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit"
                                                                    name="pr_edit_submit"
                                                                    class="btn fw-bold"
                                                                    style="background-color: var(--secondary); color: var(--primary);">
                                                                Update
                                                            </button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!--======= delete pr task button ==========-->
                                        <ion-icon class="my-auto" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#delete-pr-task-<?= $prTaskNo ?>"
                                                  name="trash-outline"></ion-icon>

                                        <!-- =========== Delete pr task button model =========== -->
                                        <div class="modal fade"
                                             id="delete-pr-task-<?= $prTaskNo ?>"
                                             tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="exampleModalCenterTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered"
                                                 role="document">
                                                <div class="modal-content">
                                                    <!--=== form =====-->
                                                    <form action="process/projectdashboard/deletePRTask.php"
                                                          method="post">
                                                        <div class="modal-header py-2 px-2"
                                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                                    <?= $task->gettopic() ?>
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
                                                                   value="5">
                                                            <input type="hidden" name="pr_id"
                                                                   value="<?= $task->getprID() ?>">
                                                        </div>

                                                        <div class="modal-body"
                                                             style="background-color: var(--lighter-secondary);">
                                                            <div class="d-flex fw-normal fs-5">
                                                                Do you want to Delete this Task ?
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
                                $prTaskNo++;
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>